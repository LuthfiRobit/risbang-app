<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Imports\DosenImport;
use App\Models\Dosen;
use App\Models\Fakultas;
use App\Models\Prodi;
use App\Models\User;
use App\Services\DataActiveService;
use App\Services\PermissionService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class DosenController extends Controller
{
    protected PermissionService $permissionService;
    protected DataActiveService $dataActiveService;
    protected $userId;
    protected $dosenId;
    protected $reviewerId;
    protected $kaprodiId;
    protected $dekanId;
    protected $userRole;
    protected $dosenRole;

    public function __construct(PermissionService $permissionService, DataActiveService $dataActiveService)
    {
        $this->permissionService = $permissionService;
        $this->dataActiveService = $dataActiveService;
        $this->middleware(
            function ($request, $next) {
                $this->userId = Auth::user()->id_user;
                $this->dosenId = Auth::user()->user_role == 'dosen'  && Auth::user()->dosen_role == 'dosen' ? Auth::user()->dosen->id_dosen : null;
                $this->reviewerId = Auth::user()->user_role == 'reviewer' ? Auth::user()->reviewer->id_reviewer : null;
                $this->kaprodiId = Auth::user()->user_role == 'dosen' && Auth::user()->dosen_role == 'kaprodi' ? Auth::user()->kaprodi->id_prodi : null;
                $this->dekanId =  Auth::user()->user_role == 'dosen' && Auth::user()->dosen_role == 'dekan' ? Auth::user()->dekan->id_fakultas : null;
                $this->userRole = Auth::user()->user_role;
                $this->dosenRole = Auth::user()->dosen_role;
                return $next($request);
            }
        );
    }

    public function index()
    {
        $fakultas = Fakultas::select('id_fakultas', 'nama_fakultas')->where('aktif', 'y')->get();
        // $prodi = Prodi::select('id_prodi', 'nama_prodi')->where('aktif', 'y')->get();
        return view('tendik.dosen.index', compact('fakultas'));
    }

    public function list(Request $request)
    {
        $data = Dosen::select(
            'dosen.id_dosen',
            'users.id_user',
            'users.username',
            'fakultas.nama_fakultas',
            'fakultas.singkatan as singkatan_fakultas',
            'prodi.nama_prodi',
            'prodi.singkatan as singkatan_prodi',
            'dosen.email',
            'dosen.nama_dosen',
            'dosen.nidn'
        )
            ->leftJoin('users', 'users.id_user', '=', 'dosen.user_id')
            ->leftJoin('prodi', 'prodi.id_prodi', '=', 'dosen.prodi_id')
            ->leftJoin('fakultas', 'fakultas.id_fakultas', '=', 'prodi.fakultas_id')
            ->orderBy('dosen.created_at', 'DESC');
        // ->get();

        if ($request->filter_fakultas) {
            $data->where('fakultas.id_fakultas', $request->filter_fakultas);
        }

        if ($request->filter_prodi) {
            $data->where('dosen.prodi_id', $request->filter_prodi);
        }
        // return $data;

        $result = $data->get();

        return DataTables::of($result)
            ->addIndexColumn()
            ->addColumn('cek', function ($model) {
                return Crypt::encryptString($model->id_dosen);
            })
            ->addColumn('action', function ($model) {
                return Crypt::encryptString($model->id_dosen);
            })
            // ->toJson();
            ->make(true);
    }

    public function show(string $id)
    {
        $id = Crypt::decryptString($id);
        $one =
            Dosen::select(
                'dosen.id_dosen',
                'users.id_user',
                'users.username',
                'fakultas.id_fakultas',
                'fakultas.nama_fakultas',
                'fakultas.singkatan as singkatan_fakultas',
                'prodi.id_prodi',
                'prodi.nama_prodi',
                'prodi.singkatan as singkatan_prodi',
                'dosen.nik',
                'dosen.no_tlpn',
                'dosen.email',
                'dosen.nama_dosen',
                'dosen.nidn',
                'dosen.status_dosen',
                'dosen.jabatan',
                'dosen.status_serdos',
                'dosen.jk'
            )
            ->leftJoin('users', 'users.id_user', '=', 'dosen.user_id')
            ->leftJoin('prodi', 'prodi.id_prodi', '=', 'dosen.prodi_id')
            ->leftJoin('fakultas', 'fakultas.id_fakultas', '=', 'prodi.fakultas_id')
            ->where('id_dosen', $id)->first();
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
            'fakultas' => 'required',
            'prodi' => 'required',
            'status' => 'required',
            'nama_dosen' => 'required',
            'nidn' => 'required|min:10|max:10',
            'email' => 'required|unique:users|email:rfc,dns',
            'username' => 'required',
            'password' => 'required|confirmed|min:6',
        ], [
            'required' => 'Input :attribute wajib diisi.',
            'min' => 'Input :attribute minimal :min karakter.',
            'max' => 'Input :attribute maksimal :max karakter.',
            'confirmed' => 'Input :attribute tidak cocok / belum terkonfirmasi.'
        ]);

        if ($validateData !== null) {
            return $validateData;
        }

        DB::beginTransaction();
        try {
            $saveUser['email'] = $request->email;
            $saveUser['username'] = $request->username;
            $saveUser['password'] = Hash::make($request->password);
            $saveUser['user_role'] = 'dosen';
            $saveUser['dosen_role'] = 'dosen';

            $storeUser = User::create($saveUser);

            $saveDosen['user_id'] = $storeUser->id_user;
            $saveDosen['prodi_id'] = $request->prodi;
            $saveDosen['status_dosen'] = $request->status;
            $saveDosen['nama_dosen'] = $request->nama_dosen;
            $saveDosen['nidn'] = $request->nidn;
            $saveDosen['email'] = $request->email;

            Dosen::create($saveDosen);
            DB::commit();
            return $this->permissionService->successResponse('data berhasil dibuat', $saveDosen);
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
            return $this->permissionService->errorResponse('data gagal dibuat');
        }
        // return $request->all();
    }

    public function update(Request $request, string $id)
    {
        $id = Crypt::decryptString($id);
        $validateData = $this->permissionService->validateData($request->all(), [
            'fakultas' => 'required',
            'prodi' => 'required',
            'status' => 'required',
            'nama_dosen' => 'required',
            'nidn' => 'required|min:10|max:10',
            'email' => 'required|email:rfc,dns',
            'username' => 'required',
            'password' => 'confirmed',
        ], [
            'required' => 'Input :attribute wajib diisi.',
            'min' => 'Input :attribute minimal :min karakter.',
            'max' => 'Input :attribute maksimal :max karakter.',
            'confirmed' => 'Input :attribute tidak cocok / belum terkonfirmasi.',
        ]);

        if ($validateData !== null) {
            return $validateData;
        }

        DB::beginTransaction();
        try {

            $updateDosen['prodi_id'] = $request->prodi;
            $updateDosen['status_dosen'] = $request->status;
            $updateDosen['nama_dosen'] = $request->nama_dosen;
            $updateDosen['nidn'] = $request->nidn;
            $updateDosen['email'] = $request->email;

            $findDosen =  Dosen::where('id_dosen', $id)->first();
            $findDosen->update($updateDosen);

            $updateUser['email'] = $request->email;
            $updateUser['username'] = $request->username;

            if ($request->password != null || $request->password != '') {
                $updateUser['password'] = Hash::make($request->password);
            }

            User::where('id_user', $findDosen->user_id)->update($updateUser);

            DB::commit();

            return $this->permissionService->successResponse('data berhasil diperbarui', $updateDosen);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $this->permissionService->errorResponse('data gagal diperbarui');
        }
    }

    public function updateMultiple(Request $request)
    {
        foreach ($request->id_dosen as $row) {
            $update['aktif'] = $request->aktif;
            $updateUser['active'] = $request->aktif;
            $findDosen = Dosen::where('id_dosen', $row)->first();
            $findUser = User::where('id_user', $findDosen->user_id)->first();
            $findDosen->update($update);
            $findUser->update($updateUser);
        }

        return $this->permissionService->successResponse('data pembaruan status berhasil');
    }

    public function listPublic()
    {
        $query = DB::table('dosen')
            ->select(
                'dosen.id_dosen',
                'dosen.nidn',
                'dosen.nama_dosen',
                'dosen.prodi_id',
                'prodi.singkatan as prodi',
                'fakultas.singkatan as fakultas',
            )
            ->leftJoin('prodi', 'prodi.id_prodi', '=', 'dosen.prodi_id')
            ->leftJoin('fakultas', 'fakultas.id_fakultas', '=', 'prodi.fakultas_id');

        $result = $query->get()->map(function ($dl) {
            return [
                'id' => $dl->id_dosen,
                'show' => $dl->nidn . ' | ' . $dl->nama_dosen . ' | ' . $dl->prodi . ' - ' . $dl->fakultas
            ];
        });
        return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $result], 200);
    }

    public function listPublicHasProposalPene()
    {
        $taId = $this->dataActiveService->tahunAkademik();
        $query = DB::table('dosen')
            ->select(
                'dosen.id_dosen',
                'dosen.nidn',
                'dosen.nama_dosen',
                'dosen.prodi_id',
                'prodi.singkatan as prodi',
                'fakultas.singkatan as fakultas',
            )
            ->leftJoin('prodi', 'prodi.id_prodi', '=', 'dosen.prodi_id')
            ->leftJoin('fakultas', 'fakultas.id_fakultas', '=', 'prodi.fakultas_id');

        // if auth kaprodi
        if ($this->userRole == 'dosen' && $this->dosenRole == 'kaprodi') {
            $query->where('dosen.prodi_id', $this->kaprodiId);
        }

        $result = $query->get()->map(function ($dl) {
            return [
                'id' => $dl->id_dosen,
                'show' => $dl->nidn . ' | ' . $dl->nama_dosen . ' | ' . $dl->prodi . ' - ' . $dl->fakultas,
                'prodi' => $dl->prodi_id
            ];
        });
        return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $result], 200);
    }

    public function listPublicHasProposalPeng()
    {
        $taId = $this->dataActiveService->tahunAkademik();
        $query = DB::table('dosen')
            ->select(
                'dosen.id_dosen',
                'dosen.nidn',
                'dosen.nama_dosen',
                'dosen.prodi_id',
                'prodi.singkatan as prodi',
                'fakultas.singkatan as fakultas',
            )
            ->leftJoin('prodi', 'prodi.id_prodi', '=', 'dosen.prodi_id')
            ->leftJoin('fakultas', 'fakultas.id_fakultas', '=', 'prodi.fakultas_id');

        // if auth kaprodi
        if ($this->userRole == 'dosen' && $this->dosenRole == 'kaprodi') {
            $query->where('dosen.prodi_id', $this->kaprodiId);
        }

        $result = $query->get()->map(function ($dl) {
            return [
                'id' => $dl->id_dosen,
                'show' => $dl->nidn . ' | ' . $dl->nama_dosen . ' | ' . $dl->prodi . ' - ' . $dl->fakultas,
                'prodi' => $dl->prodi_id
            ];
        });
        return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $result], 200);
    }

    public function importExcel(Request $request)
    {
        // if (! $request->hasFile('file')) {
        //     dd('no file');
        // }
        $validateData = $this->permissionService->validateData($request->all(), [
            'file' => 'required|mimes:xlsx,xls'
        ], [
            'required' => 'Input :attribute wajib diisi.',
            'mimes' => 'Input :attribute harus :values.'
        ]);

        if ($validateData !== null) {
            return $validateData;
        }

        try {
            $file = $request->file('file');
            $import = new DosenImport();
            $import->import($file);

            if ($import->failures()->isNotEmpty()) {
                return response()->json(['success' => false, 'message' => 'Some rows failed to import.', 'errors' => $import->failures()], 422);
            }

            return response()->json(['success' => true, 'message' => 'Import successful!'], 200);
        } catch (\Exception $e) {
            Log::error('Import Excel error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Import failed: ' . $e->getMessage()], 500);
        }
    }
}
