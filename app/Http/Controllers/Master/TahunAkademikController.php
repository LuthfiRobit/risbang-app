<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\TahunAkademik;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class TahunAkademikController extends Controller
{
    protected PermissionService $permissionService;


    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function index()
    {
        return view('tendik.tahunAkademik.index');
    }

    public function list()
    {
        $data = TahunAkademik::orderBy('created_at', 'DESC')->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('cek', function ($model) {
                return Crypt::encryptString($model->id_tahun_akademik);
            })
            ->addColumn('action', function ($model) {
                return Crypt::encryptString($model->id_tahun_akademik);
            })
            ->toJson();
    }

    public function show(string $id)
    {
        $id = Crypt::decryptString($id);
        $one = TahunAkademik::where('id_tahun_akademik', $id)->first();
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
            'nama_tahun_akademik' => 'required',
            'dana_maksimal' => 'required|numeric|min:1000',
            'aktifasi' => 'required',

        ], [
            'required' => 'Input :attribute wajib diisi.',
            'before' => 'Input :attribute harus lebih kecil dari pada :attribute.',
            'after' => 'Input :attribute harus lebih besar dari pada :attribute.',
            'min' => 'Input :attribute minimal :min.',
            'numeric' => 'Input :attribute harus berupa angka.',
        ]);

        if ($validateData !== null) {
            return $validateData;
        }

        $save['tahun_akhir'] = $request->tahun_akhir;
        $save['tahun_awal'] = $request->tahun_awal;
        $save['nama_tahun_akademik'] = $request->nama_tahun_akademik;
        $save['dana_maksimal'] = $request->dana_maksimal;
        $save['aktif'] = $request->aktifasi;
        // $save['buku'] = $request->buku;
        // $save['haki'] = $request->haki;
        // $save['nilai_baru'] = $request->nilai_baru;
        $store = TahunAkademik::create($save);

        return $this->permissionService->successResponse('data berhasil dibuat', $save);
        // return $request->all();
    }

    public function update(Request $request, string $id)
    {
        $id = Crypt::decryptString($id);
        $validateData = $this->permissionService->validateData($request->all(), [
            'tahun_awal' => 'required|before:tahun_akhir',
            'tahun_akhir' => 'required|after:tahun_awal',
            'nama_tahun_akademik' => 'required',
            'dana_maksimal' => 'required|numeric|min:1000',
            'aktifasi' => 'required',

        ], [
            'required' => 'Input :attribute wajib diisi.',
            'before' => 'Input :attribute harus lebih kecil dari pada :attribute.',
            'after' => 'Input :attribute harus lebih besar dari pada :attribute.',
            'min' => 'Input :attribute minimal :min.',
            'numeric' => 'Input :attribute harus berupa angka.',
        ]);

        if ($validateData !== null) {
            return $validateData;
        }

        $update['tahun_akhir'] = $request->tahun_akhir;
        $update['tahun_awal'] = $request->tahun_awal;
        $update['nama_tahun_akademik'] = $request->nama_tahun_akademik;
        $update['dana_maksimal'] = $request->dana_maksimal;
        $update['aktif'] = $request->aktifasi;
        // $update['buku'] = $request->buku;
        // $update['haki'] = $request->haki;
        // $update['nilai_baru'] = $request->nilai_baru;
        TahunAkademik::where('id_tahun_akademik', $id)->update($update);

        return $this->permissionService->successResponse('data berhasil diperbarui', $update);
    }

    public function updateMultiple(Request $request)
    {
        foreach ($request->id_tahun_akademik as $row) {
            $update['aktif'] = $request->aktif;
            TahunAkademik::where('id_tahun_akademik', $row)->update($update);
        }

        return $this->permissionService->successResponse('data pembaruan status berhasil');
    }

    public function listJson()
    {
        $data = TahunAkademik::select('id_tahun_akademik', 'nama_tahun_akademik')->get();

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
