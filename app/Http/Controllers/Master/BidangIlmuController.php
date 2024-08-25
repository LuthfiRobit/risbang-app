<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\BidangIlmu;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class BidangIlmuController extends Controller
{

    protected PermissionService $permissionService;


    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function index()
    {
        return view('master.bidangIlmu.index');
    }

    public function list()
    {
        $data = BidangIlmu::orderBy('created_at', 'DESC')->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('cek', function ($model) {
                return Crypt::encryptString($model->id_bidang_ilmu);
            })
            ->addColumn('action', function ($model) {
                return Crypt::encryptString($model->id_bidang_ilmu);
            })
            ->toJson();
    }

    public function show(string $id)
    {
        $id = Crypt::decryptString($id);
        $one = BidangIlmu::where('id_bidang_ilmu', $id)->first();
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
            'nama_bidang_ilmu' => 'required',
            'aktifasi' => 'required',

        ], [
            'required' => 'Input :attribute wajib diisi.',
        ]);

        if ($validateData !== null) {
            return $validateData;
        }

        $save['nama_bidang_ilmu'] = $request->nama_bidang_ilmu;
        $save['aktif'] = $request->aktifasi;
        $store = BidangIlmu::create($save);

        return $this->permissionService->successResponse('data berhasil dibuat', $save);
        // return $request->all();
    }

    public function update(Request $request, string $id)
    {
        $id = Crypt::decryptString($id);
        $validateData = $this->permissionService->validateData($request->all(), [
            'nama_bidang_ilmu' => 'required',
            'aktifasi' => 'required',

        ], [
            'required' => 'Input :attribute wajib diisi.',
        ]);

        if ($validateData !== null) {
            return $validateData;
        }

        $update['nama_bidang_ilmu'] = $request->nama_bidang_ilmu;
        $update['aktif'] = $request->aktifasi;
        BidangIlmu::where('id_bidang_ilmu', $id)->update($update);

        return $this->permissionService->successResponse('data berhasil diperbarui', $update);
    }

    public function updateMultiple(Request $request)
    {
        foreach ($request->id_bidang_ilmu as $row) {
            $update['aktif'] = $request->aktif;
            BidangIlmu::where('id_bidang_ilmu', $row)->update($update);
        }

        return $this->permissionService->successResponse('data pembaruan status berhasil');
    }

    public function listJson()
    {
        $data = BidangIlmu::select('id_bidang_ilmu', 'nama_bidang_ilmu')->where('aktif', 'y')->get();

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
