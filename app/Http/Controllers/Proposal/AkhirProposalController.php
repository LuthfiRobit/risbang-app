<?php

namespace App\Http\Controllers\Proposal;

use App\Http\Controllers\Controller;
use App\Models\AkhirProposal;
use App\Models\DeadlineProposal;
use App\Models\HistoryAkhirProposal;
use App\Models\KemajuanProposal;
use App\Models\ReviewAkhirProposal;
use App\Services\PermissionService;
use App\Services\ProposalValidationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AkhirProposalController extends Controller
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

        $data = AkhirProposal::select('id_akhir_proposal', 'tahun_akademik_id', 'jenis', 'status_review', 'link_drive', 'file_akhir')
            ->where([['tahun_akademik_id', $taId], ['dosen_id', $dsnId]])
            ->get()
            ->map(function ($kp) {
                return [
                    'id_akh_pro' => Crypt::encryptString($kp->id_akhir_proposal),
                    'id_ta' => Crypt::encryptString($kp->tahun_akademik_id),
                    'jenis' => $kp->jenis,
                    'status_review' => $kp->status_review,
                    'link_drive' => $kp->link_drive,
                    'file_akhir' => $kp->file_akhir
                ];
            });

        if ($data->count() != 0) {
            return response()->json([
                'success' => true, 'message' => 'data tersedia',
                'data' => $data->count(),
                'akhir_penelitian' => $data->where('jenis', 'Penelitian')->first(),
                'akhir_pengabdian' => $data->where('jenis', 'Pengabdian')->first(),
            ], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => null], 400);
        }
    }

    public function show(Request $request, string $id)
    {
        $taId = Crypt::decryptString($id);
        $jenis = $request->query('jenis');
        $one = AkhirProposal::select('id_akhir_proposal', 'tahun_akademik_id', 'jenis', 'status_review', 'link_drive', 'file_akhir')
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
            $one['id_akhir_cript'] = Crypt::encryptString($one->id_akhir_proposal);
            Log::info('Show akhir proposal by : ' . $this->userRole);
            return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $one], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => $one], 400);
        }
    }

    public function store(Request $request)
    {
        $validation = $this->validationService->validate($request->jenis, 'Akhir');
        if (!$validation['success']) {
            return response()->json(['success' => false, 'message' => $validation['message']], 403);
        }

        $taId = Crypt::decryptString($request->ta_id);
        // $dsnId = Crypt::decryptString($request->query('dosen'));
        // $validateData = $this->permissionService->validateData($request->all(), [
        //     'link_drive' => 'required',
        //     'file_akhir' => 'mimes:pdf,doc,docx|max:2048',
        //     'keaslian' => 'required'
        // ]);

        $validateData = $this->permissionService->validateData($request->all(), [
            'link_drive' => 'nullable|url',
            'file_akhir' => 'nullable|mimes:pdf,doc,docx|max:3072',
            'keaslian' => 'required'
        ]);

        if (!$request->filled('link_drive') && !$request->hasFile('file_akhir')) {
            return $this->permissionService->errorResponse('Anda harus mengisi link google drive atau mengunggah file.');
        }

        if ($request->hasFile('file_akhir')) {
            $fileSizeMB = $request->file('file_akhir')->getSize() / 1024 / 1024;
            if ($fileSizeMB > 3 && !$request->filled('link_drive')) {
                return $this->permissionService->errorResponse('Jika file lebih dari 3MB, Anda harus mengisi URL.');
            }
        }

        if ($validateData !== null) {
            return $validateData;
        }

        // $file = $request->file('file_akhir');
        // $file_name = 'FAP_' . uniqid() . '.' . $file->getClientOriginalExtension();

        DB::beginTransaction();
        try {
            $save['proposal_id'] = $request->proposal_id;
            $save['dosen_id'] = $this->dosenId;
            $save['tahun_akademik_id'] = $taId;
            $save['jenis'] = $request->jenis;
            $save['keaslian'] = $request->keaslian;
            $save['link_drive'] = $request->link_drive;
            // $save['file_akhir'] = $file_name;
            if ($request->hasFile('file_akhir')) {
                $file = $request->file('file_akhir');
                $file_name = 'FAP_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $save['file_akhir'] = $file_name;
            } else {
                $save['file_akhir'] = null;
            }


            $find = AkhirProposal::where([['tahun_akademik_id', $taId], ['dosen_id', $this->dosenId], ['jenis', $request->jenis]])->first();
            if ($find) {
                HistoryAkhirProposal::create([
                    'akhir_proposal_id' => $find->id_akhir_proposal,
                    'status_review' => $find->status_review,
                    'keaslian' => $find->keaslian,
                    'link_drive' => $find->link_drive,
                    'file_akhir' => $find->file_akhir
                ]);
                $find->update($save);
                if ($request->hasFile('file_akhir')) {
                    $file_folder = 'files/akhirProposal';
                    $file->move($file_folder, $file_name);
                }
            } else {
                AkhirProposal::create($save);
                if ($request->hasFile('file_akhir')) {
                    $file_folder = 'files/akhirProposal';
                    $file->move($file_folder, $file_name);
                }
            }
            DB::commit();
            return $this->permissionService->successResponse('data berhasil dibuat', $save);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Create akhir proposal: ' . $th->getMessage());
            return $this->permissionService->errorResponse('data gagal dibuat');
        }
    }

    public function deadline(string $id)
    {
        $taId = Crypt::decryptString($id);

        $data = DeadlineProposal::select('tanggal_akhir', 'jenis', 'keterangan', 'aktif')
            ->where([['tahun_akademik_id', $taId], ['keterangan', 'Akhir']])
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

    public function rekap(string $id)
    {
        $taId = Crypt::decryptString($id);
        $data = KemajuanProposal::select('id_kemajuan_proposal', 'status_review', 'jenis', 'updated_at')
            ->where([['tahun_akademik_id', $taId], ['dosen_id', $this->dosenId]])
            ->get()
            ->map(function ($kp) {
                return [
                    'jenis' => $kp->jenis,
                    'status_review' => $kp->status_review,
                    'tgl_update' => Carbon::parse($kp->updated_at)->translatedFormat('d F Y'),
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
        $data = ReviewAkhirProposal::select('komen', 'created_at')
            ->where('akhir_proposal_id', $kmId)
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
        $data = HistoryAkhirProposal::select('status_review', 'link_drive', 'file_akhir', 'created_at')
            ->where('akhir_proposal_id', $kmId)
            ->latest()
            ->get()
            ->map(function ($hkp) {
                return [
                    'status_review' => $hkp->status_review ? $hkp->status_review : 'Belum Direview',
                    'link_drive' => $hkp->link_drive,
                    'file_akhir' => $hkp->file_akhir,
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
