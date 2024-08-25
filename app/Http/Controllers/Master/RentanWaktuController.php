<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\RentanWaktu;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class RentanWaktuController extends Controller
{
    protected PermissionService $permissionService;


    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function index()
    {
        return view('master.rentanWaktu.index');
    }

    public function list()
    {
        $data = RentanWaktu::orderBy('created_at', 'DESC')->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('cek', function ($model) {
                return Crypt::encryptString($model->id_rentan_waktu);
            })
            ->addColumn('action', function ($model) {
                return Crypt::encryptString($model->id_rentan_waktu);
            })
            ->toJson();
    }

    public function show(string $id)
    {
        $id = Crypt::decryptString($id);
        $one = RentanWaktu::where('id_rentan_waktu', $id)->first();
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
            'tahun_awal' => 'required|before:tahun_akhir',
            'tahun_akhir' => 'required|after:tahun_awal',
            'nama_rentan_waktu' => 'required',
            'aktifasi' => 'required',

        ], [
            'required' => 'Input :attribute wajib diisi.',
            'before' => 'Input :attribute harus lebih kecil dari pada :attribute.',
            'after' => 'Input :attribute harus lebih besar dari pada :attribute.',
        ]);

        if ($validateData !== null) {
            return $validateData;
        }

        $save['tahun_akhir'] = $request->tahun_akhir;
        $save['tahun_awal'] = $request->tahun_awal;
        $save['nama_rentan_waktu'] = $request->nama_rentan_waktu;
        $save['aktif'] = $request->aktifasi;
        $store = RentanWaktu::create($save);

        return $this->permissionService->successResponse('data berhasil dibuat', $save);
        // return $request->all();
    }

    public function update(Request $request, string $id)
    {
        $id = Crypt::decryptString($id);
        $validateData = $this->permissionService->validateData($request->all(), [
            'tahun_awal' => 'required|before:tahun_akhir',
            'tahun_akhir' => 'required|after:tahun_awal',
            'nama_rentan_waktu' => 'required',
            'aktifasi' => 'required',

        ], [
            'required' => 'Input :attribute wajib diisi.',
            'before' => 'Input :attribute harus lebih kecil dari pada :attribute.',
            'after' => 'Input :attribute harus lebih besar dari pada :attribute.',
        ]);

        if ($validateData !== null) {
            return $validateData;
        }


        $update['tahun_akhir'] = $request->tahun_akhir;
        $update['tahun_awal'] = $request->tahun_awal;
        $update['nama_rentan_waktu'] = $request->nama_rentan_waktu;
        $update['aktif'] = $request->aktifasi;
        RentanWaktu::where('id_rentan_waktu', $id)->update($update);

        return $this->permissionService->successResponse('data berhasil diperbarui', $update);
    }

    public function updateMultiple(Request $request)
    {
        foreach ($request->id_rentan_waktu as $row) {
            $update['aktif'] = $request->aktif;
            RentanWaktu::where('id_rentan_waktu', $row)->update($update);
        }

        return $this->permissionService->successResponse('data pembaruan status berhasil');
    }
}
