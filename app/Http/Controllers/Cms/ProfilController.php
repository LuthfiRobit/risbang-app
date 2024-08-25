<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Profil;
use App\Services\DataActiveService;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class ProfilController extends Controller
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
        return view('cms.profil.index');
    }

    public function showProfil()
    {
        $query = Profil::first();

        if ($query) {
            $query['id_cript'] = Crypt::encryptString($query->id_profil);
            return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $query], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => $query], 400);
        }
    }

    public function listAnggota(Request $request)
    {
        $query = Anggota::select('id_anggota', 'nama', 'jabatan', 'urutan', 'img_anggota')
            ->orderBy('urutan', 'ASC');

        $result = $query->get()
            ->map(function ($q) {
                return [
                    'action' => Crypt::encryptString($q->id_anggota),
                    'urutan' => $q->urutan,
                    'profil' => asset('imgs/anggota') . '/' . $q->img_anggota,
                    'nama' => $q->nama,
                    'jabatan' => $q->jabatan
                ];
            });

        return DataTables::of($result)
            ->addIndexColumn()
            ->toJson();
    }

    public function showAnggota(string $id)
    {
        $id = Crypt::decryptString($id);
        // Mengambil data pengumuman berdasarkan slug
        $data = Anggota::where('id_anggota', $id)
            ->first();
        if ($data) {
            $data['id_cript'] = Crypt::encryptString($data->id_anggota);
            return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $data], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => $data], 400);
        }
    }

    public function storeProfil(Request $request)
    {
        // Mendefinisikan aturan validasi untuk input
        $validationRules = [
            'visi' => 'required|string',
            'misi' => 'required|string',
            'tujuan' => 'required|string',
            'alamat' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|regex:/^\+?[0-9\s]*$/',
        ];

        // Memvalidasi data yang diterima dari request sesuai dengan aturan yang ditentukan
        $validateData = $this->permissionService->validateData($request->all(), $validationRules);

        // Jika ada kesalahan validasi, kembalikan hasil validasi
        if ($validateData !== null) {
            return $validateData;
        }

        // Mendapatkan data dari request dan mengganti nama field sesuai kebutuhan
        $data = [
            'visi' => $request->visi,
            'misi' => $request->misi,
            'tujuan' => $request->tujuan,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'no_tlpn' => $request->phone, // Mengganti nama field
        ];

        // Memulai transaksi database untuk memastikan semua operasi berhasil atau tidak sama sekali
        DB::beginTransaction();
        try {
            // Mengecek apakah ada data di tabel profil
            $profil = Profil::first(); // Mengambil baris pertama (dan satu-satunya) dari tabel profil

            if ($profil) {
                // Jika data sudah ada, lakukan update
                $profil->update($data);
            } else {
                // Jika data belum ada, lakukan insert
                Profil::create($data);
            }

            // Menyelesaikan transaksi jika semua operasi berhasil
            DB::commit();
            // Mengembalikan respons sukses dengan pesan dan data yang disimpan
            return $this->permissionService->successResponse('Data berhasil disimpan', $data);
        } catch (\Throwable $th) {
            // Membatalkan transaksi jika terjadi kesalahan
            DB::rollBack();
            // Mencatat kesalahan ke log
            Log::error('Update profil: ' . $th->getMessage());
            // Mengembalikan respons error jika terjadi kesalahan
            return $this->permissionService->errorResponse('Data gagal disimpan');
        }
    }

    public function storeAnggota(Request $request)
    {
        // Mendefinisikan aturan validasi untuk input
        $validationRules = [
            'nama' => 'required|string',
            'jabatan' => 'required|string',
            'urutan' => 'required|integer',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:3072', // Validasi gambar
        ];

        // Memvalidasi data yang diterima dari request sesuai dengan aturan yang ditentukan
        $validateData = $this->permissionService->validateData($request->all(), $validationRules);

        // Jika ada kesalahan validasi, kembalikan hasil validasi
        if ($validateData !== null) {
            return $validateData;
        }

        // Mendapatkan data dari request
        $data = [
            'nama' => $request->input('nama'),
            'jabatan' => $request->input('jabatan'),
            'urutan' => $request->input('urutan'),
        ];

        // Memulai transaksi database untuk memastikan semua operasi berhasil atau tidak sama sekali
        DB::beginTransaction();
        try {
            // Menambahkan data baru ke tabel anggota (tanpa gambar terlebih dahulu)
            $anggota = Anggota::create($data);
            if ($anggota) {
                // Mendapatkan file gambar dari request
                $gambar = $request->file('gambar');
                // Membuat nama file gambar yang unik dengan menambahkan prefix dan ekstensi asli gambar
                $gambar_name = 'IA_' . uniqid() . '.' . $gambar->getClientOriginalExtension();
                // Menentukan folder tempat menyimpan gambar
                $gambar_folder = 'imgs/anggota';
                // Memindahkan file gambar ke folder yang ditentukan
                $gambar->move($gambar_folder, $gambar_name);

                // Mengupdate data anggota dengan nama file gambar
                $anggota->update(['img_anggota' => $gambar_name]);
            }

            // Menyelesaikan transaksi jika semua operasi berhasil
            DB::commit();
            // Mengembalikan respons sukses dengan pesan dan data yang disimpan
            return $this->permissionService->successResponse('Data berhasil disimpan', $anggota);
        } catch (\Throwable $th) {
            // Membatalkan transaksi jika terjadi kesalahan
            DB::rollBack();
            // Mencatat kesalahan ke log
            Log::error('Tambah anggota: ' . $th->getMessage());
            // Mengembalikan respons error jika terjadi kesalahan
            return $this->permissionService->errorResponse('Data gagal disimpan');
        }
    }

    public function updateAnggota(Request $request, string $id)
    {
        $id = Crypt::decryptString($id);
        // Mendefinisikan aturan validasi untuk input
        $validationRules = [
            'nama' => 'required|string',
            'jabatan' => 'required|string',
            'urutan' => 'required|integer',
            'gambar' => $request->hasFile('gambar') ? 'mimes:jpeg,jpg,png|max:3072' : 'nullable',
        ];

        // Memvalidasi data yang diterima dari request sesuai dengan aturan yang ditentukan
        $validateData = $this->permissionService->validateData($request->all(), $validationRules);

        // Jika ada kesalahan validasi, kembalikan hasil validasi
        if ($validateData !== null) {
            return $validateData;
        }

        // Mendapatkan data dari request
        $data = [
            'nama' => $request->input('nama'),
            'jabatan' => $request->input('jabatan'),
            'urutan' => $request->input('urutan'),
        ];

        // Memulai transaksi database untuk memastikan semua operasi berhasil atau tidak sama sekali
        DB::beginTransaction();
        try {
            // Menemukan anggota yang akan diperbarui
            $anggota = Anggota::findOrFail($id);

            // Jika ada gambar baru yang diunggah
            if ($request->hasFile('gambar')) {
                // Hapus gambar lama jika ada
                if ($anggota->img_anggota) {
                    $oldImagePath = public_path('imgs/anggota/' . $anggota->img_anggota);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                // Menyimpan gambar baru
                $gambar = $request->file('gambar');
                $gambar_name = 'IA_' . uniqid() . '.' . $gambar->getClientOriginalExtension();
                $gambar_folder = 'imgs/anggota';
                $gambar->move($gambar_folder, $gambar_name);

                // Mengupdate data anggota dengan nama file gambar baru
                $data['img_anggota'] = $gambar_name;
            }

            // Mengupdate data anggota
            $anggota->update($data);

            // Menyelesaikan transaksi jika semua operasi berhasil
            DB::commit();
            // Mengembalikan respons sukses dengan pesan dan data yang diperbarui
            return $this->permissionService->successResponse('Data berhasil diperbarui', $anggota);
        } catch (\Throwable $th) {
            // Membatalkan transaksi jika terjadi kesalahan
            DB::rollBack();
            // Mencatat kesalahan ke log
            Log::error('Update anggota: ' . $th->getMessage());
            // Mengembalikan respons error jika terjadi kesalahan
            return $this->permissionService->errorResponse('Data gagal diperbarui');
        }
    }
}
