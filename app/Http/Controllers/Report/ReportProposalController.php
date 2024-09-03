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
use Illuminate\Support\Number;
use Yajra\DataTables\Facades\DataTables;

class ReportProposalController extends Controller
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

    public function getReportData(Request $request)
    {
        $query = DB::table('proposal')
            ->join('tahun_akademik', 'proposal.tahun_akademik_id', '=', 'tahun_akademik.id_tahun_akademik')
            ->join('dosen', 'proposal.dosen_id', '=', 'dosen.id_dosen')
            ->join('prodi', 'dosen.prodi_id', '=', 'prodi.id_prodi')
            ->select(
                'tahun_akademik.nama_tahun_akademik',
                DB::raw('SUM(CASE WHEN jenis = "Penelitian" THEN 1 ELSE 0 END) as penelitian'),
                DB::raw('SUM(CASE WHEN jenis = "Pengabdian" THEN 1 ELSE 0 END) as pengabdian')
            );

        if ($request->has('status')) {
            $query->where('status_review', $request->status);
        }

        if ($request->has('tahun_akademik')) {
            $query->where('tahun_akademik_id', $request->tahun_akademik);
        }

        if ($request->has('fakultas')) {
            $query->where('prodi.fakultas_id', $request->fakultas);
        }

        if ($request->has('prodi')) {
            $query->where('dosen.prodi_id', $request->prodi);
        }

        $laporan = $query->groupBy('tahun_akademik.nama_tahun_akademik')->get();

        $tahun_akademik = [];
        $penelitian = [];
        $pengabdian = [];

        foreach ($laporan as $data) {
            $tahun_akademik[] = $data->nama_tahun_akademik;
            $penelitian[] = $data->penelitian;
            $pengabdian[] = $data->pengabdian;
        }

        return response()->json([
            'tahun_akademik' => $tahun_akademik,
            'penelitian' => $penelitian,
            'pengabdian' => $pengabdian,
        ]);
    }

    public function index()
    {
        return view('report.proposal.index');
    }

    public function list(Request $request)
    {
        $query = DB::table('proposal')
            ->select('proposal.id_proposal', 'proposal.judul', 'proposal.jenis', 'proposal.status_review', 'tahun_akademik.nama_tahun_akademik', 'dosen.nama_dosen', 'prodi.singkatan as s_prodi', 'fakultas.singkatan as s_fakultas')
            ->leftJoin('tahun_akademik', 'tahun_akademik.id_tahun_akademik', '=', 'proposal.tahun_akademik_id')
            ->leftJoin('dosen', 'dosen.id_dosen', '=', 'proposal.dosen_id')
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
            $query->where('proposal.tahun_akademik_id', $request->filter_ta);
        }

        if ($request->filter_status) {
            $query->where('proposal.status_review', $request->filter_status);
        }

        if ($request->filter_jenis) {
            $query->where('proposal.jenis', $request->filter_jenis);
        }

        if ($request->filter_fakultas) {
            $query->where('prodi.fakultas_id', $request->filter_fakultas);
        }

        if ($request->filter_prodi) {
            $query->where('dosen.prodi_id', $request->filter_prodi);
        }

        $result = $query->get()->map(function ($r) {
            return [
                'action' => Crypt::encryptString($r->id_proposal),
                'tahun_akademik' => $r->nama_tahun_akademik,
                'dosen' => $r->nama_dosen . ' ( ' . $r->s_fakultas . '-' . $r->s_prodi . ' )',
                'judul' => $r->judul,
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
        $proposal = DB::table('proposal')
            ->select(
                'proposal.id_proposal',
                'proposal.judul',
                'proposal.jenis',
                'proposal.status_review',
                'proposal.dana',
                'proposal.jenis_penelitian',
                'proposal.jenis_pengabdian',
                'proposal.abstrak',
                'proposal.kata_kunci',
                'proposal.latar_belakang',
                'proposal.metode',
                'proposal.rencana',
                'proposal.dapus',
                'proposal.file_proposal',
                'review_proposal.nilai_judul',
                'review_proposal.nilai_abstrak',
                'review_proposal.nilai_kata_kunci',
                'review_proposal.nilai_latar_belakang',
                'review_proposal.nilai_metode',
                'review_proposal.nilai_rencana',
                'review_proposal.nilai_dapus',
                'tahun_akademik.nama_tahun_akademik',
                'dosen.nama_dosen',
                'prodi.nama_prodi',
                'fakultas.nama_fakultas'
            )
            ->leftJoin('review_proposal', 'review_proposal.proposal_id', '=', 'proposal.id_proposal')
            ->leftJoin('tahun_akademik', 'tahun_akademik.id_tahun_akademik', '=', 'proposal.tahun_akademik_id')
            ->leftJoin('dosen', 'dosen.id_dosen', '=', 'proposal.dosen_id')
            ->leftJoin('prodi', 'prodi.id_prodi', '=', 'dosen.prodi_id')
            ->leftJoin('fakultas', 'fakultas.id_fakultas', '=', 'prodi.fakultas_id')
            ->where('proposal.id_proposal', $id)
            ->first();

        // Check if the proposal exists
        if (!$proposal) {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan'], 400);
        }

        // Map the proposal data
        $queryMap = [
            'id_proposal' => Crypt::encryptString($proposal->id_proposal),
            'judul' => $proposal->judul,
            'jenis_proposal' => $proposal->jenis,
            'status' => $proposal->status_review,
            'dana' => $proposal->dana ? Number::currency($proposal->dana, 'IDR', 'id') : Number::currency(0, 'IDR', 'id'),
            'jenis' => $proposal->jenis == 'Penelitian' ? $proposal->jenis_penelitian : $proposal->jenis_pengabdian,
            'abstrak' => $proposal->abstrak,
            'katkun' => $proposal->kata_kunci,
            'latbel' => $proposal->latar_belakang,
            'metode' => $proposal->metode,
            'rencana' => $proposal->rencana,
            'dapus' => $proposal->dapus,
            'file' => $proposal->jenis == 'Penelitian'
                ? asset('files/proposalPenelitian/' . $proposal->file_proposal)
                : asset('files/proposalPengabdian/' . $proposal->file_proposal),
            'nilai_judul' => $proposal->nilai_judul,
            'nilai_abstrak' => $proposal->nilai_abstrak,
            'nilai_katkun' => $proposal->nilai_kata_kunci,
            'nilai_latbel' => $proposal->nilai_latar_belakang,
            'nilai_metode' => $proposal->nilai_metode,
            'nilai_rencana' => $proposal->nilai_rencana,
            'nilai_dapus' => $proposal->nilai_dapus,
            'tahun_akademik' => $proposal->nama_tahun_akademik,
            'dosen' => $proposal->nama_dosen,
            'prodi' => $proposal->nama_prodi,
            'fakultas' => $proposal->nama_fakultas
        ];

        // Return the response
        return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $queryMap], 200);
    }

    public function kelengkapan(string $id)
    {
        try {
            // Decrypt the ID
            $id = Crypt::decryptString($id);
        } catch (DecryptException $e) {
            return response()->json(['success' => false, 'message' => 'Invalid ID'], 400);
        }

        // Retrieve the proposal data along with related data
        $proposal = DB::table('proposal')
            ->select(
                'proposal.id_proposal',
                'proposal.judul',
                'proposal.jenis',
                'proposal.status_review',
                'proposal.dana',
                'proposal.jenis_penelitian',
                'proposal.jenis_pengabdian',
                'surat_tugas_proposal.file_surat',
                'surat_moa_proposal.file_moa',
                'tahun_akademik.nama_tahun_akademik',
                'dosen.nama_dosen',
                'prodi.nama_prodi',
                'fakultas.nama_fakultas'
            )
            ->leftJoin('surat_tugas_proposal', 'surat_tugas_proposal.proposal_id', '=', 'proposal.id_proposal')
            ->leftJoin('surat_moa_proposal', 'surat_moa_proposal.proposal_id', '=', 'proposal.id_proposal')
            ->leftJoin('tahun_akademik', 'tahun_akademik.id_tahun_akademik', '=', 'proposal.tahun_akademik_id')
            ->leftJoin('dosen', 'dosen.id_dosen', '=', 'proposal.dosen_id')
            ->leftJoin('prodi', 'prodi.id_prodi', '=', 'dosen.prodi_id')
            ->leftJoin('fakultas', 'fakultas.id_fakultas', '=', 'prodi.fakultas_id')
            ->where('proposal.id_proposal', $id)
            ->first();

        // Check if the proposal exists
        if (!$proposal) {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan'], 400);
        }

        // Map the proposal data
        $queryMap = [
            'id_proposal' => Crypt::encryptString($proposal->id_proposal),
            'judul' => $proposal->judul,
            'jenis_proposal' => $proposal->jenis,
            'status' => $proposal->status_review,
            'jenis' => $proposal->jenis == 'Penelitian' ? $proposal->jenis_penelitian : $proposal->jenis_pengabdian,
            'file_surat' => $proposal->file_surat ?  asset('files/suratTugas/' . $proposal->file_surat) :  null,
            'file_moa' => $proposal->file_moa ?  asset('files/suratMoa/' . $proposal->file_moa) :  null,
            'dosen' => $proposal->nama_dosen,
            'prodi' => $proposal->nama_prodi,
            'fakultas' => $proposal->nama_fakultas
        ];

        // Return the response
        return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $queryMap], 200);
    }
}
