<?php

namespace App\Http\Controllers\Review;

use App\Http\Controllers\Controller;
use App\Models\AkhirProposal;
use App\Models\Dosen;
use App\Models\ReviewAkhirProposal;
use App\Models\TahunAkademik;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class ReviewAkhirController extends Controller
{
    protected PermissionService $permissionService;
    protected $userId;
    protected $dosenId;
    protected $reviewerId;
    protected $kaprodiId;
    protected $dekanId;
    protected $userRole;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
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

    public function index()
    {
        return view('review.akhir.index');
    }

    public function listTa()
    {
        $data = TahunAkademik::whereHas('detailReviewer', function ($query) {
            $query->where('reviewer_id', $this->reviewerId);
        })
            ->orderBy('tahun_akhir', 'DESC')->get()
            ->map(function ($ta) {
                return [
                    'id_tahun_akademik' => $ta->id_tahun_akademik,
                    'nama' => $ta->nama_tahun_akademik,
                    'jumlah_dosen' => $ta->detailReviewer->count() . " Dosen",
                    'action' => Crypt::encryptString($ta->id_tahun_akademik)
                ];
            });

        return DataTables::of($data)
            ->addIndexColumn()
            ->toJson();
    }

    public function viewDosen(string $id)
    {
        $id = Crypt::decryptString($id);
        $tahunAkademik = TahunAkademik::select('nama_tahun_akademik')
            ->where('id_tahun_akademik', $id)
            ->first();
        return view('review.akhir.indexDsn', compact('tahunAkademik'));
    }

    public function listDsn(string $id)
    {
        $id = Crypt::decryptString($id);
        $data = DB::table("detail_reviewer")
            ->leftJoin("dosen as ds", function ($join) {
                $join->on("ds.id_dosen", "=", "detail_reviewer.dosen_id");
            })
            ->leftJoin("tahun_akademik as ta", function ($join) {
                $join->on("ta.id_tahun_akademik", "=", "detail_reviewer.tahun_akademik_id");
            })
            ->leftJoin("prodi as pr", function ($join) {
                $join->on("pr.id_prodi", "=", "ds.prodi_id");
            })
            ->leftJoin("akhir_proposal as k_penelitian", function ($join) {
                $join->on("k_penelitian.dosen_id", "=", "ds.id_dosen")
                    ->on("k_penelitian.tahun_akademik_id", "=", "ta.id_tahun_akademik")
                    ->where("k_penelitian.jenis", "=", "Penelitian");
            })
            ->leftJoin("akhir_proposal as k_pengabdian", function ($join) {
                $join->on("k_pengabdian.dosen_id", "=", "ds.id_dosen")
                    ->on("k_pengabdian.tahun_akademik_id", "=", "ta.id_tahun_akademik")
                    ->where("k_pengabdian.jenis", "=", "Pengabdian");
            })
            ->select(
                "detail_reviewer.id_detail_reviewer",
                "ds.id_dosen",
                "detail_reviewer.tahun_akademik_id",
                "ds.nama_dosen",
                "pr.nama_prodi",
                "ta.nama_tahun_akademik",
                "k_penelitian.status_review as penelitian",
                "k_pengabdian.status_review as pengabdian",
                "k_penelitian.keaslian as keaslian_pene",
                "k_pengabdian.keaslian as keaslian_peng",
                DB::raw('CASE
                WHEN k_penelitian.status_review = "Diterima" AND k_pengabdian.status_review = "Diterima" THEN "Diterima"
                ELSE "Belum Diterima"
                END AS status')
            )
            ->where("detail_reviewer.reviewer_id", "=", $this->reviewerId)
            ->where("detail_reviewer.tahun_akademik_id", "=", $id)
            ->get()
            ->map(function ($dr) {
                return [
                    'action' => Crypt::encryptString($dr->id_detail_reviewer),
                    'id_dosen' => Crypt::encryptString($dr->id_dosen),
                    'id_tahun_akademik' => Crypt::encryptString($dr->tahun_akademik_id),
                    'nama_dosen' => $dr->nama_dosen,
                    'prodi' => $dr->nama_prodi,
                    'tahun_akademik' => $dr->nama_tahun_akademik,
                    'penelitian' => $dr->penelitian == 'Diterima' ? 'Diterima' : null,
                    'pengabdian' => $dr->pengabdian == 'Diterima' ? 'Diterima' : null,
                    'keaslian_pene' => $dr->keaslian_pene,
                    'keaslian_peng' => $dr->keaslian_peng,
                    'status' => $dr->status
                ];
            });
        // return $data;
        return DataTables::of($data)
            ->addIndexColumn()
            ->toJson();
    }

    public function overview(Request $request, string $id)
    {
        $taId = Crypt::decryptString($id);
        $dsnId = Crypt::decryptString($request->query('dosen'));
        $data['dosen'] = Dosen::select(
            'nama_dosen',
            'prodi.nama_prodi'
        )
            ->leftJoin('prodi', 'prodi.id_prodi', 'dosen.prodi_id')
            ->where('id_dosen', $dsnId)->first();
        // return $data;
        return view('review.akhir.overview', $data);
    }

    public function store(Request $request)
    {
        $id = Crypt::decryptString($request->akhir_id);
        $validateData = $this->permissionService->validateData($request->all(), [
            'komen' => 'required',
            'nilai' => 'required',
            'status_review' => 'required',
        ]);

        if ($validateData !== null) {
            return $validateData;
        }

        DB::beginTransaction();
        try {
            $save['akhir_proposal_id'] = $id;
            $save['reviewer_id'] = $this->reviewerId;
            $save['komen'] = $request->komen;
            $save['nilai'] = $request->nilai;

            $store = ReviewAkhirProposal::create($save);
            if ($store) {
                AkhirProposal::where('id_akhir_proposal', $id)->update(['status_review' => $request->status_review]);
            }

            DB::commit();
            return $this->permissionService->successResponse('data berhasil dibuat', $save);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Create review akhir proposal: ' . $th->getMessage());
            return $this->permissionService->errorResponse('data gagal dibuat');
        }
    }

    public function show(string $id)
    {
        $id = Crypt::decryptString($id);
        $one = DB::table('review_akhir_proposal')
            ->select(
                'akhir_proposal_id',
                'komen',
                'nilai',
                'akhir_proposal.status_review'
            )
            ->leftJoin('akhir_proposal', 'akhir_proposal.id_akhir_proposal', '=', 'review_akhir_proposal.akhir_proposal_id')
            ->where('akhir_proposal_id', $id)->latest('review_akhir_proposal.created_at')->first();
        if ($one) {
            return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $one], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => $one], 400);
        }
    }
}
