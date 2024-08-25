<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use App\Models\Prodi;
use App\Models\User;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DosenManagementController extends Controller
{

    protected PermissionService $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function index()
    {
        $dosen = User::select('users.id_user', 'dosen.id_dosen', 'dosen.nama_dosen', 'dosen.nidn')
            ->leftJoin('dosen', 'dosen.user_id', '=', 'users.id_user')
            ->where([['user_role', 'dosen']])
            ->get();
        return view('setting.dosen.index', compact('dosen'));
    }

    public function list()
    {
        $data = User::select(
            'users.id_user',
            'users.username',
            'users.dosen_role',
            'users.user_role',
            'dosen.user_id',
            'dosen.id_dosen',
            'dosen.nama_dosen',
            'users.active'
        )
            ->leftJoin('dosen', 'dosen.user_id', '=', 'users.id_user')
            ->where('users.user_role', 'dosen')
            ->orderBy('users.created_at', 'DESC')
            ->get()
            ->map(function ($u) {
                return [
                    'id_user' => $u->id_user,
                    'username' => $u->username,
                    'dosen_role' => $u->dosen_role,
                    'nama_dosen' => $u->nama_dosen,
                    'aktif' => $u->active,
                    'cek' => Crypt::encryptString($u->id_user),
                    'action' => Crypt::encryptString($u->id_user)
                ];
            });
        return DataTables::of($data)
            ->addIndexColumn()
            ->toJson();
    }

    public function show(string $id)
    {
        $id = Crypt::decryptString($id);

        $one = User::select(
            'users.id_user',
            'users.username',
            'users.email',
            'users.dosen_role',
            'users.user_role',
            'dosen.id_dosen',
            'dosen.nama_dosen',
            'dosen.nidn',
            'dosen.nik',
            'dosen.no_tlpn',
            'fakultas.nama_fakultas',
            'fakultas.id_fakultas',
            'prodi.nama_prodi',
            'prodi.id_prodi',
            'prodi.fakultas_id',
            'users.active as aktif'
        )
            ->leftJoin('dosen', 'dosen.user_id', '=', 'users.id_user')
            ->leftJoin('fakultas', 'fakultas.user_id', '=', 'users.id_user')
            ->leftJoin('prodi', 'prodi.user_id', '=', 'users.id_user')
            ->where('users.user_role', 'dosen')
            ->where('users.id_user', $id)
            ->first();

        if ($one) {
            return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $one], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => $one], 400);
        }
    }

    public function store(Request $request)
    {
        $validateData = $this->permissionService->validateData($request->all(), [
            'role' => 'required',
            'fakultas' => $request->role == 'dekan' ? 'required' : '',
            'prodi' => $request->role == 'kaprodi' ? 'required' : '',
            'dosen' => 'required'
        ]);

        if ($validateData !== null) {
            return $validateData;
        }

        $oldUser = null;
        $oldFakultas = null;
        $oldProdi = null;
        $currentUser = User::where('id_user', $request->dosen)->first();

        if ($currentUser->dosen_role === 'dekan') {
            // Kosongkan user_id pada fakultas lama
            $oldFakultas = Fakultas::where('user_id', $currentUser->id_user)->first();
            if ($oldFakultas) {
                $oldFakultas->update(['user_id' => null]);
            }
        }

        if ($currentUser->dosen_role === 'kaprodi') {
            // Kosongkan user_id pada prodi lama
            $oldProdi = Prodi::where('user_id', $currentUser->id_user)->first();
            if ($oldProdi) {
                $oldProdi->update(['user_id' => null]);
            }
        }

        if ($request->role === 'dekan') {
            // Update dosen_role user lama
            $oldFakultas = Fakultas::where('id_fakultas', $request->fakultas)->first();
            $oldUser = User::where('id_user', $oldFakultas->user_id)->first();
            if ($oldUser) {
                $oldUser->dosen_role = 'dosen';
                $oldUser->save();
            }
        }

        if ($request->role === 'kaprodi') {
            // Update dosen_role user lama
            $oldProdi = Prodi::where('id_prodi', $request->prodi)->first();
            $oldUser = User::where('id_user', $oldProdi->user_id)->first();
            if ($oldUser) {
                $oldUser->dosen_role = 'dosen';
                $oldUser->save();
            }
        }

        DB::beginTransaction();
        try {
            $findUser = User::where('id_user', $request->dosen)->first();
            if ($request->role === 'dekan') {
                $updateUser['dosen_role'] = 'dekan';
                Fakultas::where('id_fakultas', $request->fakultas)->update(['user_id' => $request->dosen]);
            } else if ($request->role === 'kaprodi') {
                $updateUser['dosen_role'] = 'kaprodi';
                Prodi::where('id_prodi', $request->prodi)->update(['user_id' => $request->dosen]);
            } else {
                return $this->permissionService->errorResponse('data gagal diperbarui');
            }

            $findUser->update($updateUser);

            DB::commit();

            return $this->permissionService->successResponse('data berhasil diperbarui', $updateUser);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->permissionService->errorResponse('data gagal diperbarui');
        }
    }

    public function update(Request $request, string $id)
    {
        $id = Crypt::decryptString($id);
    }

    public function updateMultiple(Request $request)
    {
        foreach ($request->id_user as $row) {
            $update['active'] = $request->aktif;
            User::where('id_user', $row)->update($update);
        }

        return $this->permissionService->successResponse('data pembaruan status berhasil');
    }
}
