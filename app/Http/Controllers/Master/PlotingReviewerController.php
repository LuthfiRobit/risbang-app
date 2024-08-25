<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\DetailReviewer;
use App\Models\Reviewer;
use App\Models\TahunAkademik;
use App\Services\PermissionService;
use App\Services\ProposalValidationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class PlotingReviewerController extends Controller
{
    protected PermissionService $permissionService;
    protected ProposalValidationService $validationService;
    protected $userId;
    protected $dosenId;
    protected $reviewerId;
    protected $kaprodiId;
    protected $dekanId;
    protected $userRole;
    protected $dosenRole;

    public function __construct(PermissionService $permissionService, ProposalValidationService $validationService)
    {
        $this->permissionService = $permissionService;
        $this->validationService = $validationService;
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
        return view('setting.plotingReviewer.index');
    }

    public function list()
    {
        $data = DB::table('tahun_akademik')
            ->select(
                'tahun_akademik.id_tahun_akademik',
                'tahun_akademik.nama_tahun_akademik',
                DB::raw('COUNT(DISTINCT detail_reviewer.reviewer_id) AS jumlah_reviewer'),
                DB::raw('COUNT(DISTINCT detail_reviewer.dosen_id) AS jumlah_dosen')
            )
            ->leftJoin('detail_reviewer', 'detail_reviewer.tahun_akademik_id', '=', 'tahun_akademik.id_tahun_akademik')
            ->groupBy('tahun_akademik.id_tahun_akademik', 'tahun_akademik.nama_tahun_akademik')
            ->orderBy('tahun_akhir', 'DESC')
            ->get()
            ->map(function ($q) {
                return [
                    'action' => Crypt::encrypt($q->id_tahun_akademik),
                    'tahun_akademik' => $q->nama_tahun_akademik,
                    'reviewer' => $q->jumlah_reviewer,
                    'dosen' => $q->jumlah_dosen
                ];
            });

        return DataTables::of($data)
            ->addIndexColumn()
            ->toJson();
    }

    public function indexReviewer(Request $request)
    {
        $id = Crypt::decrypt($request->query('ta'));
        $ta = TahunAkademik::where('id_tahun_akademik', $id)->first();
        return view('setting.plotingReviewer.indexReviewer');
    }

    public function listReviewer(Request $request)
    {
        $id = Crypt::decrypt($request->query('ta'));

        $data = DB::table('reviewer')
            ->select(
                'reviewer.id_reviewer',
                'reviewer.nama_reviewer',
                DB::raw('COUNT(DISTINCT detail_reviewer.dosen_id) AS jumlah_dosen')
            )
            ->leftJoin('detail_reviewer', function ($join) use ($id) {
                $join->on('reviewer.id_reviewer', '=', 'detail_reviewer.reviewer_id')
                    ->where('detail_reviewer.tahun_akademik_id', '=', $id);
            })
            ->groupBy('reviewer.id_reviewer', 'reviewer.nama_reviewer')
            ->get()
            ->map(function ($q) {
                return [
                    'action' => Crypt::encrypt($q->id_reviewer),
                    'reviewer' => $q->nama_reviewer,
                    'dosen' => $q->jumlah_dosen
                ];
            });

        return DataTables::of($data)
            ->addIndexColumn()
            ->toJson();
    }

    public function createPloting(Request $request)
    {
        $ta = Crypt::decrypt($request->query('ta'));
        $rv = Crypt::decrypt($request->query('rv'));
        $data['tahun_akademik'] = TahunAkademik::where('id_tahun_akademik', $ta)->select('id_tahun_akademik', 'nama_tahun_akademik')->first();
        $data['reviewer'] = Reviewer::where('id_reviewer', $rv)->select('id_reviewer', 'nama_reviewer')->first();
        // return $detail;
        return view('setting.plotingReviewer.create', $data);
    }

    public function listPloted(Request $request)
    {
        $ta = Crypt::decrypt($request->query('ta'));
        $rv = Crypt::decrypt($request->query('rv'));
        $data = DB::table('dosen')
            ->select(
                'detail_reviewer.id_detail_reviewer',
                'dosen.id_dosen',
                'dosen.nama_dosen',
                'prodi.nama_prodi',
                'fakultas.nama_fakultas'
            )
            ->join('detail_reviewer', 'dosen.id_dosen', '=', 'detail_reviewer.dosen_id')
            ->join('prodi', 'dosen.prodi_id', '=', 'prodi.id_prodi')
            ->join('fakultas', 'prodi.fakultas_id', '=', 'fakultas.id_fakultas')
            ->where('detail_reviewer.tahun_akademik_id', $ta)
            ->where('detail_reviewer.reviewer_id', $rv)
            ->get()
            ->map(function ($q) {
                return [
                    'action' => Crypt::encrypt($q->id_detail_reviewer),
                    'dosen' => $q->nama_dosen,
                    'prodi' => $q->nama_prodi,
                    'fakultas' => $q->nama_fakultas
                ];
            });

        return DataTables::of($data)
            ->addIndexColumn()
            ->toJson();
    }

    public function listUnploted(Request $request)
    {
        $ta = Crypt::decrypt($request->query('ta'));
        $rv = Crypt::decrypt($request->query('rv'));

        $data = DB::table('dosen')
            ->select(
                'dosen.id_dosen',
                'dosen.nama_dosen',
                'prodi.nama_prodi',
                'fakultas.nama_fakultas'
            )
            ->leftJoin('detail_reviewer', function ($join) use ($ta) {
                $join->on('dosen.id_dosen', '=', 'detail_reviewer.dosen_id')
                    ->where('detail_reviewer.tahun_akademik_id', '=', $ta);
            })
            ->leftJoin('prodi', 'dosen.prodi_id', '=', 'prodi.id_prodi')
            ->leftJoin('fakultas', 'prodi.fakultas_id', '=', 'fakultas.id_fakultas')
            ->whereNull('detail_reviewer.dosen_id')
            ->get()
            ->map(function ($q) {
                return [
                    'action' => Crypt::encryptString($q->id_dosen),
                    'cek' => Crypt::encryptString($q->id_dosen),
                    // 'action' => Crypt::encrypt($q->id_dosen),
                    // 'cek' => Crypt::encrypt($q->id_dosen),
                    'id_dosen' => $q->id_dosen,
                    'dosen' => $q->nama_dosen,
                    'prodi' => $q->nama_prodi,
                    'fakultas' => $q->nama_fakultas
                ];
            });

        return DataTables::of($data)
            ->addIndexColumn()
            ->toJson();
    }

    public function storePloting(Request $request)
    {
        $ta = Crypt::decrypt($request->id_ta);
        $rv = Crypt::decrypt($request->id_rv);
        // return $request->all();
        DB::beginTransaction();
        try {
            foreach ($request->id_dosen as $key => $dosen) {
                $storePloting = new DetailReviewer();
                $storePloting->dosen_id = $dosen;
                $storePloting->reviewer_id = $rv;
                $storePloting->tahun_akademik_id = $ta;
                $storePloting->save();
            }
            DB::commit();
            return $this->permissionService->successResponse('data berhasil dibuat', $storePloting);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th;
            Log::error('Create store ploting gagal: ' . $th->getMessage());
            return $this->permissionService->errorResponse('data gagal dibuat');
        }
        // return $this->permissionService->successResponse('data pembaruan status berhasil');
    }

    public function destroyPloted($id)
    {
        $id = Crypt::decrypt($id);
        $data = DetailReviewer::where('id_detail_reviewer', $id)->first();
        if ($data) {
            $data->delete();
            return $this->permissionService->successResponse('Dosen terploting berhasil dihapus');
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => $data], 400);
        }
    }
}
