<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Services\PermissionService;
use App\Services\ProposalService;
use DateTime;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ReportPelaksanaanController extends Controller
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
        return view('report.proposalPelaksanaan.index');
    }

    public function list(Request $request)
    {
        $query = DB::table('pelaksanaan_proposal')
            ->select('pelaksanaan_proposal.id_pelaksanaan_proposal', 'pelaksanaan_proposal.jenis', 'pelaksanaan_proposal.tanggal', 'proposal.judul', 'tahun_akademik.nama_tahun_akademik', 'dosen.nama_dosen', 'prodi.singkatan as s_prodi', 'fakultas.singkatan as s_fakultas')
            ->leftJoin('proposal', 'proposal.id_proposal', '=', 'pelaksanaan_proposal.proposal_id')
            ->leftJoin('tahun_akademik', 'tahun_akademik.id_tahun_akademik', '=', 'pelaksanaan_proposal.tahun_akademik_id')
            ->leftJoin('dosen', 'dosen.id_dosen', '=', 'pelaksanaan_proposal.dosen_id')
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
            $query->where('pelaksanaan_proposal.tahun_akademik_id', $request->filter_ta);
        }

        if ($request->filter_jenis) {
            $query->where('pelaksanaan_proposal.jenis', $request->filter_jenis);
        }

        if ($request->filter_fakultas) {
            $query->where('prodi.fakultas_id', $request->filter_fakultas);
        }

        if ($request->filter_prodi) {
            $query->where('dosen.prodi_id', $request->filter_prodi);
        }

        $result = $query->get()->map(function ($r) {
            return [
                'action' => Crypt::encryptString($r->id_pelaksanaan_proposal),
                'tahun_akademik' => $r->nama_tahun_akademik,
                'dosen' => $r->nama_dosen . ' ( ' . $r->s_fakultas . '-' . $r->s_prodi . ' )',
                'judul' => $r->judul,
                'tanggal' => (new DateTime($r->tanggal))->format('d-m-Y'),
                'jenis' => $r->jenis,
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
        $query = DB::table('pelaksanaan_proposal')
            ->select(
                'pelaksanaan_proposal.id_pelaksanaan_proposal',
                'pelaksanaan_proposal.jenis',
                'pelaksanaan_proposal.nama_kegiatan',
                'pelaksanaan_proposal.tempat_kegiatan',
                'pelaksanaan_proposal.keterangan',
                'pelaksanaan_proposal.tanggal',
                'proposal.judul',
                'tahun_akademik.nama_tahun_akademik',
                'dosen.nama_dosen',
                'prodi.nama_prodi',
                'fakultas.nama_fakultas'
            )
            ->leftJoin('proposal', 'proposal.id_proposal', '=', 'pelaksanaan_proposal.proposal_id')
            ->leftJoin('tahun_akademik', 'tahun_akademik.id_tahun_akademik', '=', 'pelaksanaan_proposal.tahun_akademik_id')
            ->leftJoin('dosen', 'dosen.id_dosen', '=', 'pelaksanaan_proposal.dosen_id')
            ->leftJoin('prodi', 'prodi.id_prodi', '=', 'dosen.prodi_id')
            ->leftJoin('fakultas', 'fakultas.id_fakultas', '=', 'prodi.fakultas_id')
            ->where('pelaksanaan_proposal.id_pelaksanaan_proposal', $id)
            ->first();

        // Check if the proposal exists
        if (!$query) {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan'], 400);
        }

        // Map the proposal data
        $queryMap = [
            'id_pelaksanaan_proposal' => Crypt::encryptString($query->id_pelaksanaan_proposal),
            'judul' => $query->judul,
            'jenis_proposal' => $query->jenis,
            'nama_kegiatan' => $query->nama_kegiatan,
            'tanggal' => (new DateTime($query->tanggal))->format('d-m-Y'),
            'tempat_kegiatan' => $query->tempat_kegiatan,
            'keterangan' => $query->keterangan,
            'tahun_akademik' => $query->nama_tahun_akademik,
            'dosen' => $query->nama_dosen,
            'prodi' => $query->nama_prodi,
            'fakultas' => $query->nama_fakultas
        ];

        // Return the response
        return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $queryMap], 200);
    }
}
