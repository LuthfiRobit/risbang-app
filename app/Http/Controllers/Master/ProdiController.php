<?php

namespace App\Http\Controllers\Master;

use App\Exports\ProdiExport;
use App\Http\Controllers\Controller;
use App\Imports\ProdiImport;
use App\Models\Fakultas;
use App\Models\Prodi;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ProdiController extends Controller
{
    protected PermissionService $permissionService;


    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function index()
    {
        $fakultas = Fakultas::select('id_fakultas', 'nama_fakultas', 'aktif')->where('aktif', 'y')->get();
        return view('tendik.prodi.index', compact('fakultas'));
    }

    public function list(Request $request)
    {
        $query = Prodi::select(
            'prodi.id_prodi',
            'fakultas.nama_fakultas',
            'prodi.nama_prodi',
            'fakultas.nama_fakultas',
            'prodi.singkatan',
            'prodi.aktif',
            'users.id_user',
            'dosen.nama_dosen'
        )
            ->leftJoin('fakultas', 'fakultas.id_fakultas', '=', 'prodi.fakultas_id')
            ->leftJoin('users', 'users.id_user', '=', 'prodi.user_id')
            ->leftJoin('dosen', 'dosen.user_id', '=', 'users.id_user')
            ->orderBy('prodi.created_at', 'DESC');

        if ($request->filter_fakultas) {
            $query->where('prodi.fakultas_id', $request->filter_fakultas);
        }

        if ($request->filter_aktifasi) {
            $query->where('prodi.aktif', $request->filter_aktifasi);
        }

        $result = $query->get()->map(function ($q) {
            return [
                'cek' => Crypt::encryptString($q->id_prodi),
                'action' => Crypt::encryptString($q->id_prodi),
                'nama_fakultas' => $q->nama_fakultas,
                'nama_prodi' => $q->nama_prodi,
                'singkatan' => $q->singkatan,
                'nama_kaprodi' => $q->nama_dosen ?  $q->nama_dosen : 'belum ditentukan',
                'aktif' => $q->aktif
            ];
        });

        return DataTables::of($result)
            ->addIndexColumn()
            ->toJson();
    }

    public function show(string $id)
    {
        $id = Crypt::decryptString($id);
        $one = Prodi::select(
            'prodi.id_prodi',
            'fakultas.id_fakultas',
            'prodi.nama_prodi',
            'fakultas.nama_fakultas',
            // 'prodi.nama_kaprodi',
            'prodi.singkatan',
            'prodi.aktif',
            // 'dosen.nama_dosen as nama_kaprodi'
        )
            ->leftJoin('fakultas', 'fakultas.id_fakultas', '=', 'prodi.fakultas_id')
            // ->leftJoin('users', 'users.id_user', '=', 'prodi.user_id')
            // ->leftJoin('dosen', 'dosen.user_id', '=', 'users.id_user')
            ->where('id_prodi', $id)->first();
        if ($one) {
            return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $one], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => $one], 400);
        }
        // return view('admin.index');
    }

    public function store(Request $request)
    {
        $validateData = $this->permissionService->validateData($request->all(), [
            'nama_prodi' => 'required',
            'fakultas' => 'required',
            // 'nama_kaprodi' => 'required',
            'aktifasi' => 'required',

        ], [
            'required' => 'Input :attribute wajib diisi.',
        ]);

        if ($validateData !== null) {
            return $validateData;
        }

        $save['nama_prodi'] = $request->nama_prodi;
        // $save['nama_kaprodi'] = $request->nama_kaprodi;
        $save['singkatan'] = $request->singkatan;
        $save['fakultas_id'] = $request->fakultas;
        $save['aktif'] = $request->aktifasi;
        $store = Prodi::create($save);

        return $this->permissionService->successResponse('data berhasil dibuat', $save);
        // return $request->all();
    }

    public function update(Request $request, string $id)
    {
        $id = Crypt::decryptString($id);

        $validateData = $this->permissionService->validateData($request->all(), [
            'nama_prodi' => 'required',
            'fakultas' => 'required',
            // 'nama_kaprodi' => 'required',
            'aktifasi' => 'required',

        ], [
            'required' => 'Input :attribute wajib diisi.',
        ]);

        if ($validateData !== null) {
            return $validateData;
        }

        $update['nama_prodi'] = $request->nama_prodi;
        // $update['nama_kaprodi'] = $request->nama_kaprodi;
        $update['singkatan'] = $request->singkatan;
        $update['fakultas_id'] = $request->fakultas;
        $update['aktif'] = $request->aktifasi;
        Prodi::where('id_prodi', $id)->update($update);

        return $this->permissionService->successResponse('data berhasil diperbarui', $update);
    }

    public function updateMultiple(Request $request)
    {
        foreach ($request->id_prodi as $row) {
            $update['aktif'] = $request->aktif;
            Prodi::where('id_prodi', $row)->update($update);
        }

        return $this->permissionService->successResponse('data pembaruan status berhasil');
    }

    public function byFakultas($id)
    {
        $data = Prodi::select('id_prodi', 'nama_prodi')->where('fakultas_id', $id)->get();

        if ($data->count() > 0) {
            $response = [
                'success' => true,
                'message' => 'data tersedia',
                'data' => $data
            ];

            return response()->json($response, 200);
        } else {
            $response = [
                'success' => false,
                'message' => 'data tidak tersedia',
                'data' => []
            ];

            return response()->json($response, 400);
        }
    }

    public function importExcel(Request $request)
    {
        // Validasi input file
        $validateData = $this->permissionService->validateData($request->all(), [
            'file' => 'required|mimes:xlsx,xls'
        ], [
            'required' => 'Input :attribute wajib diisi.',
            'mimes' => 'Input :attribute harus :values.'
        ]);

        if ($validateData !== null) {
            return response()->json(['success' => false, 'message' => $validateData->getMessage()], 422);
        }

        try {
            $file = $request->file('file');
            $import = new ProdiImport();
            $import->import($file);

            // Ambil kesalahan dan data yang berhasil dari ProdiImport
            $failures = $import->failures();
            $successfulRows = $import->successfulRows(); // Method baru untuk data yang berhasil

            // Jika ada kegagalan
            if ($failures || $successfulRows) {
                return response()->json([
                    'success' => true,
                    'message' => 'Impor selesai dengan beberapa hasil.',
                    'failures' => $failures, // Data yang gagal
                    'successes' => $successfulRows // Data yang berhasil
                ], 200);
            }

            return response()->json(['success' => true, 'message' => 'Impor berhasil tanpa kesalahan!'], 200);
        } catch (\Exception $e) {
            Log::error('Import Excel error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Impor gagal: ' . $e->getMessage()], 500);
        }
    }

    public function exportExcel()
    {
        try {
            return Excel::download(new ProdiExport, 'data_prodi.xlsx');
        } catch (\Exception $e) {
            return redirect()->back()->with('fail', 'Export gagal');
        }
    }
}
