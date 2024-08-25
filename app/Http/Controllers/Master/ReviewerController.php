<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Reviewer;
use App\Models\User;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class ReviewerController extends Controller
{
    protected PermissionService $permissionService;


    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function index()
    {
        return view('master.reviewer.index');
    }

    public function list()
    {
        $data = Reviewer::select('reviewer.id_reviewer', 'users.id_user', 'reviewer.nama_reviewer', 'users.username', 'reviewer.aktif')
            ->leftJoin('users', 'users.id_user', '=', 'reviewer.user_id')
            ->orderBy('reviewer.created_at', 'DESC')
            ->get();
        // return $data;
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('cek', function ($model) {
                return Crypt::encryptString($model->id_reviewer);
            })
            ->addColumn('action', function ($model) {
                return Crypt::encryptString($model->id_reviewer);
            })
            ->toJson();
    }

    public function show(string $id)
    {
        $id = Crypt::decryptString($id);
        $one = Reviewer::select('reviewer.id_reviewer', 'users.id_user', 'reviewer.nama_reviewer', 'users.username', 'users.email', 'reviewer.aktif')
            ->leftJoin('users', 'users.id_user', '=', 'reviewer.user_id')
            ->where('id_reviewer', $id)->first();
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
            'nama_reviewer' => 'required',
            'email' => 'required|email:rfc,dns',
            'username' => 'required',
            'password' => 'required|confirmed|min:6',
            'aktifasi' => 'required',
        ], [
            'required' => 'Input :attribute wajib diisi.',
            'min' => 'Input :attribute minimal :min karakter.',
            'confirmed' => 'Input :attribute tidak cocok.'
        ]);

        if ($validateData !== null) {
            return $validateData;
        }

        DB::beginTransaction();
        try {
            $saveUser['email'] = $request->email;
            $saveUser['username'] = $request->username;
            $saveUser['password'] = Hash::make($request->password);
            $saveUser['user_role'] = 'reviewer';
            $storeUser = User::create($saveUser);

            $saveReviewer['user_id'] = $storeUser->id_user;
            $saveReviewer['nama_reviewer'] = $request->nama_reviewer;
            $saveReviewer['aktif'] = $request->aktifasi;

            Reviewer::create($saveReviewer);
            DB::commit();
            return $this->permissionService->successResponse('data berhasil dibuat', $saveReviewer);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $this->permissionService->errorResponse('data gagal dibuat');
        }
        // return $request->all();
    }

    public function update(Request $request, string $id)
    {
        $id = Crypt::decryptString($id);
        $validateData = $this->permissionService->validateData($request->all(), [
            'nama_reviewer' => 'required',
            'email' => 'required|email:rfc,dns',
            'username' => 'required',
            // 'password' => 'required|confirmed|min:6',
            'aktifasi' => 'required',
        ], [
            'required' => 'Input :attribute wajib diisi.',
            // 'min' => 'Input :attribute minimal :min karakter.',
            // 'confirmed' => 'Input :attribute tidak cocok.'
        ]);

        if ($validateData !== null) {
            return $validateData;
        }

        DB::beginTransaction();
        try {

            $updateReviewer['nama_reviewer'] = $request->nama_reviewer;
            $updateReviewer['aktif'] = $request->aktifasi;

            $findReviewer =  Reviewer::where('id_reviewer', $id)->first();
            $findReviewer->update($updateReviewer);

            $updateUser['email'] = $request->email;
            $updateUser['username'] = $request->username;
            $updateUser['active'] = $request->aktifasi;

            User::where('id_user', $findReviewer->user_id)->update($updateUser);

            DB::commit();

            return $this->permissionService->successResponse('data berhasil diperbarui', $updateReviewer);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $this->permissionService->errorResponse('data gagal diperbarui');
        }
    }

    public function updateMultiple(Request $request)
    {
        foreach ($request->id_reviewer as $row) {
            $update['aktif'] = $request->aktif;
            $updateUser['active'] = $request->aktif;
            $findReviewer = Reviewer::where('id_reviewer', $row)->first();
            $findUser = User::where('id_user', $findReviewer->user_id)->first();
            $findReviewer->update($update);
            $findUser->update($updateUser);
        }

        return $this->permissionService->successResponse('data pembaruan status berhasil');
    }
}
