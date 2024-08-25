<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\DosenLain;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DosenLainController extends Controller
{
    protected PermissionService $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function listPublic()
    {
        $data = DosenLain::select('id_dosen_lain', 'nik', 'nama')->get()
            ->map(function ($dl) {
                return [
                    'id' => $dl->id_dosen_lain,
                    'show' => $dl->nik . ' | ' . $dl->nama
                ];
            });
        // if ($data->count() > 0) {
        return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $data], 200);
        // } else {
        // return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => $data], 400);
        // }
    }

    public function store(Request $request)
    {
        $validateData = $this->permissionService->validateData($request->all(), [
            'nik' => 'required',
            'nama' => 'required',
            'alamat' => 'required',
            'jk' => 'required',
            'pendidikan_terakhir' => 'required',
            'no_tlpn' => 'required',
        ]);

        if ($validateData !== null) {
            return $validateData;
        }

        $save['nik'] = $request->nik;
        $save['nama'] = $request->nama;
        $save['alamat'] = $request->alamat;
        $save['jk'] = $request->jk;
        $save['pendidikan_terakhir'] = $request->pendidikan_terakhir;
        $save['no_tlpn'] = $request->no_tlpn;
        $save['created_by'] = Auth::user()->user_role . '-' . Auth::user()->username;
        $store = DosenLain::create($save);

        return $this->permissionService->successResponse('data berhasil dibuat', $save);
    }
}
