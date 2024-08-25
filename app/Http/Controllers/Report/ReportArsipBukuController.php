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

class ReportArsipBukuController extends Controller
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
        return view('report.publikasiBuku.index');
    }

    public function list(Request $request)
    {
        $query = DB::table('arsip_buku')
            ->select(
                'arsip_buku.id_arsip_buku',
                'arsip_buku.jenis',
                'arsip_buku.publish',
                'arsip_buku.judul',
                'arsip_buku.penerbit',
                'arsip_buku.kategori_buku',
                'arsip_buku.tahun_terbit',
                'tahun_akademik.nama_tahun_akademik',
                'dosen.nama_dosen',
                'prodi.singkatan as s_prodi',
                'fakultas.singkatan as s_fakultas'
            )
            ->leftJoin('proposal', 'proposal.id_proposal', '=', 'arsip_buku.proposal_id')
            ->leftJoin('tahun_akademik', 'tahun_akademik.id_tahun_akademik', '=', 'arsip_buku.tahun_akademik_id')
            ->leftJoin('dosen', 'dosen.id_dosen', '=', 'arsip_buku.dosen_id')
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
            $query->where('arsip_buku.tahun_akademik_id', $request->filter_ta);
        }

        if ($request->filter_kate) {
            $query->where('arsip_buku.kategori_buku', $request->filter_kate);
        }

        if ($request->filter_jenis) {
            $query->where('arsip_buku.jenis', $request->filter_jenis);
        }

        if ($request->filter_fakultas) {
            $query->where('prodi.fakultas_id', $request->filter_fakultas);
        }

        if ($request->filter_prodi) {
            $query->where('dosen.prodi_id', $request->filter_prodi);
        }

        $result = $query->get()->map(function ($r) {
            return [
                'action' => Crypt::encryptString($r->id_arsip_buku),
                'tahun_akademik' => $r->nama_tahun_akademik,
                'dosen' => $r->nama_dosen . ' ( ' . $r->s_fakultas . '-' . $r->s_prodi . ' )',
                'judul' => $r->judul,
                'terbit' => $r->tahun_terbit,
                'publish' => $r->publish == 'y' ? 'Terkonfirmasi' : 'Belum Terkonfirmasi',
                'jenis' => $r->jenis,
                'kategori' => $r->kategori_buku,
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
        $query = DB::table('arsip_buku')
            ->select(
                'arsip_buku.id_arsip_buku',
                'arsip_buku.jenis',
                'arsip_buku.publish',
                'arsip_buku.judul',
                'arsip_buku.penerbit',
                'arsip_buku.kategori_buku',
                'arsip_buku.isbn',
                'arsip_buku.tahun_terbit',
                'arsip_buku.jumlah_halaman',
                'arsip_buku.kota_penerbit',
                'arsip_buku.link',
                'arsip_buku.deskripsi',
                'arsip_buku.file_arsip_buku',
                'arsip_buku.created_by',
                'tahun_akademik.nama_tahun_akademik',
                'dosen.nama_dosen',
                'prodi.nama_prodi',
                'fakultas.nama_fakultas'
            )
            ->leftJoin('proposal', 'proposal.id_proposal', '=', 'arsip_buku.proposal_id')
            ->leftJoin('tahun_akademik', 'tahun_akademik.id_tahun_akademik', '=', 'arsip_buku.tahun_akademik_id')
            ->leftJoin('dosen', 'dosen.id_dosen', '=', 'arsip_buku.dosen_id')
            ->leftJoin('prodi', 'prodi.id_prodi', '=', 'dosen.prodi_id')
            ->leftJoin('fakultas', 'fakultas.id_fakultas', '=', 'prodi.fakultas_id')
            ->where('arsip_buku.id_arsip_buku', $id)
            ->first();

        // Check if the proposal exists
        if (!$query) {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan'], 400);
        }

        // Map the proposal data
        $queryMap = [
            'id_arsip_buku' => Crypt::encryptString($query->id_arsip_buku),
            'jenis' => $query->jenis,
            'publish' =>  $query->publish == 'y' ? 'Terkonfirmasi' : 'Belum Terkonfirmasi',
            'judul' => $query->judul,
            'penerbit' => $query->penerbit,
            'kategori' => $query->kategori_buku,
            'terbit' => $query->tahun_terbit,
            'isbn' => $query->isbn,
            'jumlah_halaman' => $query->jumlah_halaman,
            'kota_penerbit' => $query->kota_penerbit,
            'link' => $query->link,
            'deskripsi' => $query->deskripsi,
            'file' => asset('files/arsipBuku/' . $query->file_arsip_buku),
            'tahun_akademik' => $query->nama_tahun_akademik,
            'dosen' => $query->nama_dosen,
            'prodi' => $query->nama_prodi,
            'fakultas' => $query->nama_fakultas
        ];

        // Return the response
        return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $queryMap], 200);
    }

    public function getReportData(Request $request)
    {
        $query = DB::table('arsip_buku')
            ->join('tahun_akademik', 'arsip_buku.tahun_akademik_id', '=', 'tahun_akademik.id_tahun_akademik')
            ->join('dosen', 'arsip_buku.dosen_id', '=', 'dosen.id_dosen')
            ->join('prodi', 'dosen.prodi_id', '=', 'prodi.id_prodi')
            ->select(
                'tahun_akademik.nama_tahun_akademik',
                DB::raw('SUM(CASE WHEN jenis = "Penelitian" THEN 1 ELSE 0 END) as penelitian'),
                DB::raw('SUM(CASE WHEN jenis = "Pengabdian" THEN 1 ELSE 0 END) as pengabdian')
            );

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
}
