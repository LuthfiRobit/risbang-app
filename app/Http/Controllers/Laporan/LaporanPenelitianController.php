<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Arsip;
use App\Models\PenulisDalam;
use App\Models\PenulisLain;
use App\Models\PenulisLuar;
use App\Services\DataActiveService;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class LaporanPenelitianController extends Controller
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
        return view('laporan.penelitian.index');
    }

    public function list()
    {
        $query = DB::table('arsip')
            ->select(
                'arsip.id_arsip',
                'arsip.judul',
                'arsip.publish',
                'arsip.created_by',
                'arsip.tahun_pelaksanaan',
                'tahun_akademik.nama_tahun_akademik',
                'dosen.nidn',
                'dosen.nama_dosen',
                'prodi.singkatan as prodi',
                'fakultas.singkatan as fakultas'
            )
            // ->leftJoin('proposal', 'proposal.id_proposal', '=', 'arsip.proposal_id')
            ->leftJoin('tahun_akademik', 'tahun_akademik.id_tahun_akademik', '=', 'arsip.tahun_akademik_id')
            ->leftJoin('dosen', 'dosen.id_dosen', '=', 'arsip.dosen_id')
            ->leftJoin('prodi', 'prodi.id_prodi', '=', 'dosen.prodi_id')
            ->leftJoin('fakultas', 'fakultas.id_fakultas', '=', 'prodi.fakultas_id')
            ->where('arsip.jenis', 'Penelitian')
            ->orderBy('arsip.created_at', 'DESC');

        // if auth dosen
        if ($this->userRole == 'dosen' && $this->dosenRole == 'dosen') {
            $query->where('arsip.dosen_id', $this->dosenId);
        }

        // if auth admin
        if ($this->userRole == 'admin') {
            // $proposalId = $this->dataActiveService->proposalPenelitian($taId, $request->id_owner);
        }

        // if auth kaprodi
        if ($this->userRole == 'dosen' && $this->dosenRole == 'kaprodi') {
            $query->where('dosen.prodi_id', $this->kaprodiId);
        }

        $result = $query->get()
            ->map(function ($q) {
                return [
                    'action' => Crypt::encryptString($q->id_arsip),
                    'penginput' => $q->created_by,
                    'ta' => $q->nama_tahun_akademik,
                    'tahun' => $q->tahun_pelaksanaan,
                    'penulis' => $q->nidn . ' | ' . $q->nama_dosen . ' | ' . $q->prodi . ' - ' . $q->fakultas,
                    'judul' => $q->judul,
                    'publish' => $q->publish === 'y' ? 'y' : 't'
                ];
            });

        return DataTables::of($result)
            ->addIndexColumn()
            ->toJson();
    }

    public function create()
    {
        $data['ta'] = DB::table('tahun_akademik')->select('id_tahun_akademik', 'nama_tahun_akademik')
            ->orderByDesc('created_at')
            ->get();
        return view('laporan.penelitian.create', $data);
    }

    public function store(Request $request)
    {
        $taId = $this->dataActiveService->tahunAkademik();

        // // if auth dosen
        // if ($this->userRole == 'dosen' && $this->dosenRole == 'dosen') {
        //     $proposalId = $this->dataActiveService->proposalPenelitian($taId, $this->dosenId);
        // }

        // // if auth admin
        // if ($this->userRole == 'admin') {
        //     $proposalId = $this->dataActiveService->proposalPenelitian($taId, $request->id_owner);
        // }

        // // if auth kaprodi
        // if ($this->userRole == 'dosen' && $this->dosenRole == 'kaprodi') {
        //     $proposalId = $this->dataActiveService->proposalPenelitian($taId, $request->id_owner);
        // }

        /** new */
        // Determine the proposalId based on user role
        // switch ($this->userRole) {
        //     case 'dosen':
        //         $proposalId = $this->dosenRole == 'dosen' ?
        //             $this->dataActiveService->proposalPenelitian($taId, $this->dosenId) :
        //             $this->dataActiveService->proposalPenelitian($taId, $request->id_owner);
        //         break;
        //     case 'admin':
        //         $proposalId = $this->dataActiveService->proposalPenelitian($taId, $request->id_owner);
        //         break;
        //     default:
        //         return $this->permissionService->errorResponse('Invalid user role');
        // }
        /** new */

        // $validateData = $this->permissionService->validateData($request->all(), [
        //     'judul' => 'required',
        //     'tahun' => 'required',
        //     'sumber' => 'required',
        //     'jumlah' => 'required',
        //     'file' => 'mimes:pdf|max:3072',
        //     'abstrak' => 'required',
        // ]);

        /** new */
        $validationRules = [
            'ta' => 'required',
            'judul' => 'required',
            'tahun' => 'required',
            'sumber' => 'required',
            'jumlah' => 'required',
            'file' => 'mimes:pdf|max:3072',
            'abstrak' => 'required',
        ];

        if ($this->userRole == 'admin' || ($this->userRole == 'dosen' && $this->dosenRole != 'dosen')) {
            $validationRules['id_owner'] = 'required';
        }

        $validateData = $this->permissionService->validateData($request->all(), $validationRules);
        /** new */

        if ($validateData !== null) {
            return $validateData;
        }

        $file = $request->file('file');
        $file_name = 'FA_' . uniqid() . '.' . $file->getClientOriginalExtension();

        DB::beginTransaction();
        try {
            // // if auth dosen
            // if ($this->userRole == 'dosen' && $this->dosenRole == 'dosen') {
            //     $save['dosen_id'] = $this->dosenId;
            // }
            // // if auth admin
            // if ($this->userRole == 'admin') {
            //     $save['dosen_id'] = $request->id_owner;
            // }
            // // if auth kaprodi
            // if ($this->userRole == 'dosen' && $this->dosenRole == 'kaprodi') {
            //     $save['dosen_id'] = $request->id_owner;
            // }
            $save['dosen_id'] = $this->userRole == 'admin' || ($this->userRole == 'dosen' && $this->dosenRole != 'dosen') ? $request->id_owner : $this->dosenId;
            // $save['proposal_id'] = $proposalId;
            // $save['tahun_akademik_id'] = $taId;
            $save['tahun_akademik_id'] = $request->ta;
            $save['jenis'] = 'Penelitian';
            $save['judul'] = $request->judul;
            $save['tahun_pelaksanaan'] = $request->tahun;
            $save['sumber_dana'] = $request->sumber;
            $save['jumlah_dana'] = $request->jumlah;
            $save['abstrak'] = $request->abstrak;
            $save['created_by'] = $this->userRole == 'admin' ? $this->userRole . '-' . Auth::user()->username : $this->dosenRole . '-' . Auth::user()->username;
            $save['file_arsip'] = $file_name;
            $save['publish'] = $request->has('publish') ? $request->publish : 't';
            $store = Arsip::create($save);

            if ($store) {
                $file_folder = 'files/arsip';
                $file->move($file_folder, $file_name);
            }

            // Save dosen dalam data
            foreach ($request->penulis_dosen_dalam as $key => $penulisDalam) {
                if ($penulisDalam) {
                    $dosenDalam = new PenulisDalam();
                    $dosenDalam->arsip_id = $store->id_arsip;
                    $dosenDalam->dosen_id = $penulisDalam;
                    $dosenDalam->peran_umum = $request->peran_dosen_dalam[$key];
                    // $dosenDalam->koresponden = isset($request->aktif_dosen_dalam[$key]) ? 1 : 0;
                    $dosenDalam->koresponden = $request->aktif_dosen_dalam[$key];
                    $dosenDalam->save();
                }
            }

            // Save dosen luar data
            if (is_array($request->penulis_dosen_luar)) {
                foreach ($request->penulis_dosen_luar as $key => $penulisLuar) {
                    if ($penulisLuar) {
                        $dosenLuar = new PenulisLuar();
                        $dosenLuar->arsip_id = $store->id_arsip;
                        $dosenLuar->dosen_luar_id = $penulisLuar;
                        $dosenLuar->peran_umum = $request->peran_dosen_luar[$key];
                        $dosenLuar->koresponden = $request->aktif_dosen_luar[$key];
                        $dosenLuar->save();
                    }
                }
            }

            // Save dosen lain data
            if (is_array($request->penulis_dosen_lain)) {
                foreach ($request->penulis_dosen_lain as $key => $penulisLain) {
                    if ($penulisLain) {
                        $dosenLain = new PenulisLain();
                        $dosenLain->arsip_id = $store->id_arsip;
                        $dosenLain->dosen_lain_id = $penulisLain;
                        $dosenLain->peran_umum = $request->peran_dosen_lain[$key];
                        $dosenLain->koresponden = $request->aktif_dosen_lain[$key];
                        $dosenLain->save();
                    }
                }
            }

            DB::commit();
            return $this->permissionService->successResponse('data berhasil dibuat', $save);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Create arsip penelitian: ' . $th->getMessage());
            return $this->permissionService->errorResponse('data gagal dibuat');
        }
    }

    public function show(string $id)
    {
        $id = Crypt::decryptString($id);
        $data = Arsip::select('id_arsip', 'dosen_id', 'tahun_akademik_id', 'judul', 'tahun_pelaksanaan', 'sumber_dana', 'jumlah_dana', 'abstrak', 'publish', 'file_arsip')
            ->with('penulisDalam', function ($q) {
                $q->select('id_penulis_dalam as id_penulis', 'arsip_id', 'dosen_id', 'dosen.nama_dosen as nama', 'peran_umum', 'koresponden')
                    ->leftJoin('dosen', 'dosen.id_dosen', 'penulis_dalam.dosen_id');
            })
            ->with('penulisLuar', function ($q) {
                $q->select('id_penulis_luar as id_penulis', 'arsip_id', 'dosen_luar_id as dosen_id', 'dosen_luar.nama', 'peran_umum', 'koresponden')
                    ->leftJoin('dosen_luar', 'dosen_luar.id_dosen_luar', 'penulis_luar.dosen_luar_id');
            })
            ->with('penulisLain', function ($q) {
                $q->select('id_penulis_lain as id_penulis', 'arsip_id', 'dosen_lain_id as dosen_id', 'dosen_lain.nama', 'peran_umum', 'koresponden')
                    ->leftJoin('dosen_lain', 'dosen_lain.id_dosen_lain', 'penulis_lain.dosen_lain_id');
            })
            ->where('id_arsip', $id)
            ->first();
        if ($data) {
            $data['id_cript'] = Crypt::encryptString($data->id_arsip);
            return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $data], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => $data], 400);
        }
    }

    public function edit(string $id)
    {
        $data['ta'] = DB::table('tahun_akademik')->select('id_tahun_akademik', 'nama_tahun_akademik')
            ->orderByDesc('created_at')
            ->get();
        return view('laporan.penelitian.edit', $data);
    }

    public function update(Request $request, string $id)
    {
        $id = Crypt::decryptString($id);
        // return $request->all();
        $validateData = $this->permissionService->validateData($request->all(), [
            'ta' => 'required',
            'judul' => 'required',
            'tahun' => 'required',
            'sumber' => 'required',
            'jumlah' => 'required',
            'abstrak' => 'required',
            'file' => $request->hasFile('file') ? 'mimes:pdf|max:3072' : 'nullable',
        ]);

        if ($validateData !== null) {
            return $validateData;
        }

        $arsip = Arsip::where('id_arsip', $id)->first();
        if (!$arsip) {
            return $this->permissionService->errorResponse('Data tidak ditemukan');
        }

        $file = $request->file('file');
        $file_name = $arsip->file_arsip;

        DB::beginTransaction();
        try {
            // Update file if new file is uploaded
            if ($file) {
                $file_folder = 'files/arsip';
                if (file_exists($file_folder . '/' . $file_name)) {
                    unlink($file_folder . '/' . $file_name);
                }
                $file_name = 'FA_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($file_folder, $file_name);
            }

            $arsip->update([
                'dosen_id' => $this->userRole == 'admin' || ($this->userRole == 'dosen' && $this->dosenRole != 'dosen') ? $request->id_owner : $arsip->dosen_id,
                'tahun_akademik_id' => $request->ta,
                'judul' => $request->judul,
                'tahun_pelaksanaan' => $request->tahun,
                'sumber_dana' => $request->sumber,
                'jumlah_dana' => $request->jumlah,
                'abstrak' => $request->abstrak,
                'file_arsip' => $file_name,
                'publish' => $request->has('publish') ? $request->publish : 't',
                'created_by' => $this->userRole == 'admin' ? $this->userRole . '-' . Auth::user()->username : $this->dosenRole . '-' . Auth::user()->username
            ]);

            // Update or insert penulis dalam
            $existingPenulisDalamIds = PenulisDalam::where('arsip_id', $arsip->id_arsip)->pluck('id_penulis_dalam')->toArray();
            foreach ($request->penulis_dosen_dalam as $key => $penulisDalam) {
                if (isset($request->id_penulis_dosen_dalam[$key]) && in_array($request->id_penulis_dosen_dalam[$key], $existingPenulisDalamIds)) {
                    // Update existing penulis
                    PenulisDalam::where('id_penulis_dalam', $request->id_penulis_dosen_dalam[$key])->update([
                        'dosen_id' => $penulisDalam,
                        'peran_umum' => $request->peran_dosen_dalam[$key],
                        'koresponden' => $request->aktif_dosen_dalam[$key]
                    ]);
                    // Remove from existing IDs list
                    if (($key = array_search($request->id_penulis_dosen_dalam[$key], $existingPenulisDalamIds)) !== false) {
                        unset($existingPenulisDalamIds[$key]);
                    }
                } else {
                    // Insert new penulis
                    PenulisDalam::create([
                        'arsip_id' => $arsip->id_arsip,
                        'dosen_id' => $penulisDalam,
                        'peran_umum' => $request->peran_dosen_dalam[$key],
                        'koresponden' => $request->aktif_dosen_dalam[$key]
                    ]);
                }
            }
            // Delete remaining old penulis
            PenulisDalam::whereIn('id_penulis_dalam', $existingPenulisDalamIds)->delete();

            // Update or insert penulis luar
            if (is_array($request->penulis_dosen_luar)) {
                $existingPenulisLuarIds = PenulisLuar::where('arsip_id', $arsip->id_arsip)->pluck('id_penulis_luar')->toArray();
                foreach ($request->penulis_dosen_luar as $key => $penulisLuar) {
                    if (isset($request->id_penulis_dosen_luar[$key]) && in_array($request->id_penulis_dosen_luar[$key], $existingPenulisLuarIds)) {
                        // Update existing penulis
                        PenulisLuar::where('id_penulis_luar', $request->id_penulis_dosen_luar[$key])->update([
                            'dosen_luar_id' => $penulisLuar,
                            'peran_umum' => $request->peran_dosen_luar[$key],
                            'koresponden' => $request->aktif_dosen_luar[$key]
                        ]);
                        // Remove from existing IDs list
                        if (($key = array_search($request->id_penulis_dosen_luar[$key], $existingPenulisLuarIds)) !== false) {
                            unset($existingPenulisLuarIds[$key]);
                        }
                    } else {
                        // Insert new penulis
                        PenulisLuar::create([
                            'arsip_id' => $arsip->id_arsip,
                            'dosen_luar_id' => $penulisLuar,
                            'peran_umum' => $request->peran_dosen_luar[$key],
                            'koresponden' => $request->aktif_dosen_luar[$key]
                        ]);
                    }
                }
                // Delete remaining old penulis
                PenulisLuar::whereIn('id_penulis_luar', $existingPenulisLuarIds)->delete();
            }

            // Update or insert penulis lain
            if (is_array($request->penulis_dosen_lain)) {
                $existingPenulisLainIds = PenulisLain::where('arsip_id', $arsip->id_arsip)->pluck('id_penulis_lain')->toArray();
                foreach ($request->penulis_dosen_lain as $key => $penulisLain) {
                    if (isset($request->id_penulis_dosen_lain[$key]) && in_array($request->id_penulis_dosen_lain[$key], $existingPenulisLainIds)) {
                        // Update existing penulis
                        PenulisLain::where('id_penulis_lain', $request->id_penulis_dosen_lain[$key])->update([
                            'dosen_lain_id' => $penulisLain,
                            'peran_umum' => $request->peran_dosen_lain[$key],
                            'koresponden' => $request->aktif_dosen_lain[$key]
                        ]);
                        // Remove from existing IDs list
                        if (($key = array_search($request->id_penulis_dosen_lain[$key], $existingPenulisLainIds)) !== false) {
                            unset($existingPenulisLainIds[$key]);
                        }
                    } else {
                        // Insert new penulis
                        PenulisLain::create([
                            'arsip_id' => $arsip->id_arsip,
                            'dosen_lain_id' => $penulisLain,
                            'peran_umum' => $request->peran_dosen_lain[$key],
                            'koresponden' => $request->aktif_dosen_lain[$key]
                        ]);
                    }
                }
                // Delete remaining old penulis
                PenulisLain::whereIn('id_penulis_lain', $existingPenulisLainIds)->delete();
            }

            DB::commit();
            return $this->permissionService->successResponse('Data berhasil diupdate', $arsip);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Update arsip penelitian: ' . $th->getMessage());
            return $this->permissionService->errorResponse('Data gagal diupdate');
        }
    }

    public function listArsipPene(Request $request)
    {
        $query = DB::table('arsip')
            ->select(
                'arsip.id_arsip',
                'arsip.judul',
                'dosen.id_dosen',
                'dosen.nidn',
                'dosen.nama_dosen',
                'prodi.singkatan as prodi',
                'fakultas.singkatan as fakultas'
            )
            ->leftJoin('dosen', 'dosen.id_dosen', '=', 'arsip.dosen_id')
            ->leftJoin('prodi', 'prodi.id_prodi', '=', 'dosen.prodi_id')
            ->leftJoin('fakultas', 'fakultas.id_fakultas', '=', 'prodi.fakultas_id')
            ->where('arsip.jenis', 'Penelitian')
            ->orderBy('arsip.created_at', 'DESC');

        // if auth dosen
        if ($this->userRole == 'dosen' && $this->dosenRole == 'dosen') {
            $query->where('arsip.dosen_id', $this->dosenId);
        }

        // if auth admin
        if ($this->userRole == 'admin') {
            // $proposalId = $this->dataActiveService->proposalPenelitian($taId, $request->id_owner);
        }

        // if auth kaprodi
        if ($this->userRole == 'dosen' && $this->dosenRole == 'kaprodi') {
            $query->where('dosen.prodi_id', $this->kaprodiId);
        }

        $result = $query->get()
            ->map(function ($q) {
                return [
                    'id' => $q->id_arsip,
                    'id_arsip' => Crypt::encryptString($q->id_arsip),
                    'id_dosen' => Crypt::encryptString($q->id_dosen),
                    'nidn' => $q->nidn,
                    'penulis' => $q->nidn . ' | ' . $q->nama_dosen . ' | ' . $q->prodi . ' - ' . $q->fakultas,
                    'judul' => $q->judul,
                ];
            });

        return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $result], 200);
    }
}
