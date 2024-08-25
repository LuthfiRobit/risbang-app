<?php

namespace App\Http\Controllers\Proposal;

use App\Http\Controllers\Controller;
use App\Models\DeadlineProposal;
use App\Models\HistoryKemajuanProposal;
use App\Models\KemajuanProposal;
use App\Models\ReviewKemajuanProposal;
use App\Services\PermissionService;
use App\Services\ProposalValidationService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KemajuanProposalController extends Controller
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

        $data = KemajuanProposal::select('id_kemajuan_proposal', 'tahun_akademik_id', 'jenis', 'status_review', 'link_drive', 'file_kemajuan')
            ->where([['tahun_akademik_id', $taId], ['dosen_id', $dsnId]])
            ->get()
            ->map(function ($kp) {
                return [
                    'id_kem_pro' => Crypt::encryptString($kp->id_kemajuan_proposal),
                    'id_ta' => Crypt::encryptString($kp->tahun_akademik_id),
                    'jenis' => $kp->jenis,
                    'status_review' => $kp->status_review,
                    'link_drive' => $kp->link_drive,
                    'file_kemajuan' => $kp->file_kemajuan
                ];
            });

        if ($data->count() != 0) {
            return response()->json([
                'success' => true, 'message' => 'data tersedia',
                'data' => $data->count(),
                'kemajuan_penelitian' => $data->where('jenis', 'Penelitian')->first(),
                'kemajuan_pengabdian' => $data->where('jenis', 'Pengabdian')->first(),
            ], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => null], 400);
        }
    }

    public function show(Request $request, string $id)
    {
        $taId = Crypt::decryptString($id);
        $jenis = $request->query('jenis');
        $one = KemajuanProposal::select('id_kemajuan_proposal', 'tahun_akademik_id', 'jenis', 'status_review', 'link_drive', 'file_kemajuan')
            //dosen
            ->when($this->userRole == 'dosen', function ($q)  use ($taId, $jenis) {
                $q->where([['tahun_akademik_id', $taId], ['dosen_id', $this->dosenId], ['jenis', $jenis]]);
            })
            //reviewer
            ->when($this->userRole == 'reviewer', function ($q)  use ($taId, $jenis, $request) {
                $dsnId = Crypt::decryptString($request->query('dosen'));
                $q->where([['tahun_akademik_id', $taId], ['dosen_id', $dsnId], ['jenis', $jenis]]);
            })
            ->latest()
            ->first();
        if ($one) {
            $one['id_kemajuan_cript'] = Crypt::encryptString($one->id_kemajuan_proposal);
            Log::info('Show kemajuan proposal by : ' . $this->userRole);
            return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $one], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => $one], 400);
        }
    }

    public function store(Request $request)
    {
        $validation = $this->validationService->validate($request->jenis, 'Kemajuan');
        if (!$validation['success']) {
            return response()->json(['success' => false, 'message' => $validation['message']], 403);
        }

        $taId = Crypt::decryptString($request->ta_id);
        $validateData = $this->permissionService->validateData($request->all(), [
            'link_drive' => 'nullable|url',
            'file_kemajuan' => 'nullable|mimes:pdf,doc,docx|max:3072',
        ]);

        if (!$request->filled('link_drive') && !$request->hasFile('file_kemajuan')) {
            return $this->permissionService->errorResponse('Anda harus mengisi link google drive atau mengunggah file.');
        }

        if ($request->hasFile('file_kemajuan')) {
            $fileSizeMB = $request->file('file_kemajuan')->getSize() / 1024 / 1024;
            if ($fileSizeMB > 3 && !$request->filled('link_drive')) {
                return $this->permissionService->errorResponse('Jika file lebih dari 3MB, Anda harus mengisi URL.');
            }
        }

        if ($validateData !== null) {
            return $validateData;
        }

        DB::beginTransaction();
        try {
            $save['proposal_id'] = $request->proposal_id;
            $save['dosen_id'] = $this->dosenId;
            $save['tahun_akademik_id'] = $taId;
            $save['jenis'] = $request->jenis;
            $save['link_drive'] = $request->link_drive;

            if ($request->hasFile('file_kemajuan')) {
                $file = $request->file('file_kemajuan');
                $file_name = 'FKP_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $save['file_kemajuan'] = $file_name;
            } else {
                $save['file_kemajuan'] = null;
            }

            $find = KemajuanProposal::where([['tahun_akademik_id', $taId], ['dosen_id', $this->dosenId], ['jenis', $request->jenis]])->first();

            if ($find) {
                HistoryKemajuanProposal::create([
                    'kemajuan_proposal_id' => $find->id_kemajuan_proposal,
                    'status_review' => $find->status_review,
                    'link_drive' => $find->link_drive,
                    'file_kemajuan' => $find->file_kemajuan
                ]);

                $find->update($save);

                if ($request->hasFile('file_kemajuan')) {
                    $file_folder = 'files/kemajuanProposal';
                    $file->move($file_folder, $file_name);
                }
            } else {
                KemajuanProposal::create($save);

                if ($request->hasFile('file_kemajuan')) {
                    $file_folder = 'files/kemajuanProposal';
                    $file->move($file_folder, $file_name);
                }
            }

            DB::commit();
            return $this->permissionService->successResponse('data berhasil dibuat', $save);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Create kemajuan proposal: ' . $th->getMessage());
            return $this->permissionService->errorResponse('data gagal dibuat');
        }
    }

    public function deadline(string $id)
    {
        $taId = Crypt::decryptString($id);

        $data = DeadlineProposal::select('tanggal_akhir', 'jenis', 'keterangan', 'aktif')
            ->where([['tahun_akademik_id', $taId], ['keterangan', 'Kemajuan']])
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

    public function listReview(Request $request, string $id)
    {
        $kmId = Crypt::decryptString($id);
        $data = ReviewKemajuanProposal::select('komen', 'created_at')
            ->where('kemajuan_proposal_id', $kmId)
            ->latest()
            ->get()
            ->map(function ($rkp) {
                return [
                    'komen' => $rkp->komen,
                    'tgl_review' => $rkp->created_at->format('d-m-Y')
                ];
            });
        if ($data->count() > 0) {
            Log::info('Show listReview proposal by : ' . $this->userRole);
            return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $data], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => $data], 400);
        }
    }

    public function listHistory(Request $request, string $id)
    {
        $kmId = Crypt::decryptString($id);
        $data = HistoryKemajuanProposal::select('status_review', 'link_drive', 'file_kemajuan', 'created_at')
            ->where('kemajuan_proposal_id', $kmId)
            ->latest()
            ->get()
            ->map(function ($hkp) {
                return [
                    'status_review' => $hkp->status_review ? $hkp->status_review : 'Belum Direview',
                    'link_drive' => $hkp->link_drive,
                    'file_kemajuan' => $hkp->file_kemajuan,
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
