<?php

namespace App\Http\Controllers\Proposal;

use App\Http\Controllers\Controller;
use App\Models\DetailReviewer;
use App\Models\HistoryProposalLuaran;
use App\Models\ProposalLuaran;
use App\Models\ReviewProposalLuaran;
use App\Services\PermissionService;
use App\Services\ProposalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class ProposalLuaranController extends Controller
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

    public function listLuaranWajib(string $id)
    {
        $taId = '';
        $dosenId = '';
        // $id = Crypt::decryptString($id);
        if ($this->userRole == 'reviewer') {
            $find = DetailReviewer::where('id_detail_reviewer', Crypt::decryptString($id))->select('dosen_id', 'tahun_akademik_id')->first();
            $taId = $find->tahun_akademik_id;
            $dosenId = $find->dosen_id;
        } else {
            $taId = Crypt::decryptString($id);
            $dosenId = $this->dosenId;
        }

        ///ambil id dosen dari detail reviewer
        $data = ProposalLuaran::select('id_proposal_luaran', 'dosen_id', 'judul', 'penerbit', 'jenis_luaran', 'jenis_publikasi', 'jenis_haki', 'status_review')
            // ->where([['tahun_akademik_id', $id], ['dosen_id', $this->dosenId]])
            ->where([['tahun_akademik_id', $taId], ['dosen_id', $dosenId]])
            ->whereNot('jenis_luaran', 'Buku')
            ->get()
            ->map(function ($pl) {
                return [
                    'id_proposal_luaran' => Crypt::encryptString($pl->id_proposal_luaran),
                    'dosen_id' => Crypt::encryptString($pl->dosen_id),
                    'judul' => $pl->judul,
                    'penerbit' => $pl->penerbit,
                    'jenis_luaran' => $pl->jenis_luaran,
                    'jenis_publikasi' => $pl->jenis_publikasi,
                    'jenis_haki' => $pl->jenis_haki,
                    'status_review' =>  $pl->status_review != null ? $pl->status_review : '------'
                ];
            });

        if ($data->count() != 0) {
            return response()->json([
                'success' => true, 'message' => 'data tersedia',
                'data' => $data->count(),
                'jurnal_penelitian' => $data->where('jenis_luaran', 'Jurnal Penelitian')->first(),
                'jurnal_pengabdian' => $data->where('jenis_luaran', 'Jurnal Pengabdian')->first(),
                'haki' => $data->where('jenis_luaran', 'Haki')->first()
            ], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => null], 400);
        }
    }

    public function listLuaranTambahan(string $id)
    {
        $taId = '';
        $dosenId = '';
        // $id = Crypt::decryptString($id);
        if ($this->userRole == 'reviewer') {
            $find = DetailReviewer::where('id_detail_reviewer', Crypt::decryptString($id))->select('dosen_id', 'tahun_akademik_id')->first();
            $taId = $find->tahun_akademik_id;
            $dosenId = $find->dosen_id;
        } else {
            $taId = Crypt::decryptString($id);
            $dosenId = $this->dosenId;
        }

        $data = ProposalLuaran::select('id_proposal_luaran', 'dosen_id', 'judul', 'jenis_buku', 'status_review')
            // ->where([['tahun_akademik_id', $id], ['dosen_id', $this->dosenId]])
            ->where([['tahun_akademik_id', $taId], ['dosen_id', $dosenId]])
            ->where('jenis_luaran', 'Buku')
            ->get()
            ->map(function ($pl) {
                return [
                    'id_proposal_luaran' => Crypt::encryptString($pl->id_proposal_luaran),
                    'action' => Crypt::encryptString($pl->id_proposal_luaran),
                    'dosen_id' => Crypt::encryptString($pl->dosen_id),
                    'judul' => $pl->judul,
                    'jenis_buku' => $pl->jenis_buku,
                    'status_review' => $pl->status_review != null ? $pl->status_review : '------'
                ];
            });

        return DataTables::of($data)
            ->addIndexColumn()
            ->toJson();
    }

    public function store(Request $request)
    {
        $tahun_akademik = Crypt::decryptString($request->tahun_akademik);
        $validation = [];
        if ($request->jenis_luaran == 'jurnal') {
            $validation = [
                'judul' => 'required',
                'jenis_publikasi' => 'required',
                'penerbit' => 'required',
            ];
        } else if ($request->jenis_luaran == 'haki') {
            $validation = [
                'judul' => 'required',
                'jenis_haki' => 'required'
            ];
        } else {
            $validation = [
                'judul' => 'required',
                'jenis_buku' => 'required'
            ];
        }

        $validateData = $this->permissionService->validateData($request->all(), $validation);

        if ($validateData !== null) {
            return $validateData;
        }
        DB::beginTransaction();
        try {
            $save['dosen_id'] = $this->dosenId; // ganti dengan dosen auth id nanti
            $save['tahun_akademik_id'] = $tahun_akademik;
            $save['judul'] = $request->judul;

            if ($request->jenis_luaran == 'jurnal') {
                $save['jenis_luaran'] = $request->nama_jenis_luaran;
                $save['jenis_publikasi'] = $request->jenis_publikasi;
                $save['penerbit'] = $request->penerbit;
            } else if ($request->jenis_luaran == 'haki') {
                $save['jenis_luaran'] = 'Haki';
                $save['jenis_haki'] = $request->jenis_haki;
            } else {
                $save['jenis_luaran'] = 'Buku';
                $save['jenis_buku'] = $request->jenis_buku;
            }

            ProposalLuaran::create($save);
            DB::commit();
            return $this->permissionService->successResponse('data berhasil dibuat', $save);
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
            return $this->permissionService->errorResponse('data gagal dibuat');
        }
    }

    public function show(string $id)
    {
        $id = Crypt::decryptString($id);
        $one = ProposalLuaran::select(
            'jenis_luaran',
            'jenis_publikasi',
            'jenis_haki',
            'jenis_buku',
            'judul',
            'penerbit'
        )
            ->where('id_proposal_luaran', $id)->first();
        if ($one) {
            return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $one], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => $one], 400);
        }
    }

    public function update(Request $request, string $id)
    {
        $id = Crypt::decryptString($id);
        $validation = [];
        if ($request->jenis_luaran == 'jurnal') {
            $validation = [
                'judul' => 'required',
                'jenis_publikasi' => 'required',
                'penerbit' => 'required',
            ];
        } else if ($request->jenis_luaran == 'haki') {
            $validation = [
                'judul' => 'required',
                'jenis_haki' => 'required'
            ];
        } else {
            $validation = [
                'judul' => 'required',
                'jenis_buku' => 'required'
            ];
        }

        $validateData = $this->permissionService->validateData($request->all(), $validation);

        if ($validateData !== null) {
            return $validateData;
        }

        DB::beginTransaction();
        try {
            $update['judul'] = $request->judul;

            if ($request->jenis_luaran == 'jurnal') {
                $update['jenis_luaran'] = $request->nama_jenis_luaran;
                $update['jenis_publikasi'] = $request->jenis_publikasi;
                $update['penerbit'] = $request->penerbit;
            } else if ($request->jenis_luaran == 'haki') {
                // $update['jenis_luaran'] = 'Haki';
                $update['jenis_haki'] = $request->jenis_haki;
            } else {
                // $update['jenis_luaran'] = 'Buku';
                $update['jenis_buku'] = $request->jenis_buku;
            }
            $find = ProposalLuaran::where('id_proposal_luaran', $id)->first();
            if ($find) {
                HistoryProposalLuaran::create([
                    'proposal_luaran_id' => $find->id_proposal_luaran,
                    'judul' => $find->judul,
                    'penerbit' => $find->penerbit
                    // 'file_proposal' => $find->file_proposal
                ]);

                $find->update($update);
            }

            DB::commit();
            return $this->permissionService->successResponse('data berhasil dibuat', $update);
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
            return $this->permissionService->errorResponse('data gagal dibuat');
        }
    }

    public function destroy(string $id)
    {
        $id = Crypt::decryptString($id);
        $one = ProposalLuaran::where('id_proposal_luaran', $id)->first();
        $history = HistoryProposalLuaran::where('proposal_luaran_id', $one->id_proposal_luaran)->get();
        $reviews = ReviewProposalLuaran::where('proposal_luaran_id', $id)->get();
        if ($one) {

            DB::beginTransaction();
            try {
                // Hapus semua entri review terkait
                foreach ($reviews as $review) {
                    $review->delete();
                }

                // Hapus semua entri history terkait
                foreach ($history as $item) {
                    $item->delete();
                }

                // Hapus proposal luaran
                $one->delete();

                DB::commit();
                return $this->permissionService->successResponse('user berhasil dihapus');
            } catch (\Throwable $th) {
                DB::rollBack();
                Log::error('Error deleting proposal luaran: ' . $th->getMessage());
                return $this->permissionService->errorResponse('data gagal dihapus');
            }
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => $one], 400);
        }
    }
}
