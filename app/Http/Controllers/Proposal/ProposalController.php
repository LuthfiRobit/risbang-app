<?php

namespace App\Http\Controllers\Proposal;

use App\Http\Controllers\Controller;
use App\Models\AkhirProposal;
use App\Models\KemajuanProposal;
use App\Models\LuaranProposal;
use App\Models\Proposal;
use App\Models\TahunAkademik;
use App\Services\PermissionService;
use App\Services\ProposalService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

use function PHPSTORM_META\map;

class ProposalController extends Controller
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

    public function indexPengajuan()
    {
        return view('proposal.pengajuan.index');
    }

    public function listPengajuan()
    {
        $currentDate = Carbon::now();
        $data = DB::table("tahun_akademik")
            ->leftJoin("deadline_proposal", function ($join) {
                $join->on("tahun_akademik.id_tahun_akademik", "=", "deadline_proposal.tahun_akademik_id");
            })
            ->select("tahun_akademik.id_tahun_akademik", "deadline_proposal.tahun_akademik_id", "tahun_akademik.nama_tahun_akademik", "deadline_proposal.tanggal_mulai", "deadline_proposal.tanggal_akhir", "deadline_proposal.jenis", "deadline_proposal.keterangan", "deadline_proposal.aktif")
            ->where("deadline_proposal.keterangan", "=", 'Proposal')
            ->orderBy("tahun_akademik.tahun_akhir", "desc")
            ->groupBy("tahun_akademik.id_tahun_akademik")
            ->get()
            ->map(
                function ($ta) use ($currentDate) {
                    return [
                        'id_tahun_akademik' => $ta->id_tahun_akademik,
                        'nama' => $ta->nama_tahun_akademik,
                        'tgl_mulai' => $ta->tanggal_mulai,
                        'tgl_akhir' => $ta->tanggal_akhir,
                        'jenis' => $ta->jenis,
                        'keterangan' => $ta->keterangan,
                        'aktif' => $currentDate->gt(Carbon::parse($ta->tanggal_akhir)) ? 'Ditutup' : 'Dibuka',
                        'action' => Crypt::encryptString($ta->id_tahun_akademik)
                    ];
                }
            );

        return DataTables::of($data)
            ->addIndexColumn()
            ->toJson();
    }

    public function overview(string $id)
    {
        $id = Crypt::decryptString($id);
        $penelitian = Proposal::select('id_proposal', 'status', 'status_review')->where([['jenis', 'Penelitian'], ['tahun_akademik_id', $id], ['dosen_id', $this->dosenId]])->first();
        $pengabdian = Proposal::select('id_proposal', 'status', 'status_review')->where([['jenis', 'Pengabdian'], ['tahun_akademik_id', $id], ['dosen_id', $this->dosenId]])->first();
        $accessTh = false;
        $access = false;
        if ($penelitian != '' && $pengabdian != '') {
            if ($penelitian->status_review == 'Diterima' && $pengabdian->status_review == 'Diterima') {
                $access = true;
            }
        }
        // dd($access);
        return view('proposal.pengajuan.overview', compact('access'));
    }


    public function indexKemajuan()
    {
        return view('proposal.kemajuan.index');
    }

    public function listKemajuan()
    {
        $currentDate = Carbon::now();
        $data = DB::table("tahun_akademik")
            ->leftJoin("deadline_proposal", function ($join) {
                $join->on("tahun_akademik.id_tahun_akademik", "=", "deadline_proposal.tahun_akademik_id");
            })
            ->select("tahun_akademik.id_tahun_akademik", "deadline_proposal.tahun_akademik_id", "tahun_akademik.nama_tahun_akademik", "deadline_proposal.tanggal_mulai", "deadline_proposal.tanggal_akhir", "deadline_proposal.jenis", "deadline_proposal.keterangan", "deadline_proposal.aktif")
            ->where("deadline_proposal.keterangan", "=", 'Kemajuan')
            ->orderBy("tahun_akademik.tahun_akhir", "desc")
            ->groupBy("tahun_akademik.id_tahun_akademik")
            ->get()
            ->map(
                function ($ta) use ($currentDate) {
                    return [
                        'id_tahun_akademik' => $ta->id_tahun_akademik,
                        'nama' => $ta->nama_tahun_akademik,
                        'tgl_mulai' => $ta->tanggal_mulai,
                        'tgl_akhir' => $ta->tanggal_akhir,
                        'jenis' => $ta->jenis,
                        'keterangan' => $ta->keterangan,
                        'aktif' => $currentDate->gt(Carbon::parse($ta->tanggal_akhir)) ? 'Ditutup' : 'Dibuka',
                        'action' => Crypt::encryptString($ta->id_tahun_akademik)
                    ];
                }
            );

        return DataTables::of($data)
            ->addIndexColumn()
            ->toJson();
    }

    public function overviewKemajuan(Request $request, string $id)
    {
        $dosenId = Crypt::decryptString($request->query('dosen'));
        $id = Crypt::decryptString($id);

        $access = $this->proposalService->proposalAccess($id, $dosenId);

        if ($access['access_pengajuan']) {
            return view('proposal.kemajuan.overview', $access);
        } else {
            return redirect()->back()->with('fail', 'Anda belum bisa mengakses halaman kemajuan, pastikan proposal penelitian dan pengabdian sudah diterima');
        }
    }

    public function indexAkhir()
    {
        return view('proposal.akhir.index');
    }

    public function listAkhir()
    {
        $currentDate = Carbon::now();
        $data = DB::table("tahun_akademik")
            ->leftJoin("deadline_proposal", function ($join) {
                $join->on("tahun_akademik.id_tahun_akademik", "=", "deadline_proposal.tahun_akademik_id");
            })
            ->select("tahun_akademik.id_tahun_akademik", "deadline_proposal.tahun_akademik_id", "tahun_akademik.nama_tahun_akademik", "deadline_proposal.tanggal_mulai", "deadline_proposal.tanggal_akhir", "deadline_proposal.jenis", "deadline_proposal.keterangan", "deadline_proposal.aktif")
            ->where("deadline_proposal.keterangan", "=", 'Akhir')
            ->orderBy("tahun_akademik.tahun_akhir", "desc")
            ->groupBy("tahun_akademik.id_tahun_akademik")
            ->get()
            ->map(
                function ($ta) use ($currentDate) {
                    return [
                        'id_tahun_akademik' => $ta->id_tahun_akademik,
                        'nama' => $ta->nama_tahun_akademik,
                        'tgl_mulai' => $ta->tanggal_mulai,
                        'tgl_akhir' => $ta->tanggal_akhir,
                        'jenis' => $ta->jenis,
                        'keterangan' => $ta->keterangan,
                        'aktif' => $currentDate->gt(Carbon::parse($ta->tanggal_akhir)) ? 'Ditutup' : 'Dibuka',
                        'action' => Crypt::encryptString($ta->id_tahun_akademik)
                    ];
                }
            );

        return DataTables::of($data)
            ->addIndexColumn()
            ->toJson();
    }

    public function overviewAkhir(Request $request, string $id)
    {
        $dosenId = Crypt::decryptString($request->query('dosen'));
        $id = Crypt::decryptString($id);

        $access = $this->proposalService->proposalAccess($id, $dosenId);

        if ($access['access_pengajuan']) {
            if ($access['access_kemajuan']) {
                return view('proposal.akhir.overview', $access);
            } else {
                // return $access;
                return redirect()->back()->with('fail', 'Anda belum bisa mengakses halaman akhir, pastikan laporan kemajuan penelitian dan pengabdian sudah diterima');
            }
        } else {
            return redirect()->back()->with('fail', 'Anda belum bisa mengakses halaman akhir, pastikan proposal penelitian dan pengabdian sudah diterima');
        }
    }

    public function indexLuaran()
    {
        return view('proposal.luaran.index');
    }

    public function listLuaran()
    {
        $currentDate = Carbon::now();
        $data = DB::table("tahun_akademik")
            ->leftJoin("deadline_proposal", function ($join) {
                $join->on("tahun_akademik.id_tahun_akademik", "=", "deadline_proposal.tahun_akademik_id");
            })
            ->select("tahun_akademik.id_tahun_akademik", "deadline_proposal.tahun_akademik_id", "tahun_akademik.nama_tahun_akademik", "deadline_proposal.tanggal_mulai", "deadline_proposal.tanggal_akhir", "deadline_proposal.jenis", "deadline_proposal.keterangan", "deadline_proposal.aktif")
            ->where("deadline_proposal.keterangan", "=", 'Luaran')
            ->orderBy("tahun_akademik.tahun_akhir", "desc")
            ->groupBy("tahun_akademik.id_tahun_akademik")
            ->get()
            ->map(
                function ($ta) use ($currentDate) {
                    return [
                        'id_tahun_akademik' => $ta->id_tahun_akademik,
                        'nama' => $ta->nama_tahun_akademik,
                        'tgl_mulai' => $ta->tanggal_mulai,
                        'tgl_akhir' => $ta->tanggal_akhir,
                        'jenis' => $ta->jenis,
                        'keterangan' => $ta->keterangan,
                        'aktif' => $currentDate->gt(Carbon::parse($ta->tanggal_akhir)) ? 'Ditutup' : 'Dibuka',
                        'action' => Crypt::encryptString($ta->id_tahun_akademik)
                    ];
                }
            );

        return DataTables::of($data)
            ->addIndexColumn()
            ->toJson();
    }

    public function overviewLuaran(Request $request, string $id)
    {
        $dosenId = Crypt::decryptString($request->query('dosen'));
        $id = Crypt::decryptString($id);

        $access = $this->proposalService->proposalAccess($id, $dosenId);

        if ($access['access_pengajuan']) {
            if ($access['access_akhir']) {
                return view('proposal.luaran.overview', $access);
            } else {
                // return $access;
                return redirect()->back()->with('fail', 'Anda belum bisa mengakses halaman luaran, pastikan laporan akhir penelitian dan pengabdian sudah diterima');
            }
        } else {
            return redirect()->back()->with('fail', 'Anda belum bisa mengakses halaman luaran, pastikan proposal penelitian dan pengabdian sudah diterima');
        }
    }
}
