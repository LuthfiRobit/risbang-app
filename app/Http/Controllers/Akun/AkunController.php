<?php

namespace App\Http\Controllers\Akun;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

class AkunController extends Controller
{
    protected PermissionService $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function password(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $find = User::where('id_user', $id)->first();

        if ($find) {

            $validateData = $this->permissionService->validateData($request->all(), [
                'new_password' => [
                    'required',
                    'confirmed',
                    Password::min(6)->numbers()
                ],
                'current_password' => [
                    'required',
                    function ($attribute, $value, $fail) use ($find) {
                        if (!Hash::check($value, $find->password)) {
                            return $fail(__('Current Password Does not Match'));
                        }
                    }
                ]
            ]);

            if ($validateData !== null) {
                return $validateData;
            }

            DB::beginTransaction();
            try {

                $userData = [
                    'password' =>  Hash::make($request->new_password),
                ];

                $find->update($userData);
                DB::commit();

                return $this->permissionService->successResponse('Data berhasil diupdate', $find);
            } catch (\Throwable $th) {
                DB::rollBack();
                Log::error('Update password gagal: ' . $th->getMessage());
                return $this->permissionService->errorResponse('Data gagal diupdate');
            }
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => $find], 400);
        }
    }
}
