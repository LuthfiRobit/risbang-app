<?php

namespace App\Http\Controllers\Surat;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use App\Models\SuratTugas;
use App\Services\PermissionService;
use App\Services\ProposalValidationService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SuratTugasController extends Controller
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

    public function download(string $id)
    {
        try {
            $id = Crypt::decryptString($id);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Invalid ID'], 400);
        }

        $query = SuratTugas::where('proposal_id', $id)->first();

        if ($query) {
            $querySecond = Proposal::select(
                'proposal.judul',
                'proposal.dosen_id',
                'proposal.jenis',
                'dosen.nama_dosen',
                'dosen.nidn',
                'prodi.nama_prodi',
                'fakultas.nama_fakultas',
                'surat_tugas_proposal.tempat',
                'surat_tugas_proposal.tanggal',
            )
                ->leftJoin('dosen', 'dosen.id_dosen', '=', 'proposal.dosen_id')
                ->leftJoin('prodi', 'prodi.id_prodi', '=', 'dosen.prodi_id')
                ->leftJoin('fakultas', 'fakultas.id_fakultas', '=', 'prodi.fakultas_id')
                ->leftJoin('surat_tugas_proposal', 'surat_tugas_proposal.proposal_id', '=', 'proposal.id_proposal')
                ->where('id_proposal', $id)->first();
            // Set locale ke bahasa Indonesia
            Carbon::setLocale('id');

            if ($querySecond) {
                $data = [
                    'judul' => $querySecond->judul,
                    'dosen' => $querySecond->nama_dosen,
                    'nidn' => $querySecond->nidn,
                    'jenis' => $querySecond->jenis,
                    'unit' => $querySecond->nama_prodi . ' - ' . $querySecond->nama_fakultas,
                    'tempat' => $querySecond->tempat,
                    'tanggal' => Carbon::parse($querySecond->tanggal)->translatedFormat('d F Y'),
                    'tanggal_cetak' => Carbon::now()->translatedFormat('d F Y')
                ];

                $pdf = Pdf::loadView('export.pdf.suratTugasProposal', $data);
                $filename = 'ST_' . $querySecond->jenis . '_' . $querySecond->nama_dosen . '_' . $querySecond->nidn . '.pdf';

                return $pdf->download($filename)
                    ->header('Content-Type', 'application/pdf')
                    ->header('X-Filename', $filename); // Custom header for filename
            }
        }

        return response()->json(['success' => false, 'message' => 'Data not found, please complete the date and place!'], 400);
    }

    public function store(Request $request)
    {
        $id_proposal = Crypt::decryptString($request->id_proposal);
        $validateData = $this->permissionService->validateData($request->all(), [
            'tanggal_surat' => 'required',
            'tempat_surat' => 'required',
        ]);

        if ($validateData !== null) {
            return $validateData;
        }

        $save['dosen_id'] = $this->dosenId; // ganti auth user id dosen
        $save['tahun_akademik_id'] = $request->ta_id;
        $save['proposal_id'] = $id_proposal;
        $save['jenis'] = $request->jenis;
        $save['tanggal'] = $request->tanggal_surat;
        $save['tempat'] = $request->tempat_surat;
        $find = SuratTugas::where([['proposal_id', $id_proposal], ['tahun_akademik_id', $request->ta_id], ['dosen_id', $this->dosenId]])->first();
        if ($find) {
            $find->update($save);
        } else {
            $store = SuratTugas::create($save);
        }

        return $this->permissionService->successResponse('data berhasil dibuat', $save);
    }

    public function upload(Request $request)
    {
        $id_proposal = Crypt::decryptString($request->id_proposal);
        $validateData = $this->permissionService->validateData($request->all(), [
            'surat' => 'required|mimes:pdf,doc,docx|max:3072',
        ]);

        if ($validateData !== null) {
            return $validateData;
        }

        $find = SuratTugas::where([['proposal_id', $id_proposal], ['tahun_akademik_id', $request->ta_id], ['dosen_id', $this->dosenId]])->first();

        if (!$find) {
            return $this->permissionService->errorResponse('Data tidak ditemukan');
        }

        $file = $request->file('surat');
        $file_name = $find->file_surat;

        DB::beginTransaction();
        try {
            if ($file) {
                $file_folder = 'files/suratTugas';
                if ($file_name !== null) {
                    if (file_exists($file_folder . '/' . $file_name)) {
                        unlink($file_folder . '/' . $file_name);
                    }
                }
                $file_name = 'STU_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($file_folder, $file_name);
            }

            $find->update([
                'file_surat' => $file_name
            ]);

            DB::commit();
            return $this->permissionService->successResponse('Data berhasil diupload', $find);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Upload surat tugas: ' . $th->getMessage());
            return $this->permissionService->errorResponse('Data gagal diupload');
        }
    }
}
