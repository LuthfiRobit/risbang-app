<?php

namespace App\Http\Controllers\Proposal;

use App\Http\Controllers\Controller;
use App\Models\DeadlineProposal;
use App\Models\HistoryPelaksanaanProposal;
use App\Models\PelaksanaanProposal;
use App\Services\PermissionService;
use App\Services\ProposalValidationService;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PelaksanaanProposalController extends Controller
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

    public function showAll(string $id, Request $request)
    {
        $taId = Crypt::decryptString($id);
        $dsnId = Crypt::decryptString($request->query('dosen'));

        $data = PelaksanaanProposal::select(
            'pelaksanaan_proposal.id_pelaksanaan_proposal',
            'pelaksanaan_proposal.tahun_akademik_id',
            'pelaksanaan_proposal.jenis',
            'pelaksanaan_proposal.nama_kegiatan',
            'pelaksanaan_proposal.tempat_kegiatan',
            'pelaksanaan_proposal.keterangan',
            'pelaksanaan_proposal.tanggal',
            'proposal.judul'
        )
            ->where([['pelaksanaan_proposal.tahun_akademik_id', $taId], ['pelaksanaan_proposal.dosen_id', $dsnId]])
            ->leftJoin('proposal', 'proposal.id_proposal', 'pelaksanaan_proposal.proposal_id')
            ->get()
            ->map(function ($kp) {
                return [
                    'id_kem_pro' => Crypt::encryptString($kp->id_pelaksanaan_proposal),
                    'id_ta' => Crypt::encryptString($kp->tahun_akademik_id),
                    'jenis' => $kp->jenis,
                    'nama_kegiatan' => $kp->nama_kegiatan,
                    'tempat_kegiatan' => $kp->tempat_kegiatan,
                    'keterangan' => $kp->keterangan,
                    'tanggal' => $kp->tanggal
                ];
            });

        if ($data->count() != 0) {
            return response()->json([
                'success' => true,
                'message' => 'data tersedia',
                'data' => $data->count(),
                'pelaksanaan_penelitian' => $data->where('jenis', 'Penelitian')->first(),
                'pelaksanaan_pengabdian' => $data->where('jenis', 'Pengabdian')->first(),
            ], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => null], 400);
        }
    }

    public function show(Request $request, string $id)
    {
        $taId = Crypt::decryptString($id);
        $jenis = $request->query('jenis');
        $one = PelaksanaanProposal::select(
            'pelaksanaan_proposal.id_pelaksanaan_proposal',
            'pelaksanaan_proposal.tahun_akademik_id',
            'pelaksanaan_proposal.jenis',
            'pelaksanaan_proposal.nama_kegiatan',
            'pelaksanaan_proposal.tempat_kegiatan',
            'pelaksanaan_proposal.keterangan',
            'pelaksanaan_proposal.tanggal',
            'proposal.judul'
        )
            ->leftJoin('proposal', 'proposal.id_proposal', 'pelaksanaan_proposal.proposal_id')
            //dosen
            ->when($this->userRole == 'dosen', function ($q)  use ($taId, $jenis) {
                $q->where([['pelaksanaan_proposal.tahun_akademik_id', $taId], ['pelaksanaan_proposal.dosen_id', $this->dosenId], ['pelaksanaan_proposal.jenis', $jenis]]);
            })
            ->latest('pelaksanaan_proposal.created_at')
            ->first();
        if ($one) {
            $one['id_pelaksanaan_cript'] = Crypt::encryptString($one->id_pelaksanaan_proposal);
            Log::info('Show pelaksanaan proposal by : ' . $this->userRole);
            return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $one], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => $one], 400);
        }
    }

    public function store(Request $request)
    {
        $validation = $this->validationService->validate($request->jenis, 'Pelaksanaan');
        if (!$validation['success']) {
            return response()->json(['success' => false, 'message' => $validation['message']], 403);
        }

        $taId = Crypt::decryptString($request->ta_id);
        $validateData = $this->permissionService->validateData($request->all(), [
            'nama_kegiatan' => 'required|string|max:255',
            'tempat_kegiatan' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:1000',
            'tanggal' => 'required|date',
        ]);

        if ($validateData !== null) {
            return $validateData;
        }

        DB::beginTransaction();
        try {
            $save['proposal_id'] = $request->proposal_id;
            $save['dosen_id'] = $this->dosenId;
            $save['tahun_akademik_id'] = $taId;
            $save['jenis'] = $request->jenis;
            $save['nama_kegiatan'] = $request->nama_kegiatan;
            $save['tempat_kegiatan'] = $request->tempat_kegiatan;
            $save['keterangan'] = $request->keterangan;
            $save['tanggal'] = $request->tanggal;

            $find = PelaksanaanProposal::where([['tahun_akademik_id', $taId], ['dosen_id', $this->dosenId], ['jenis', $request->jenis]])->first();

            if ($find) {
                HistoryPelaksanaanProposal::create([
                    'pelaksanaan_proposal_id' => $find->id_pelaksanaan_proposal,
                    'nama_kegiatan' => $find->nama_kegiatan,
                    'tempat_kegiatan' => $find->tempat_kegiatan,
                    'keterangan' => $find->keterangan,
                    'tanggal' => $find->tanggal
                ]);

                $find->update($save);
            } else {
                PelaksanaanProposal::create($save);
            }

            DB::commit();
            return $this->permissionService->successResponse('data berhasil dibuat', $save);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Create pelaksanaan proposal: ' . $th->getMessage());
            return $this->permissionService->errorResponse('data gagal dibuat');
        }
    }

    public function deadline(string $id)
    {
        $taId = Crypt::decryptString($id);

        $data = DeadlineProposal::select('tanggal_akhir', 'jenis', 'keterangan', 'aktif')
            ->where([['tahun_akademik_id', $taId], ['keterangan', 'Pelaksanaan']])
            ->whereIn('jenis', ['Penelitian', 'Pengabdian'])
            ->get()
            ->map(function ($dp) {
                return [
                    'deadline' => Carbon::parse($dp->tanggal_akhir)->translatedFormat('d F Y'),
                    'jenis' => $dp->jenis
                ];
            });
        if ($data->count() != 0) {
            return response()->json([
                'success' => true,
                'message' => 'data tersedia',
                'data' => $data
            ], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => null], 400);
        }
    }

    public function listHistory(Request $request, string $id)
    {
        $kmId = Crypt::decryptString($id);
        $data = HistoryPelaksanaanProposal::select(
            'nama_kegiatan',
            'tempat_kegiatan',
            'keterangan',
            'tanggal',
            'created_at'
        )
            ->where('pelaksanaan_proposal_id', $kmId)
            ->latest()
            ->get()
            ->map(function ($hkp) {
                return [
                    'nama_kegiatan' => $hkp->nama_kegiatan,
                    'tempat_kegiatan' => $hkp->tempat_kegiatan,
                    'keterangan' => $hkp->keterangan,
                    'tanggal' => (new DateTime($hkp->tanggal))->format('d-m-Y'),
                    'tgl_upload' => $hkp->created_at->format('d-m-Y')
                ];
            });
        if ($data->count() > 0) {
            Log::info('Show listHistory proposal by : ' . $this->userRole);
            return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $data], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => $data], 400);
        }
    }
}
