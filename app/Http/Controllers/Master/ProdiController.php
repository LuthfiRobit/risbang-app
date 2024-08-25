<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Fakultas;
use App\Models\Prodi;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
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
        $data = Prodi::select(
            'prodi.id_prodi',
            'fakultas.id_fakultas',
            'fakultas.singkatan as singkatan_fakultas',
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
            ->orderBy('prodi.created_at', 'DESC');

        if ($request->filter_fakultas) {
            $data->where('prodi.fakultas_id', $request->filter_fakultas);
        }

        if ($request->filter_aktifasi) {
            $data->where('prodi.aktif', $request->filter_aktifasi);
        }

        // $perPage = $request->input('length', 10);
        // $start = $request->input('start', 0);
        // $draw = $request->input('draw', 1);

        // $totalRecords = $data->count();
        // $filteredRecords = $totalRecords; // Sesuaikan jika ada filter tambahan

        // $result = $data->offset($start)->limit($perPage)->get();
        $result = $data->get();

        return DataTables::of($result)
            ->addIndexColumn()
            ->addColumn('cek', function ($model) {
                return Crypt::encryptString($model->id_prodi);
            })
            ->addColumn('action', function ($model) {
                return Crypt::encryptString($model->id_prodi);
            })
            // ->with([
            //     // 'draw' => $draw,
            //     'recordsTotal' => $totalRecords,
            //     'recordsFiltered' => $filteredRecords,
            // ])
            ->make(true);
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
}
