<?php

namespace App\Http\Controllers\Surat;

use App\Http\Controllers\Controller;
use App\Models\SuratMoa;
use App\Services\PermissionService;
use App\Services\ProposalValidationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SuratMoaController extends Controller
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

    public function upload(Request $request)
    {
        $id_proposal = Crypt::decryptString($request->id_proposal);
        $validateData = $this->permissionService->validateData($request->all(), [
            'kontrak' => 'required|mimes:pdf,doc,docx|max:3072',
        ]);

        if ($validateData !== null) {
            return $validateData;
        }

        DB::beginTransaction();
        try {
            // Cek apakah data ada
            $find = SuratMoa::where([
                ['proposal_id', $id_proposal],
                ['tahun_akademik_id', $request->ta_id],
                ['dosen_id', $this->dosenId]
            ])->first();

            $file_name = null;

            if ($request->hasFile('kontrak')) {
                $file = $request->file('kontrak');
                $file_folder = 'files/suratMoa';

                // Hapus file yang ada jika diperlukan
                if ($find && $find->file_moa !== null) {
                    if (file_exists($file_folder . '/' . $find->file_moa)) {
                        unlink($file_folder . '/' . $find->file_moa);
                    }
                }

                // Simpan file baru
                $file_name = 'SMU_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($file_folder, $file_name);
            }

            // Buat atau perbarui data
            if ($find) {
                // Perbarui data
                $find->update([
                    'file_moa' => $file_name
                ]);
            } else {
                // Buat data baru
                $find = SuratMoa::create([
                    'proposal_id' => $id_proposal,
                    'tahun_akademik_id' => $request->ta_id,
                    'dosen_id' => $this->dosenId,
                    'jenis' => $request->jenis,
                    'file_moa' => $file_name
                ]);
            }

            DB::commit();
            return $this->permissionService->successResponse('Data berhasil diupload', $find);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Upload surat kontrak: ' . $th->getMessage());
            return $this->permissionService->errorResponse('Data gagal diupload');
        }
    }
}
