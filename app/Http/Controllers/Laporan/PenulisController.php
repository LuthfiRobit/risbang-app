<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\PenulisDalam;
use App\Models\PenulisLain;
use App\Models\PenulisLuar;
use App\Services\DataActiveService;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class PenulisController extends Controller
{
    protected PermissionService $permissionService;
    protected DataActiveService $dataActiveService;
    protected $userId;
    protected $dosenId;
    protected $reviewerId;
    protected $kaprodiId;
    protected $dekanId;
    protected $userRole;

    public function __construct(PermissionService $permissionService, DataActiveService $dataActiveService)
    {
        $this->permissionService = $permissionService;
        $this->dataActiveService = $dataActiveService;
        $this->middleware(
            function ($request, $next) {
                $this->userId = Auth::user()->id_user;
                $this->dosenId = Auth::user()->user_role == 'dosen' ? Auth::user()->dosen->id_dosen : null;
                $this->reviewerId = Auth::user()->user_role == 'reviewer' ? Auth::user()->reviewer->id_reviewer : null;
                // $this->kaprodiId = Auth::user()->id_user;
                // $this->dekanId = Auth::user()->id_user;
                $this->userRole = Auth::user()->user_role;
                return $next($request);
            }
        );
    }

    public function destroyDalam($id)
    {
        // $id = Crypt::decryptString($id);
        $data = PenulisDalam::where('id_penulis_dalam', $id)->first();
        if ($data) {
            $data->delete();
            return $this->permissionService->successResponse('penulis berhasil dihapus');
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => $data], 400);
        }
    }

    public function destroyLuar($id)
    {
        // $id = Crypt::decryptString($id);
        $data = PenulisLuar::where('id_penulis_luar', $id)->first();
        if ($data) {
            $data->delete();
            return $this->permissionService->successResponse('penulis berhasil dihapus');
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => $data], 400);
        }
    }

    public function destroyLain($id)
    {
        // $id = Crypt::decryptString($id);
        $data = PenulisLain::where('id_penulis_lain', $id)->first();
        if ($data) {
            $data->delete();
            return $this->permissionService->successResponse('penulis berhasil dihapus');
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => $data], 400);
        }
    }

    public function penulisByArsip(string $id)
    {
        $id = Crypt::decryptString($id);
        $queryDalam = DB::table('penulis_dalam')
            ->select('id_penulis_dalam as id_penulis', 'dosen.nama_dosen as nama', 'peran_umum', 'koresponden')
            ->leftJoin('dosen', 'dosen.id_dosen', 'penulis_dalam.dosen_id')
            ->where('arsip_id', $id)
            ->get();
        $queryLuar = DB::table('penulis_luar')
            ->select('id_penulis_luar as id_penulis', 'dosen_luar.nama', 'peran_umum', 'koresponden')
            ->leftJoin('dosen_luar', 'dosen_luar.id_dosen_luar', 'penulis_luar.dosen_luar_id')
            ->where('arsip_id', $id)
            ->get();
        $queryLain = DB::table('penulis_lain')
            ->select('id_penulis_lain as id_penulis', 'dosen_lain.nama', 'peran_umum', 'koresponden')
            ->leftJoin('dosen_lain', 'dosen_lain.id_dosen_lain', 'penulis_lain.dosen_lain_id')
            ->where('arsip_id', $id)
            ->get();
        $result  = [
            'penulis_dalam' => $queryDalam,
            'penulis_luar' => $queryLuar,
            'penulis_lain' => $queryLain
        ];

        if ($queryDalam->count() > 0) {
            return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $result], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => $result], 400);
        }
    }
}
