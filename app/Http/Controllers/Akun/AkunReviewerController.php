<?php

namespace App\Http\Controllers\Akun;

use App\Http\Controllers\Controller;
use App\Models\Reviewer;
use App\Models\User;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

class AkunReviewerController extends Controller
{
    protected PermissionService $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function index()
    {
        return view('akun.reviewer.index');
    }

    public function show()
    {
        $data = User::select(
            'users.id_user',
            'users.username',
            'users.email',
            'users.phone_number',
            'users.profile_pict',
            'reviewer.nama_reviewer'
        )
            ->where('id_user', Auth::user()->id_user)
            ->where('user_role', 'reviewer')
            ->leftJoin('reviewer', 'reviewer.user_id', 'users.id_user')
            ->first();
        if ($data) {
            return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $data], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => $data], 400);
        }
    }

    public function update(Request $request)
    {
        $validateData = $this->permissionService->validateData($request->all(), [
            'name' => 'required',
            'email' => 'required|email:rfc,dns',
            'username' => 'required',
            'phone_number' => 'required|',
            'avatar' => $request->hasFile('avatar') ? 'mimes:jpeg,jpg,png|max:2048' : 'nullable'
        ]);

        if ($validateData !== null) {
            return $validateData;
        }

        $user = User::where('id_user', Auth::user()->id_user)->first();
        if (!$user) {
            return $this->permissionService->errorResponse('Data tidak ditemukan');
        }

        $file = $request->file('avatar');
        $file_name = $user->profile_pict;

        DB::beginTransaction();
        try {
            // Update file if new file is uploaded
            if ($file) {
                $file_folder = 'imgs/profileUser';
                if ($file_name !== null) {
                    if (file_exists($file_folder . '/' . $file_name)) {
                        unlink($file_folder . '/' . $file_name);
                    }
                }
                $file_name = 'PR_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($file_folder, $file_name);
            }

            $user->update([
                'email' => $request->email,
                'username' => $request->username,
                'phone_number' => $request->phone_number,
                'profile_pict' => $file_name,
            ]);

            Reviewer::where('user_id', $user->id_user)->update(['nama_reviewer' => $request->name]);

            DB::commit();
            return $this->permissionService->successResponse('Data berhasil diupdate', $user);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Update admin gagal: ' . $th->getMessage());
            return $this->permissionService->errorResponse('Data gagal diupdate');
        }
    }
}