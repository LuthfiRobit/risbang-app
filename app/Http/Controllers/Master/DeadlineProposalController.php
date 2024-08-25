<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\DeadlineProposal;
use App\Models\TahunAkademik;
use App\Services\PermissionService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class DeadlineProposalController extends Controller
{
    protected PermissionService $permissionService;


    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function index()
    {
        // $tahunAkademik = TahunAkademik::select('id_tahun_akademik', 'nama_tahun_akademik')->where('aktif', 'y')->get();
        $tahunAkademik = TahunAkademik::select('id_tahun_akademik', 'nama_tahun_akademik')->get();
        return view('setting.deadlineProposal.index', compact('tahunAkademik'));
    }

    public function list()
    {
        $data = DeadlineProposal::select(
            'deadline_proposal.id_deadline_proposal',
            // 'deadline_proposal.tanggal_mulai',
            // 'deadline_proposal.tanggal_akhir',
            'deadline_proposal.nama_deadline_proposal',
            'deadline_proposal.jenis',
            'deadline_proposal.keterangan',
            'deadline_proposal.aktif',
            'tahun_akademik.nama_tahun_akademik'
        )
            ->leftJoin('tahun_akademik', 'tahun_akademik.id_tahun_akademik', '=', 'deadline_proposal.tahun_akademik_id')
            ->orderBy('deadline_proposal.created_at', 'DESC')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('cek', function ($model) {
                return Crypt::encryptString($model->id_deadline_proposal);
            })
            ->addColumn('action', function ($model) {
                return Crypt::encryptString($model->id_deadline_proposal);
            })
            ->toJson();
    }

    public function show(string $id)
    {
        $id = Crypt::decryptString($id);
        $one = DeadlineProposal::select(
            'id_deadline_proposal',
            'tahun_akademik_id',
            'tahun_akademik.nama_tahun_akademik',
            'tanggal_mulai',
            'tanggal_akhir',
            'jenis',
            'keterangan',
            'deskripsi',
            'deadline_proposal.aktif'
        )
            ->leftJoin('tahun_akademik', 'tahun_akademik.id_tahun_akademik', '=', 'deadline_proposal.tahun_akademik_id')
            ->where('id_deadline_proposal', $id)->first();
        if ($one) {
            return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $one], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => $one], 400);
        }
    }

    public function store(Request $request)
    {
        $validateData = $this->permissionService->validateData($request->all(), [
            'tahun_akademik' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_akhir' => 'required',
            'jenis' => 'required',
            'keterangan' => 'required',
            'aktifasi' => 'required',
        ]);

        if ($validateData !== null) {
            return $validateData;
        }

        $save['tanggal_mulai'] = $request->tanggal_mulai;
        $save['tanggal_akhir'] = $request->tanggal_akhir;
        $save['tahun_akademik_id'] = $request->tahun_akademik;
        $save['jenis'] = $request->jenis;
        $save['keterangan'] = $request->keterangan;
        $save['nama_deadline_proposal'] = Carbon::parse($request->tanggal_mulai)->format('d M Y') . '-' . Carbon::parse($request->tanggal_akhir)->format('d M Y');;
        $save['deskripsi'] = $request->deskripsi;
        $save['aktif'] = $request->aktifasi;
        $store = DeadlineProposal::create($save);

        return $this->permissionService->successResponse('data berhasil dibuat', $save);
        // return $request->all();
    }

    public function update(Request $request, string $id)
    {
        $id = Crypt::decryptString($id);
        $validateData = $this->permissionService->validateData($request->all(), [
            'tahun_akademik' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_akhir' => 'required',
            'jenis' => 'required',
            'keterangan' => 'required',
            'aktifasi' => 'required',
        ], [
            'required' => 'Input :attribute wajib diisi.',
        ]);

        if ($validateData !== null) {
            return $validateData;
        }

        $update['tanggal_mulai'] = $request->tanggal_mulai;
        $update['tanggal_akhir'] = $request->tanggal_akhir;
        $update['tahun_akademik_id'] = $request->tahun_akademik;
        $update['jenis'] = $request->jenis;
        $update['keterangan'] = $request->keterangan;
        $update['nama_deadline_proposal'] = Carbon::parse($request->tanggal_mulai)->format('d M Y') . '-' . Carbon::parse($request->tanggal_akhir)->format('d M Y');
        $update['deskripsi'] = $request->deskripsi;
        $update['aktif'] = $request->aktifasi;
        DeadlineProposal::where('id_deadline_proposal', $id)->update($update);

        return $this->permissionService->successResponse('data berhasil diperbarui', $update);
    }

    public function updateMultiple(Request $request)
    {
        foreach ($request->id_deadline_proposal as $row) {
            $update['aktif'] = $request->aktif;
            DeadlineProposal::where('id_deadline_proposal', $row)->update($update);
        }

        return $this->permissionService->successResponse('data pembaruan status berhasil');
    }
}
