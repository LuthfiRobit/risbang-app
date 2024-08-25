<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Services\DataActiveService;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class BeritaController extends Controller
{
    protected PermissionService $permissionService;
    protected DataActiveService $dataActiveService;
    protected $userId;
    protected $dosenId;
    protected $reviewerId;
    protected $kaprodiId;
    protected $dekanId;
    protected $userRole;
    protected $dosenRole;

    public function __construct(PermissionService $permissionService, DataActiveService $dataActiveService)
    {
        $this->permissionService = $permissionService;
        $this->dataActiveService = $dataActiveService;
        $this->middleware(
            function ($request, $next) {
                $this->userId = Auth::user()->id_user;
                $this->dosenId = Auth::user()->user_role == 'dosen'  && Auth::user()->dosen_role == 'dosen' ? Auth::user()->dosen->id_dosen : null;
                $this->reviewerId = Auth::user()->user_role == 'reviewer' ? Auth::user()->reviewer->id_reviewer : null;
                $this->kaprodiId = Auth::user()->user_role == 'dosen' && Auth::user()->dosen_role == 'kaprodi' ? Auth::user()->kaprodi->id_prodi : null;
                $this->dekanId =  Auth::user()->user_role == 'dosen' && Auth::user()->dosen_role == 'dekan' ? Auth::user()->dekan->id_fakultas : null;
                $this->userRole = Auth::user()->user_role;
                $this->dosenRole = Auth::user()->dosen_role;
                return $next($request);
            }
        );
    }

    public function index()
    {
        return view('cms.berita.index');
    }

    public function create()
    {
        return view('cms.berita.create');
    }

    public function edit(string $id)
    {
        $id = Crypt::decryptString($id);
        // Mengambil data berita berdasarkan slug
        $berita = Berita::where('id_berita', $id)
            ->first();
        if ($berita) {
            return view('cms.berita.edit');
        } else {
            return redirect()->back()->with('fail', 'Data tidak ditemukan.');
        }
    }

    public function list(Request $request)
    {
        $query = Berita::select(
            'berita.id_berita',
            'berita.judul',
            'berita.created_at',
            'berita.publish',
        )->orderBy('berita.created_at', 'DESC');

        $result = $query->get()
            ->map(function ($q) {
                return [
                    'action' => Crypt::encryptString($q->id_berita),
                    'tanggal' => $q->created_at->format('d F Y H:i'),
                    'judul' => $q->judul,
                    'publish' => $q->publish === 'y' ? 'y' : 't'
                ];
            });

        return DataTables::of($result)
            ->addIndexColumn()
            ->toJson();
    }

    public function show(string $id)
    {
        $id = Crypt::decryptString($id);
        // Mengambil data berita berdasarkan slug
        $data = Berita::where('id_berita', $id)
            ->first();
        if ($data) {
            $data['id_cript'] = Crypt::encryptString($data->id_berita);
            return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $data], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => $data], 400);
        }
    }

    public function store(Request $request)
    {
        // Mendefinisikan aturan validasi untuk input
        $validationRules = [
            'judul' => 'required', // 'judul' harus diisi
            'deskripsi' => 'required', // 'deskripsi' harus diisi
            'gambar' => 'required|mimes:jpeg,jpg,png|max:3072' // 'gambar' harus ada, harus berupa file dengan ekstensi jpeg, jpg, atau png, dan tidak lebih dari 3MB
        ];

        // Memvalidasi data yang diterima dari request sesuai dengan aturan yang ditentukan
        $validateData = $this->permissionService->validateData($request->all(), $validationRules);

        // Jika ada kesalahan validasi, kembalikan hasil validasi
        if ($validateData !== null) {
            return $validateData;
        }

        // Mendapatkan file gambar dari request
        $gambar = $request->file('gambar');
        // Membuat nama file gambar yang unik dengan menambahkan prefix dan ekstensi asli gambar
        $gambar_name = 'GB_' . uniqid() . '.' . $gambar->getClientOriginalExtension();

        // Membuat slug dari judul yang diterima dari request
        $slug = $this->createSlug($request->judul);

        // Memulai transaksi database untuk memastikan semua operasi berhasil atau tidak sama sekali
        DB::beginTransaction();
        try {
            // Menyiapkan data untuk disimpan ke database
            $save['judul'] = $request->judul; // Menyimpan judul
            $save['deskripsi'] = $request->deskripsi; // Menyimpan deskripsi
            $save['slug'] = $slug; // Menyimpan slug yang dibuat dari judul
            $save['publish'] = $request->has('publish') ? $request->publish : 't'; // Menyimpan status publish, default ke 't' jika tidak ada
            $save['img_berita'] = $gambar_name; // Menyimpan nama file gambar
            $save['created_by'] = $this->userRole == 'admin' ? $this->userRole . '-' . Auth::user()->username : $this->dosenRole . '-' . Auth::user()->username;

            // Menyimpan data ke model Berita dan database
            $store = Berita::create($save);

            // Jika data berhasil disimpan
            if ($store) {
                // Menentukan folder tempat menyimpan gambar
                $gambar_folder = 'imgs/berita';
                // Memindahkan file gambar ke folder yang ditentukan
                $gambar->move($gambar_folder, $gambar_name);
            }

            // Menyelesaikan transaksi jika semua operasi berhasil
            DB::commit();
            // Mengembalikan respons sukses dengan pesan dan data yang disimpan
            return $this->permissionService->successResponse('data berhasil dibuat', $save);
        } catch (\Throwable $th) {
            // Membatalkan transaksi jika terjadi kesalahan
            DB::rollBack();
            // Mencatat kesalahan ke log
            Log::error('Create berita: ' . $th->getMessage());
            // Mengembalikan respons error jika terjadi kesalahan
            return $this->permissionService->errorResponse('data gagal dibuat');
        }
    }

    public function update(Request $request, string $id)
    {
        $id = Crypt::decryptString($id);

        /** new */
        $validationRules = [
            'judul' => 'required', // 'judul' harus diisi
            'deskripsi' => 'required', // 'deskripsi' harus diisi
            'gambar' => $request->hasFile('gambar') ? 'mimes:jpeg,jpg,png|max:3072' : 'nullable',
        ];

        $validateData = $this->permissionService->validateData($request->all(), $validationRules);
        /** new */

        if ($validateData !== null) {
            return $validateData;
        }

        $berita = Berita::where('id_berita', $id)->first();
        if (!$berita) {
            return $this->permissionService->errorResponse('Data tidak ditemukan');
        }

        $gambar = $request->file('gambar');
        $gambar_name = $berita->img_berita;
        // Membuat slug dari judul yang diterima dari request
        $slug = $this->createSlug($request->judul);

        DB::beginTransaction();
        try {

            if ($gambar) {
                $gambar_folder = 'imgs/berita';
                // Hanya mencoba menghapus file jika $file_name tidak kosong atau null
                if (!empty($gambar_name) && file_exists($gambar_folder . '/' . $gambar_name)) {
                    unlink($gambar_folder . '/' . $gambar_name);
                }
                $gambar_name = 'GB_' . uniqid() . '.' . $gambar->getClientOriginalExtension();
                $gambar->move($gambar_folder, $gambar_name);
            }

            $berita->update([
                'judul' => $request->judul,
                'slug' => $slug,
                'deskripsi' => $request->deskripsi,
                'img_berita' => $gambar_name,
                'publish' => $request->has('publish') ? $request->publish : 't',
                'created_by' => $this->userRole == 'admin' ? $this->userRole . '-' . Auth::user()->username : $this->dosenRole . '-' . Auth::user()->username,
            ]);

            DB::commit();
            return $this->permissionService->successResponse('Data berhasil diupdate', $berita);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Update berita produk penelitian: ' . $th->getMessage());
            return $this->permissionService->errorResponse('Data gagal diupdate');
        }
    }

    // Fungsi untuk membuat slug dari judul
    protected function createSlug($title)
    {
        // Menghapus karakter non-alfanumerik dan mengganti spasi dengan tanda hubung
        // Fungsi preg_replace mengganti semua karakter non-alfanumerik dengan tanda hubung
        // Fungsi strtolower mengubah string menjadi huruf kecil
        // Fungsi trim menghapus tanda hubung di awal dan akhir string
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title), '-'));
    }
}
