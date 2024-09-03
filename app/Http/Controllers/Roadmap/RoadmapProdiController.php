<?php

namespace App\Http\Controllers\Roadmap;

use App\Http\Controllers\Controller;
use App\Models\RentanWaktu;
use App\Models\RoadMap;
use App\Services\DataActiveService;
use App\Services\PermissionService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class RoadmapProdiController extends Controller
{
    protected PermissionService $permissionService;
    protected DataActiveService $dataActiveService;
    protected $userId;
    protected $dosenId;
    protected $reviewerId;
    protected $kaprodiId;
    protected $dekanId;
    protected $userRole;
    protected $dosenRole;

    public function __construct(PermissionService $permissionService, DataActiveService $dataActiveService)
    {
        $this->permissionService = $permissionService;
        $this->dataActiveService = $dataActiveService;
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

    public function index()
    {
        $rentanWaktu = RentanWaktu::select('id_rentan_waktu', 'nama_rentan_waktu')->get();
        return view('roadmap.prodi.index', compact('rentanWaktu'));
    }

    public function list()
    {
        $data = RoadMap::select(
            "roadmap.id_roadmap",
            "roadmap.jenis",
            "roadmap.nama_roadmap",
            "roadmap.berkas",
            "roadmap.status",
            "roadmap.created_at",
            "rentan_waktu.nama_rentan_waktu",
            "prodi.nama_prodi",
            "fakultas.nama_fakultas"
        )
            ->leftJoin('prodi', 'prodi.id_prodi', '=', 'roadmap.prodi_id')
            ->leftJoin('rentan_waktu', 'rentan_waktu.id_rentan_waktu', '=', 'roadmap.rentan_waktu_id')
            ->leftJoin('fakultas', 'fakultas.id_fakultas', '=', 'prodi.fakultas_id')
            //auth dosen
            ->when($this->dosenRole == 'kaprodi', function ($q) {
                $q->where('roadmap.prodi_id', $this->kaprodiId);
            })
            // auth kaprodi
            ->when($this->userRole == 'admin', function ($q) {
                $q->where('roadmap.prodi_id', '!=', '');
            })
            // auth kaprodi
            ->when($this->dosenRole == 'dekan', function ($q) {
                $q->where('prodi.fakultas_id', $this->dekanId);
            })
            ->orderBy('roadmap.created_at', 'DESC')->get()
            ->map(function ($q) {
                return [
                    'action' => Crypt::encryptString($q->id_roadmap),
                    'jenis' => $q->jenis,
                    'status' => $q->status,
                    'prodi' => $q->nama_prodi,
                    'fakultas' => $q->nama_fakultas,
                    'tgl' => Carbon::parse($q->created_at)->format('d M Y'),
                    'rentan_waktu' => $q->nama_rentan_waktu,
                    'berkas' => asset('files/berkasRoadmap') . '/' . $q->berkas
                ];
            });
        // $data['prodi'] = $this->kaprodiId;
        // return $data;
        return DataTables::of($data)
            ->addIndexColumn()
            ->toJson();
    }

    public function show(string $id)
    {
        $id = Crypt::decryptString($id);
        $one = RoadMap::where('id_roadmap', $id)->first();
        if ($one) {
            $data['id_cript'] = Crypt::encrypt($one->id_roadmap);
            $data['jenis'] = $one->jenis;
            $data['rentan_waktu_id'] = $one->rentan_waktu_id;
            $data['status'] = $one->status;
            $data['komentar'] = $one->komentar;
            return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $data], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => $one], 400);
        }
    }

    public function store(Request $request)
    {
        $validateData = $this->permissionService->validateData($request->all(), [
            'rentan' => 'required',
            'jenis' => 'required',
            'file' => 'required|mimes:pdf|max:3072',
        ]);

        if ($validateData !== null) {
            return $validateData;
        }

        $file = $request->file('file');
        $file_name = 'FRP_' . $request->jenis . '_' . $request->rentan_nama . '.' .  $file->getClientOriginalExtension();

        DB::beginTransaction();
        try {
            $save['prodi_id'] = $this->kaprodiId;
            $save['rentan_waktu_id'] = $request->rentan;
            $save['jenis'] = $request->jenis;
            $save['nama_roadmap'] = 'R-' . $request->jenis . '-' . $request->rentan_nama . '-' . $this->dosenRole;
            $save['tanggal_upload'] = date("Y-m-d");
            $save['berkas'] = $file_name;
            $store = RoadMap::create($save);

            if ($store) {
                $file_folder = 'files/berkasRoadmap';
                $file->move($file_folder, $file_name);
            }

            DB::commit();
            return $this->permissionService->successResponse('data berhasil dibuat', $save);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Create roadmap prodi: ' . $th->getMessage());
            return $this->permissionService->errorResponse('data gagal dibuat');
        }
    }

    public function update(Request $request, string $id)
    {
        $id = Crypt::decryptString($id);
        $validateData = $this->permissionService->validateData($request->all(), [
            'edit_rentan' => 'required',
            'edit_jenis' => 'required',
            'edit_file' => $request->hasFile('edit_file') ? 'mimes:pdf|max:3072' : 'nullable',
        ]);

        if ($validateData !== null) {
            return $validateData;
        }

        $roadmap = RoadMap::where('id_roadmap', $id)->first();
        if (!$roadmap) {
            return $this->permissionService->errorResponse('Data tidak ditemukan');
        }

        $file = $request->file('edit_file');
        $file_name = $roadmap->berkas;

        DB::beginTransaction();
        try {
            // Update file if new file is uploaded
            if ($file) {
                $file_folder = 'files/berkasRoadmap';
                if (file_exists($file_folder . '/' . $file_name)) {
                    unlink($file_folder . '/' . $file_name);
                }
                $file_name = 'FRP_' . $request->edit_jenis . '_' . $request->rentan_nama . '.' .  $file->getClientOriginalExtension();
                $file->move($file_folder, $file_name);
            }

            $roadmap->update([
                'rentan_waktu_id' => $request->edit_rentan,
                'jenis' => $request->edit_jenis,
                'nama_roadmap' => 'R-' . $request->edit_jenis . '-' . $request->rentan_nama . '-' .  $this->dosenRole,
                'tanggal_upload' => date("Y-m-d"),
                'berkas' => $file_name,
            ]);

            DB::commit();
            return $this->permissionService->successResponse('Data berhasil diupdate', $roadmap);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Update roadmap dosen: ' . $th->getMessage());
            return $this->permissionService->errorResponse('Data gagal diupdate');
        }
    }

    public function review(Request $request, string $id)
    {
        $id = Crypt::decryptString($id);
        $validateData = $this->permissionService->validateData($request->all(), [
            'keputusan' => 'required',
            'komentar' => 'required'
        ]);

        if ($validateData !== null) {
            return $validateData;
        }

        $roadmap = RoadMap::where('id_roadmap', $id)->first();
        if (!$roadmap) {
            return $this->permissionService->errorResponse('Data tidak ditemukan');
        }

        DB::beginTransaction();
        try {
            $roadmap->update([
                'status' => $request->keputusan,
                'komentar' => $request->komentar,
            ]);
            DB::commit();
            return $this->permissionService->successResponse('Data berhasil diupdate', $roadmap);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Review roadmap dosen: ' . $th->getMessage());
            return $this->permissionService->errorResponse('Data gagal diupdate');
        }
    }
}
