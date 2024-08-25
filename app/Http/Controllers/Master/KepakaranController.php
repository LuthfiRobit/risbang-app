<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\BidangIlmu;
use App\Models\Kepakaran;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class KepakaranController extends Controller
{
    protected PermissionService $permissionService;


    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function index()
    {
        $bidangIlmu = BidangIlmu::select('id_bidang_ilmu', 'nama_bidang_ilmu', 'aktif')->where('aktif', 'y')->get();
        return view('master.kepakaran.index', compact('bidangIlmu'));
    }

    public function list()
    {
        $data = Kepakaran::select('kepakaran.id_kepakaran', 'bidang_ilmu.id_bidang_ilmu', 'kepakaran.nama_kepakaran', 'bidang_ilmu.nama_bidang_ilmu', 'kepakaran.aktif')
            ->leftJoin('bidang_ilmu', 'bidang_ilmu.id_bidang_ilmu', '=', 'kepakaran.bidang_ilmu_id')
            ->orderBy('kepakaran.created_at', 'DESC')
            ->get();
        // return $data;
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('cek', function ($model) {
                return Crypt::encryptString($model->id_kepakaran);
            })
            ->addColumn('action', function ($model) {
                return Crypt::encryptString($model->id_kepakaran);
            })
            ->toJson();
    }

    public function show(string $id)
    {
        $id = Crypt::decryptString($id);
        $one = Kepakaran::select('kepakaran.id_kepakaran', 'bidang_ilmu.id_bidang_ilmu', 'kepakaran.nama_kepakaran', 'bidang_ilmu.nama_bidang_ilmu', 'kepakaran.aktif')
            ->leftJoin('bidang_ilmu', 'bidang_ilmu.id_bidang_ilmu', '=', 'kepakaran.bidang_ilmu_id')
            ->where('id_kepakaran', $id)->first();
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
            'nama_kepakaran' => 'required',
            'bidang_ilmu' => 'required',
            'aktifasi' => 'required',

        ], [
            'required' => 'Input :attribute wajib diisi.',
        ]);

        if ($validateData !== null) {
            return $validateData;
        }

        $save['nama_kepakaran'] = $request->nama_kepakaran;
        $save['bidang_ilmu_id'] = $request->bidang_ilmu;
        $save['aktif'] = $request->aktifasi;
        $store = Kepakaran::create($save);

        return $this->permissionService->successResponse('data berhasil dibuat', $save);
        // return $request->all();
    }

    public function update(Request $request, string $id)
    {
        $id = Crypt::decryptString($id);
        $validateData = $this->permissionService->validateData($request->all(), [
            'nama_kepakaran' => 'required',
            'bidang_ilmu' => 'required',
            'aktifasi' => 'required',

        ], [
            'required' => 'Input :attribute wajib diisi.',
        ]);

        if ($validateData !== null) {
            return $validateData;
        }

        $update['nama_kepakaran'] = $request->nama_kepakaran;
        $update['bidang_ilmu_id'] = $request->bidang_ilmu;
        $update['aktif'] = $request->aktifasi;
        Kepakaran::where('id_kepakaran', $id)->update($update);

        return $this->permissionService->successResponse('data berhasil diperbarui', $update);
    }

    public function updateMultiple(Request $request)
    {
        foreach ($request->id_kepakaran as $row) {
            $update['aktif'] = $request->aktif;
            Kepakaran::where('id_kepakaran', $row)->update($update);
        }

        return $this->permissionService->successResponse('data pembaruan status berhasil');
    }

    public function listJson($id)
    {
        $data = Kepakaran::select('id_kepakaran', 'nama_kepakaran')->where('bidang_ilmu_id', $id)->get();

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
