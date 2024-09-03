<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Fakultas;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class FakultasController extends Controller
{
    protected PermissionService $permissionService;


    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function index()
    {
        return view('tendik.fakultas.index');
    }

    public function list()
    {
        $query = DB::table('fakultas')->select(
            'fakultas.id_fakultas',
            'fakultas.nama_fakultas',
            'fakultas.singkatan',
            'fakultas.aktif',
            'users.id_user',
            'dosen.nama_dosen'
        )
            ->leftJoin('users', 'users.id_user', '=', 'fakultas.user_id')
            ->leftJoin('dosen', 'dosen.user_id', '=', 'users.id_user')
            ->orderBy('fakultas.created_at', 'DESC');

        $result = $query->get()->map(function ($q) {
            return [
                'cek' => Crypt::encryptString($q->id_fakultas),
                'action' => Crypt::encryptString($q->id_fakultas),
                'singkatan' => $q->singkatan,
                'nama_fakultas' => $q->nama_fakultas,
                'nama_dekan' => $q->nama_dosen ?  $q->nama_dosen : 'belum ditentukan',
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
        $one = DB::table('fakultas')->select(
            'fakultas.id_fakultas',
            'fakultas.nama_fakultas',
            'fakultas.singkatan',
            // 'fakultas.nama_dekan',
            'fakultas.image',
            'fakultas.aktif',
            // 'users.id_user',
            // 'dosen.nama_dosen as nama_dekan'
        )
            // ->leftJoin('users', 'users.id_user', '=', 'fakultas.user_id')
            // ->leftJoin('dosen', 'dosen.id_user', '=', 'user.id_user')
            ->where('id_fakultas', $id)->first();
        if ($one) {
            return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $one], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => $one], 400);
        }
        return view('admin.index');
    }

    public function store(Request $request)
    {
        $validateData = $this->permissionService->validateData($request->all(), [
            'nama_fakultas' => 'required',
            'singkatan' => 'required',
            // 'nama_dekan' => 'required',
            'aktifasi' => 'required',

        ], [
            'required' => 'Input :attribute wajib diisi.',
        ]);

        if ($validateData !== null) {
            return $validateData;
        }

        $save['nama_fakultas'] = $request->nama_fakultas;
        $save['singkatan'] = $request->singkatan;
        // $save['nama_dekan'] = $request->nama_dekan;
        $save['aktif'] = $request->aktifasi;
        $store = Fakultas::create($save);

        return $this->permissionService->successResponse('data berhasil dibuat', $save);
        // return $request->all();
    }

    public function update(Request $request, string $id)
    {
        $id = Crypt::decryptString($id);
        $validateData = $this->permissionService->validateData($request->all(), [
            'nama_fakultas' => 'required',
            'singkatan' => 'required',
            // 'nama_dekan' => 'required',
            'aktifasi' => 'required',

        ], [
            'required' => 'Input :attribute wajib diisi.',
        ]);

        if ($validateData !== null) {
            return $validateData;
        }

        $update['nama_fakultas'] = $request->nama_fakultas;
        $update['singkatan'] = $request->singkatan;
        // $update['nama_dekan'] = $request->nama_dekan;
        $update['aktif'] = $request->aktifasi;
        Fakultas::where('id_fakultas', $id)->update($update);

        return $this->permissionService->successResponse('data berhasil diperbarui', $update);
    }

    public function updateMultiple(Request $request)
    {
        foreach ($request->id_fakultas as $row) {
            $update['aktif'] = $request->aktif;
            Fakultas::where('id_fakultas', $row)->update($update);
        }

        return $this->permissionService->successResponse('data pembaruan status berhasil');
    }

    public function listJson()
    {
        $data = Fakultas::select('id_fakultas', 'nama_fakultas')->where('aktif', 'y')->get();

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
