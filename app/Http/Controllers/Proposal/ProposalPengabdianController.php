<?php

namespace App\Http\Controllers\Proposal;

use App\Http\Controllers\Controller;
use App\Models\HistoryProposal;
use App\Models\Proposal;
use App\Models\TahunAkademik;
use App\Rules\WordCount;
use App\Services\PermissionService;
use App\Services\ProposalValidationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class ProposalPengabdianController extends Controller
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

    public function store(Request $request)
    {
        $validation = $this->validationService->validate('Pengabdian', 'Proposal');
        if (!$validation['success']) {
            // return response()->json(['message' => $validation['message']], 403);
            return response()->json(['success' => false, 'message' => $validation['message']], 403);
        }

        $id = Crypt::decryptString($request->id);
        $maxFunding = TahunAkademik::where('id_tahun_akademik', $id)->value('dana_maksimal') ?? 1;
        $validateData = $this->permissionService->validateData($request->all(), [
            'pengabdian_dana' => ['required', 'numeric', 'max:' . $maxFunding],
            'pengabdian_judul' => 'required',
            'pengabdian_abstrak' => ['required', new WordCount(150, 250)],
            'pengabdian_kata_kunci' => 'required',
            'pengabdian_latar_belakang' => ['required', new WordCount(150, 250)],
            'pengabdian_metode' => ['required', new WordCount(150, 250)],
            'pengabdian_rencana' => ['required', new WordCount(150, 250)],
            'pengabdian_dapus' => 'required',
            'pengabdian_jenis_pengabdian' => 'required',
            'pengabdian_file_proposal' => $request->hasFile('pengabdian_file_proposal') ? 'mimes:pdf|max:3072' : 'nullable'
        ], [
            'pengabdian_dana.required' => 'Dana pengabdian wajib diisi.',
            'pengabdian_dana.numeric' => 'Dana pengabdian harus berupa angka.',
            'pengabdian_dana.max' => 'Dana pengabdian tidak boleh melebihi :max.',
        ]);

        if ($validateData !== null) {
            return $validateData;
        }

        $file = $request->file('pengabdian_file_proposal');
        $file_name = 'FPENG_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file_folder = 'files/proposalPengabdian';

        $save['dosen_id'] = $this->dosenId; // ganti auth user id dosen
        $save['tahun_akademik_id'] = $id;
        $save['jenis'] = 'Pengabdian';
        $save['jenis_pengabdian'] = 'Pengabdian';
        $save['dana'] = $request->pengabdian_dana;
        $save['judul'] = $request->pengabdian_judul;
        $save['abstrak'] = $request->pengabdian_abstrak;
        $save['kata_kunci'] = $request->pengabdian_kata_kunci;
        $save['latar_belakang'] = $request->pengabdian_latar_belakang;
        $save['metode'] = $request->pengabdian_metode;
        $save['rencana'] = $request->pengabdian_rencana;
        $save['dapus'] = $request->pengabdian_dapus;
        $save['jenis_pengabdian'] = $request->pengabdian_jenis_pengabdian;
        $save['file_proposal'] = $file_name;
        $find = Proposal::where([['tahun_akademik_id', $id], ['dosen_id', $this->dosenId], ['jenis', 'Pengabdian']])->first();
        if ($find) {
            HistoryProposal::create([
                'proposal_id' => $find->id_proposal,
                'dana' => $find->dana,
                'judul' => $find->judul,
                'abstrak' => $find->abstrak,
                'kata_kunci' => $find->kata_kunci,
                'latar_belakang' => $find->latar_belakang,
                'metode' => $find->metode,
                'rencana' => $find->rencana,
                'dapus' => $find->dapus,
                'file_proposal' => $find->file_proposal
            ]);
            $find->update($save);
            if ($file) {
                $file->move($file_folder, $file_name);
            }
        } else {
            $store = Proposal::create($save);
            if ($file) {
                $file->move($file_folder, $file_name);
            }
        }

        return $this->permissionService->successResponse('data berhasil dibuat', $save);
    }

    public function show(string $id)
    {
        $id = Crypt::decryptString($id);

        $one = Proposal::select(
            'proposal.id_proposal',
            'proposal.jenis',
            'proposal.status',
            'proposal.status_review',
            'proposal.jenis_pengabdian',
            'proposal.dana',
            'proposal.judul',
            'proposal.abstrak',
            'proposal.kata_kunci',
            'proposal.latar_belakang',
            'proposal.metode',
            'proposal.rencana',
            'proposal.dapus',
            'proposal.file_proposal'
        )
            ->where('proposal.jenis', 'Pengabdian')
            //auth reviewer
            ->when($this->userRole == 'reviewer', function ($q)  use ($id) {
                $q->where('proposal.id_proposal', $id);
            })
            // auth dosen
            ->when($this->userRole == 'dosen', function ($q)  use ($id) {
                $q->where([['proposal.tahun_akademik_id', $id], ['proposal.dosen_id', $this->dosenId]]);
            })
            ->latest('proposal.created_at')
            ->first();
        $one['id_cript'] = Crypt::encryptString($one->id_proposal);

        if ($one) {
            return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $one], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => $one], 400);
        }
    }

    public function suratTugas(string $id)
    {
        $id = Crypt::decryptString($id);

        $one = Proposal::select(
            'proposal.id_proposal',
            'proposal.jenis',
            'proposal.status_review',
            'proposal.judul',
            'proposal.tahun_akademik_id',
            'proposal.dosen_id',
            'surat_tugas_proposal.tempat',
            'surat_tugas_proposal.tanggal',
            'surat_tugas_proposal.file_surat',
        )
            ->leftJoin('dosen', 'dosen.id_dosen', '=', 'proposal.dosen_id')
            ->leftJoin('surat_tugas_proposal', 'surat_tugas_proposal.proposal_id', '=', 'proposal.id_proposal')
            ->where('proposal.jenis', 'Pengabdian')
            // auth dosen
            ->when($this->userRole == 'dosen', function ($q)  use ($id) {
                $q->where([['proposal.tahun_akademik_id', $id], ['proposal.dosen_id', $this->dosenId]]);
            })
            ->latest('proposal.created_at')
            ->first();
        if ($one) {
            $one['id_cript'] = Crypt::encryptString($one->id_proposal);
            return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $one], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => $one], 400);
        }
    }

    public function suratMoa(string $id)
    {
        $id = Crypt::decryptString($id);

        $one = Proposal::select(
            'proposal.id_proposal',
            'proposal.jenis',
            'proposal.status_review',
            'proposal.judul',
            'proposal.tahun_akademik_id',
            'proposal.dosen_id',
            'surat_moa_proposal.file_moa',
        )
            ->leftJoin('dosen', 'dosen.id_dosen', '=', 'proposal.dosen_id')
            ->leftJoin('surat_moa_proposal', 'surat_moa_proposal.proposal_id', '=', 'proposal.id_proposal')
            ->where('proposal.jenis', 'Pengabdian')
            // auth dosen
            ->when($this->userRole == 'dosen', function ($q)  use ($id) {
                $q->where([['proposal.tahun_akademik_id', $id], ['proposal.dosen_id', $this->dosenId]]);
            })
            ->latest('proposal.created_at')
            ->first();
        if ($one) {
            $one['id_cript'] = Crypt::encryptString($one->id_proposal);
            return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $one], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => $one], 400);
        }
    }
}
