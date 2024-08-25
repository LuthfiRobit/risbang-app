<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\DosenLuar;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DosenLuarController extends Controller
{
    protected PermissionService $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function listPublic()
    {
        $data = DosenLuar::select('id_dosen_luar', 'nidn', 'nama')->get()
            ->map(function ($dl) {
                return [
                    'id' => $dl->id_dosen_luar,
                    'show' => $dl->nidn . ' | ' . $dl->nama
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
            'nidn' => 'required',
            'nama' => 'required',
            'kampus' => 'required',
            'alamat_kampus' => 'required',
            'jk' => 'required',
            'pendidikan_terakhir' => 'required',
            'no_tlpn' => 'required',
        ], [
            'required' => 'Input :attribute wajib diisi.',
        ]);

        if ($validateData !== null) {
            return $validateData;
        }

        $save['nidn'] = $request->nidn;
        $save['nama'] = $request->nama;
        $save['kampus'] = $request->kampus;
        $save['alamat_kampus'] = $request->alamat_kampus;
        $save['jk'] = $request->jk;
        $save['pendidikan_terakhir'] = $request->pendidikan_terakhir;
        $save['no_tlpn'] = $request->no_tlpn;
        $save['created_by'] = Auth::user()->user_role . '-' . Auth::user()->username;
        $store = DosenLuar::create($save);

        return $this->permissionService->successResponse('data berhasil dibuat', $save);
    }
}
