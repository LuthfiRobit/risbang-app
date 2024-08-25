<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Services\PermissionService;
use App\Services\ProposalService;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ReportLuaranController extends Controller
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
        return view('report.proposalLuaran.index');
    }

    public function list(Request $request)
    {
        $query = DB::table('luaran_proposal')
            ->select('luaran_proposal.id_luaran_proposal', 'luaran_proposal.jenis', 'luaran_proposal.status_review', 'luaran_proposal.tahun_pelaksanaan', 'luaran_proposal.judul', 'tahun_akademik.nama_tahun_akademik', 'dosen.nama_dosen', 'prodi.singkatan as s_prodi', 'fakultas.singkatan as s_fakultas')
            ->leftJoin('proposal', 'proposal.id_proposal', '=', 'luaran_proposal.proposal_id')
            ->leftJoin('tahun_akademik', 'tahun_akademik.id_tahun_akademik', '=', 'luaran_proposal.tahun_akademik_id')
            ->leftJoin('dosen', 'dosen.id_dosen', '=', 'luaran_proposal.dosen_id')
            ->leftJoin('prodi', 'prodi.id_prodi', '=', 'dosen.prodi_id')
            ->leftJoin('fakultas', 'fakultas.id_fakultas', '=', 'prodi.fakultas_id')
            ->orderBy('proposal.created_at', 'DESC');


        if ($this->userRole == 'dosen' && $this->dosenRole == 'dekan') {
            $query->where('prodi.fakultas_id', $this->dekanId);
        }

        if ($this->userRole == 'dosen' && $this->dosenRole == 'kaprodi') {
            $query->where('dosen.prodi_id', $this->kaprodiId);
        }

        if ($request->filter_ta) {
            $query->where('luaran_proposal.tahun_akademik_id', $request->filter_ta);
        }

        if ($request->filter_status) {
            $query->where('luaran_proposal.status_review', $request->filter_status);
        }

        if ($request->filter_jenis) {
            $query->where('luaran_proposal.jenis', $request->filter_jenis);
        }

        if ($request->filter_fakultas) {
            $query->where('prodi.fakultas_id', $request->filter_fakultas);
        }

        if ($request->filter_prodi) {
            $query->where('dosen.prodi_id', $request->filter_prodi);
        }

        $result = $query->get()->map(function ($r) {
            return [
                'action' => Crypt::encryptString($r->id_luaran_proposal),
                'tahun_akademik' => $r->nama_tahun_akademik,
                'dosen' => $r->nama_dosen . ' ( ' . $r->s_fakultas . '-' . $r->s_prodi . ' )',
                'judul' => $r->judul,
                'pelaksanaan' => $r->tahun_pelaksanaan,
                'jenis' => $r->jenis,
                'status' => $r->status_review
            ];
        });

        return DataTables::of($result)
            ->addIndexColumn()
            ->toJson();
    }

    public function show(string $id)
    {
        try {
            // Decrypt the ID
            $id = Crypt::decryptString($id);
        } catch (DecryptException $e) {
            return response()->json(['success' => false, 'message' => 'Invalid ID'], 400);
        }

        // Retrieve the proposal data along with related data
        $query = DB::table('luaran_proposal')
            ->select(
                'luaran_proposal.id_luaran_proposal',
                'luaran_proposal.jenis',
                'luaran_proposal.status_review',
                'luaran_proposal.jenis_publikasi',
                'luaran_proposal.judul',
                'luaran_proposal.penerbit',
                'luaran_proposal.tahun_pelaksanaan',
                'luaran_proposal.volume',
                'luaran_proposal.nomor',
                'luaran_proposal.link',
                'luaran_proposal.issn',
                'luaran_proposal.file_luaran',
                'tahun_akademik.nama_tahun_akademik',
                'dosen.nama_dosen',
                'prodi.nama_prodi',
                'fakultas.nama_fakultas'
            )
            ->leftJoin('proposal', 'proposal.id_proposal', '=', 'luaran_proposal.proposal_id')
            ->leftJoin('tahun_akademik', 'tahun_akademik.id_tahun_akademik', '=', 'luaran_proposal.tahun_akademik_id')
            ->leftJoin('dosen', 'dosen.id_dosen', '=', 'luaran_proposal.dosen_id')
            ->leftJoin('prodi', 'prodi.id_prodi', '=', 'dosen.prodi_id')
            ->leftJoin('fakultas', 'fakultas.id_fakultas', '=', 'prodi.fakultas_id')
            ->where('luaran_proposal.id_luaran_proposal', $id)
            ->first();

        // Check if the proposal exists
        if (!$query) {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan'], 400);
        }

        // Map the proposal data
        $queryMap = [
            'id_luaran_proposal' => Crypt::encryptString($query->id_luaran_proposal),
            'judul' => $query->judul,
            'jenis_proposal' => $query->jenis,
            'status' => $query->status_review,
            'jenis' => $query->jenis_publikasi,
            'penerbit' => $query->penerbit,
            'volume' => $query->volume,
            'nomor' => $query->nomor,
            'issn' => $query->issn,
            'pelaksanaan' => $query->tahun_pelaksanaan,
            'link' => $query->link,
            'file' => asset('files/luaranProposal/' . $query->file_luaran),
            'tahun_akademik' => $query->nama_tahun_akademik,
            'dosen' => $query->nama_dosen,
            'prodi' => $query->nama_prodi,
            'fakultas' => $query->nama_fakultas
        ];

        // Return the response
        return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $queryMap], 200);
    }
}
