<?php

namespace App\Http\Controllers\Proposal;

use App\Http\Controllers\Controller;
use App\Models\AkhirProposal;
use App\Models\DeadlineProposal;
use App\Models\HistoryLuaranProposal;
use App\Models\LuaranProposal;
use App\Services\PermissionService;
use App\Services\ProposalValidationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LuaranProposalController extends Controller
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

        $data = LuaranProposal::select('id_luaran_proposal', 'tahun_akademik_id', 'jenis', 'status_review', 'link_drive', 'file_luaran')
            ->where([['tahun_akademik_id', $taId], ['dosen_id', $dsnId]])
            ->get()
            ->map(function ($kp) {
                return [
                    'id_akh_pro' => Crypt::encryptString($kp->id_luaran_proposal),
                    'id_ta' => Crypt::encryptString($kp->tahun_akademik_id),
                    'jenis' => $kp->jenis,
                    'status_review' => $kp->status_review,
                    'link_drive' => $kp->link_drive,
                    'file_luaran' => $kp->file_luaran
                ];
            });

        if ($data->count() != 0) {
            return response()->json([
                'success' => true, 'message' => 'data tersedia',
                'data' => $data->count(),
                'luaran_penelitian' => $data->where('jenis', 'Penelitian')->first(),
                'luaran_pengabdian' => $data->where('jenis', 'Pengabdian')->first(),
            ], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => null], 400);
        }
    }

    public function show(Request $request, string $id)
    {
        $taId = Crypt::decryptString($id);
        $jenis = $request->query('jenis');
        $one = LuaranProposal::select(
            'id_luaran_proposal',
            'tahun_akademik_id',
            'jenis',
            'status_review',
            'jenis_publikasi',
            'judul',
            'penerbit',
            'tahun_pelaksanaan',
            'volume',
            'nomor',
            'link',
            'issn',
            'file_luaran'
        )
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
            $one['id_luaran_cript'] = Crypt::encryptString($one->id_luaran_proposal);
            Log::info('Show luaran proposal by : ' . $this->userRole);
            return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $one], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => $one], 400);
        }
    }

    public function store(Request $request)
    {
        $validation = $this->validationService->validate($request->jenis, 'Luaran');
        if (!$validation['success']) {
            // return response()->json(['message' => $validation['message']], 403);
            return response()->json(['success' => false, 'message' => $validation['message']], 403);
        }

        $taId = Crypt::decryptString($request->ta_id);
        // $dsnId = Crypt::decryptString($request->query('dosen'));
        $validateData = $this->permissionService->validateData($request->all(), [
            'judul' => 'required',
            'penerbit' => 'required',
            'publikasi' => 'required',
            'tahun' => 'required',
            'volume' => 'required',
            'nomor' => 'required',
            'link' => 'required|url',
            'issn' => 'required',
            'file_luaran' => 'required|mimes:pdf|max:3072',
        ]);

        if ($validateData !== null) {
            return $validateData;
        }

        $file = $request->file('file_luaran');
        $file_name = 'FLP_' . uniqid() . '.' . $file->getClientOriginalExtension();

        DB::beginTransaction();
        try {
            $save['proposal_id'] = $request->proposal_id;
            $save['dosen_id'] = $this->dosenId;
            $save['tahun_akademik_id'] = $taId;
            $save['jenis'] = $request->jenis;
            $save['jenis_publikasi'] = $request->publikasi;
            $save['penerbit'] = $request->penerbit;
            $save['judul'] = $request->judul;
            $save['tahun_pelaksanaan'] = $request->tahun;
            $save['volume'] = $request->volume;
            $save['nomor'] = $request->nomor;
            $save['link'] = $request->link;
            $save['issn'] = $request->issn;
            $save['file_luaran'] = $file_name;

            $find = LuaranProposal::where([['tahun_akademik_id', $taId], ['dosen_id', $this->dosenId], ['jenis', $request->jenis]])->first();
            if ($find) {
                HistoryLuaranProposal::create([
                    'luaran_proposal_id' => $find->id_luaran_proposal,
                    'status_review' => $find->status_review,
                    'jenis_publikasi' => $find->jenis_publikasi,
                    'judul' => $find->judul,
                    'penerbit' => $find->penerbit,
                    'tahun_pelaksanaan' => $find->tahun_pelaksanaan,
                    'volume' => $find->volume,
                    'nomor' => $find->nomor,
                    'link' => $find->link,
                    'issn' => $find->issn,
                    'file_luaran' => $find->file_luaran
                ]);
                $find->update($save);
                $file_folder = 'files/luaranProposal';
                $file->move($file_folder, $file_name);
            } else {
                LuaranProposal::create($save);
                $file_folder = 'files/luaranProposal';
                $file->move($file_folder, $file_name);
            }
            DB::commit();
            return $this->permissionService->successResponse('data berhasil dibuat', $save);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Create luaran proposal: ' . $th->getMessage());
            return $this->permissionService->errorResponse('data gagal dibuat');
        }
    }

    public function deadline(string $id)
    {
        $taId = Crypt::decryptString($id);

        $data = DeadlineProposal::select('tanggal_akhir', 'jenis', 'keterangan', 'aktif')
            ->where([['tahun_akademik_id', $taId], ['keterangan', 'Luaran']])
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
        $data = AkhirProposal::select('id_akhir_proposal', 'status_review', 'jenis', 'updated_at')
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
}
