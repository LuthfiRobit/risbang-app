<?php

namespace App\Http\Controllers\Review;

use App\Http\Controllers\Controller;
use App\Models\DetailReviewer;
use App\Models\Dosen;
use App\Models\Proposal;
use App\Models\ProposalLuaran;
use App\Models\ReviewProposal;
use App\Models\ReviewProposalLuaran;
use App\Models\TahunAkademik;
use App\Services\PermissionService;
use App\Services\ProposalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ReviewProposalController extends Controller
{
    protected PermissionService $permissionService;
    protected ProposalService $proposalService;
    protected $userId;
    protected $dosenId;
    protected $reviewerId;
    protected $kaprodiId;
    protected $dekanId;
    protected $userRole;
    protected $dosenRole;

    public function __construct(PermissionService $permissionService, ProposalService $proposalService)
    {
        $this->permissionService = $permissionService;
        $this->proposalService = $proposalService;
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
        return view('review.proposal.index');
    }

    public function list()
    {
        $data = TahunAkademik::whereHas('detailReviewer')->orderBy('tahun_akhir', 'DESC')->get()
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

    public function indexReview(string $id)
    {
        $id = Crypt::decryptString($id);
        $tahunAkademik = TahunAkademik::select('nama_tahun_akademik')
            ->where('id_tahun_akademik', $id)
            ->first();
        return view('review.proposal.indexReview', compact('tahunAkademik'));
    }

    public function listReview(string $id)
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
            ->leftJoin("proposal as p_penelitian", function ($join) {
                $join->on("p_penelitian.dosen_id", "=", "ds.id_dosen")
                    ->on("p_penelitian.tahun_akademik_id", "=", "ta.id_tahun_akademik")
                    ->where("p_penelitian.jenis", "=", "Penelitian");
            })
            ->leftJoin("proposal as p_pengabdian", function ($join) {
                $join->on("p_pengabdian.dosen_id", "=", "ds.id_dosen")
                    ->on("p_pengabdian.tahun_akademik_id", "=", "ta.id_tahun_akademik")
                    ->where("p_pengabdian.jenis", "=", "Pengabdian");
            })
            ->select(
                "detail_reviewer.id_detail_reviewer",
                "ds.id_dosen",
                "detail_reviewer.tahun_akademik_id",
                "ds.nama_dosen",
                "pr.nama_prodi",
                "ta.nama_tahun_akademik",
                "p_penelitian.status_review as penelitian",
                "p_pengabdian.status_review as pengabdian",
                DB::raw('CASE
                WHEN p_penelitian.status_review = "Diterima" AND p_pengabdian.status_review = "Diterima" THEN "Diterima"
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
                    'status' => $dr->status
                ];
            });
        // return $data;
        return DataTables::of($data)
            ->addIndexColumn()
            ->toJson();
    }

    public function overview(string $id)
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
            ->leftJoin("proposal as p_penelitian", function ($join) {
                $join->on("p_penelitian.dosen_id", "=", "ds.id_dosen")
                    ->on("p_penelitian.tahun_akademik_id", "=", "ta.id_tahun_akademik")
                    ->where("p_penelitian.jenis", "=", "Penelitian");
            })
            ->leftJoin("proposal as p_pengabdian", function ($join) {
                $join->on("p_pengabdian.dosen_id", "=", "ds.id_dosen")
                    ->on("p_pengabdian.tahun_akademik_id", "=", "ta.id_tahun_akademik")
                    ->where("p_pengabdian.jenis", "=", "Pengabdian");
            })
            ->where("detail_reviewer.id_detail_reviewer", "=", $id)
            ->select(
                "detail_reviewer.id_detail_reviewer",
                "ds.id_dosen",
                "detail_reviewer.tahun_akademik_id",
                "ds.nama_dosen",
                "pr.nama_prodi",
                "ta.nama_tahun_akademik",
                "p_penelitian.id_proposal as penelitian",
                "p_pengabdian.id_proposal as pengabdian",
            )
            ->first();
        if ($data) {
            // $data = [
            //     'id_detail_reviewer' => $find->id_detail_reviewer,
            //     'id_dosen' =>  $find->id_dosen,
            //     'tahun_akademik_id' =>  $find->tahun_akademik_id,
            //     'nama_dosen' =>  $find->nama_dosen,
            //     'nama_prodi' =>  $find->nama_prodi,
            //     'nama_tahun_akademik' => $find->nama_tahun_akademik,
            //     'id_penelitian' => Crypt::encryptString($find->penelitian),
            //     'id_pengabdian' => Crypt::encryptString($find->pengabdian),
            // ];
            // return $data;
            return view('review.proposal.overview', compact('data'));
        } else {
            return redirect()->back();
        }
    }

    public function showReviewProposal(string $id)
    {
        $id = Crypt::decryptString($id);
        $one = ReviewProposal::where('proposal_id', $id)->latest()->first();
        if ($one) {
            return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $one], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => $one], 400);
        }
    }

    public function storeReviewProposal(Request $request)
    {
        $id = Crypt::decryptString($request->id);
        $validateData = $this->permissionService->validateData($request->all(), [
            'komen_judul' => 'required',
            'nilai_judul' => 'required',
            'komen_abstrak' => 'required',
            'nilai_abstrak' => 'required',
            'komen_kata_kunci' => 'required',
            'nilai_kata_kunci' => 'required',
            'komen_latar_belakang' => 'required',
            'nilai_latar_belakang' => 'required',
            'komen_metode' => 'required',
            'nilai_metode' => 'required',
            'komen_rencana' => 'required',
            'nilai_rencana' => 'required',
            'komen_dapus' => 'required',
            'nilai_dapus' => 'required',
            'status_review' => 'required',
        ]);

        if ($validateData !== null) {
            return $validateData;
        }

        DB::beginTransaction();
        try {
            $save['reviewer_id'] = $this->reviewerId; // ganti auth user id reviewer
            $save['dosen_id'] = $request->id_dosen;
            $save['proposal_id'] = $id;
            $save['komen_judul'] = $request->komen_judul;
            $save['nilai_judul'] = $request->nilai_judul;
            $save['komen_abstrak'] = $request->komen_abstrak;
            $save['nilai_abstrak'] = $request->nilai_abstrak;
            $save['komen_kata_kunci'] = $request->komen_kata_kunci;
            $save['nilai_kata_kunci'] = $request->nilai_kata_kunci;
            $save['komen_latar_belakang'] = $request->komen_latar_belakang;
            $save['nilai_latar_belakang'] = $request->nilai_latar_belakang;
            $save['komen_metode'] = $request->komen_metode;
            $save['nilai_metode'] = $request->nilai_metode;
            $save['komen_rencana'] = $request->komen_rencana;
            $save['nilai_rencana'] = $request->nilai_rencana;
            $save['komen_dapus'] = $request->komen_dapus;
            $save['nilai_dapus'] = $request->nilai_dapus;

            $store = ReviewProposal::create($save);
            if ($store) {
                Proposal::where('id_proposal', $id)->update(['status_review' => $request->status_review]);
            }

            DB::commit();
            return $this->permissionService->successResponse('data berhasil dibuat', $save);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $this->permissionService->errorResponse('data gagal dibuat');
        }
    }

    public function showReviewLuaran(string $id)
    {
        $id = Crypt::decryptString($id);
        // $one = ProposalLuaran::select(
        //     'jenis_luaran',
        //     'jenis_publikasi',
        //     'jenis_haki',
        //     'jenis_buku',
        //     'judul',
        //     'penerbit'
        // )
        //     ->where('id_proposal_luaran', $id)->first();
        $one = DB::table('review_proposal_luaran')
            ->select(
                'proposal_luaran_id',
                'komen',
                'nilai',
                'proposal_luaran.status_review'
            )
            ->leftJoin('proposal_luaran', 'proposal_luaran.id_proposal_luaran', '=', 'review_proposal_luaran.proposal_luaran_id')
            ->where('proposal_luaran_id', $id)->latest('review_proposal_luaran.created_at')->first();
        if ($one) {
            return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $one], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => $one], 400);
        }
    }

    public function showReviewLuaranTambahan(string $id)
    {
        $taId = '';
        $dosenId = '';
        if ($this->userRole == 'reviewer') {
            $find = DetailReviewer::where('id_detail_reviewer', Crypt::decryptString($id))->select('dosen_id', 'tahun_akademik_id')->first();
            $taId = $find->tahun_akademik_id;
            $dosenId = $find->dosen_id;
        } else {
            $taId = Crypt::decryptString($id);
            $dosenId = $this->dosenId;
        }
        $data = DB::table('proposal_luaran')
            ->select(
                'proposal_luaran.id_proposal_luaran',
                DB::raw('MAX(review_proposal_luaran.id_review_proposal_luaran) AS id_review_proposal_luaran'),
                'proposal_luaran.judul',
                'proposal_luaran.jenis_buku',
                'proposal_luaran.status_review',
                DB::raw('MAX(review_proposal_luaran.komen) AS komen'),
                DB::raw('MAX(review_proposal_luaran.created_at) AS created_at')
            )
            ->leftJoin('review_proposal_luaran', 'proposal_luaran.id_proposal_luaran', '=', 'review_proposal_luaran.proposal_luaran_id')
            ->where('proposal_luaran.jenis_luaran', 'Buku')
            ->where('proposal_luaran.dosen_id', $dosenId)
            ->where('proposal_luaran.tahun_akademik_id', $taId)
            ->groupBy('proposal_luaran.id_proposal_luaran', 'proposal_luaran.judul', 'proposal_luaran.jenis_buku')
            ->orderBy('created_at', 'DESC')
            ->get()
            ->map(function ($pl) {
                return [
                    // 'id_proposal_luaran' => Crypt::encryptString($pl->id_proposal_luaran),
                    'action' => Crypt::encryptString($pl->id_proposal_luaran),
                    // 'dosen_id' => Crypt::encryptString($pl->dosen_id),
                    'judul' => $pl->judul,
                    'jenis_buku' => $pl->jenis_buku,
                    'komen' => $pl->komen,
                    'status_review' => $pl->status_review != null ? $pl->status_review : '------'
                ];
            });
        // return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $data], 200);
        return DataTables::of($data)
            ->addIndexColumn()
            ->toJson();
    }

    public function storeReviewLuaran(Request $request)
    {
        $id = Crypt::decryptString($request->id);
        $dsn = Crypt::decryptString($request->id_dosen);
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
            $save['reviewer_id'] = $this->reviewerId; // ganti auth user id reviewer
            $save['dosen_id'] = $dsn;
            $save['proposal_luaran_id'] = $id;
            $save['komen'] = $request->komen;
            $save['nilai'] = $request->nilai;

            $store = ReviewProposalLuaran::create($save);
            if ($store) {
                ProposalLuaran::where('id_proposal_luaran', $id)->update(['status_review' => $request->status_review]);
            }

            DB::commit();
            return $this->permissionService->successResponse('data berhasil dibuat', $save);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $this->permissionService->errorResponse('data gagal dibuat');
        }
    }
}
