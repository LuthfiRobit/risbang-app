<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use App\Services\DataActiveService;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class PengumumanController extends Controller
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
        return view('cms.pengumuman.index');
    }

    public function create()
    {
        return view('cms.pengumuman.create');
    }

    public function edit(string $id)
    {
        $id = Crypt::decryptString($id);
        // Mengambil data pengumuman berdasarkan slug
        $pengumuman = Pengumuman::where('id_pengumuman', $id)
            ->first();
        if ($pengumuman) {
            return view('cms.pengumuman.edit');
        } else {
            return redirect()->back()->with('fail', 'Data tidak ditemukan.');
        }
    }

    public function list(Request $request)
    {
        $query = Pengumuman::select(
            'pengumuman.id_pengumuman',
            'pengumuman.jenis',
            'pengumuman.judul',
            'pengumuman.created_at',
            'pengumuman.publish',
        )->orderBy('pengumuman.created_at', 'DESC');

        $result = $query->get()
            ->map(function ($q) {
                return [
                    'action' => Crypt::encryptString($q->id_pengumuman),
                    'jenis' => $q->jenis,
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
        // Mengambil data pengumuman berdasarkan slug
        $data = Pengumuman::where('id_pengumuman', $id)
            ->first();
        if ($data) {
            $data['id_cript'] = Crypt::encryptString($data->id_pengumuman);
            return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $data], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => $data], 400);
        }
    }

    public function store(Request $request)
    {
        // Validasi data input menggunakan permissionService
        $validateData = $this->permissionService->validateData($request->all(), [
            'jenis' => 'required',
            'judul' => 'required',
            'url' => 'nullable|url',
            'file' => 'nullable|mimes:pdf,doc,docx|max:3072', // max 3MB
        ]);

        if ($validateData !== null) {
            return $validateData;
        }

        $file = $request->file('file');
        $url = $request->input('url');

        // Validasi untuk memastikan hanya salah satu input yang diisi
        if (!$url && !$file) {
            return $this->permissionService->errorResponse('Anda harus mengisi link URL atau mengunggah file.');
        }

        if ($url && $file) {
            return $this->permissionService->errorResponse('Anda hanya bisa mengisi salah satu antara URL atau file.');
        }

        // Jika file diunggah, cek ukuran file
        if ($file && ($file->getSize() / 1024 / 1024) > 3) {
            if (!$url) {
                return $this->permissionService->errorResponse('Jika file lebih dari 3MB, Anda harus mengisi URL.');
            }
        }

        DB::beginTransaction();

        try {
            // Persiapan data untuk disimpan
            $save = [
                'jenis' => $request->input('jenis'),
                'judul' => $request->input('judul'),
                'deskripsi' => $request->input('deskripsi'),
                'publish' => $request->input('publish', 't'),
                'file_pengumuman' => null,
                'url' => $url, // Simpan URL jika ada
            ];

            // Menyimpan file jika diunggah
            if ($file) {
                $file_name = 'FPENG_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $save['file_pengumuman'] = $file_name;

                // Pindahkan file ke direktori yang ditentukan
                $file->move(public_path('files/pengumuman'), $file_name);
            }

            // Simpan data ke database
            Pengumuman::create($save);

            DB::commit();

            return $this->permissionService->successResponse('Data berhasil dibuat', $save);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Create pengumuman: ' . $th->getMessage());
            return $this->permissionService->errorResponse('Data gagal dibuat');
        }
    }

    public function update(Request $request, string $id)
    {
        $id = Crypt::decryptString($id);

        // Validasi data input menggunakan permissionService
        $validateData = $this->permissionService->validateData($request->all(), [
            'jenis' => 'required',
            'judul' => 'required',
            'url' => 'nullable|url',
            'file' => 'nullable|mimes:pdf,doc,docx|max:3072', // max 3MB
        ]);

        if ($validateData !== null) {
            return $validateData;
        }

        $file = $request->file('file');
        $url = $request->input('url');

        // Validasi untuk memastikan hanya salah satu input yang diisi
        if (!$url && !$file) {
            return $this->permissionService->errorResponse('Anda harus mengisi link URL atau mengunggah file.');
        }

        if ($url && $file) {
            return $this->permissionService->errorResponse('Anda hanya bisa mengisi salah satu antara URL atau file.');
        }

        // Jika file diunggah, cek ukuran file
        if ($file && ($file->getSize() / 1024 / 1024) > 3) {
            if (!$url) {
                return $this->permissionService->errorResponse('Jika file lebih dari 3MB, Anda harus mengisi URL.');
            }
        }

        // Fetch existing data
        $pengumuman = Pengumuman::findOrFail($id);

        DB::beginTransaction();

        try {
            // Persiapan data untuk diupdate
            $update = [
                'jenis' => $request->input('jenis'),
                'judul' => $request->input('judul'),
                'deskripsi' => $request->input('deskripsi'),
                'publish' => $request->input('publish', $pengumuman->publish), // default ke value sebelumnya jika tidak diubah
                'file_pengumuman' => $pengumuman->file_pengumuman,
                'url' => $pengumuman->url,
            ];

            // Jika file diunggah
            if ($request->hasFile('file')) {
                $fileSizeMB = $request->file('file')->getSize() / 1024 / 1024;
                if ($fileSizeMB > 3 && !$request->filled('url')) {
                    return $this->permissionService->errorResponse('Jika file lebih dari 3MB, Anda harus mengisi URL.');
                }

                // Hapus file lama jika ada
                if ($pengumuman->file_pengumuman && file_exists(public_path('files/pengumuman/' . $pengumuman->file_pengumuman))) {
                    unlink(public_path('files/pengumuman/' . $pengumuman->file_pengumuman));
                }

                $file = $request->file('file');
                $file_name = 'FPENG_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('files/pengumuman'), $file_name);

                $update['file_pengumuman'] = $file_name;
                $update['url'] = null; // Reset URL jika file diunggah
            }

            // Jika URL diisi, reset file
            if ($request->filled('url')) {
                $update['url'] = $request->input('url');
                if ($pengumuman->file_pengumuman && file_exists(public_path('files/pengumuman/' . $pengumuman->file_pengumuman))) {
                    unlink(public_path('files/pengumuman/' . $pengumuman->file_pengumuman));
                }
                $update['file_pengumuman'] = null;
            }

            // Update data di database
            $pengumuman->update($update);

            DB::commit();

            return $this->permissionService->successResponse('Data berhasil diperbarui', $update);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Update pengumuman: ' . $th->getMessage());
            return $this->permissionService->errorResponse('Data gagal diperbarui');
        }
    }
}
