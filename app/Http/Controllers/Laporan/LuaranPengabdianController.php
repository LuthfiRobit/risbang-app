<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\ArsipBuku;
use App\Models\ArsipHaki;
use App\Models\ArsipJurnal;
use App\Models\ArsipProduk;
use App\Models\ArsipPrototype;
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

class LuaranPengabdianController extends Controller
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

    /** begin:function for jurnal */

    public function indexJurnal()
    {
        return view('laporan.luaranJurnal.pengabdian.index');
    }

    public function createJurnal()
    {
        $data['ta'] = DB::table('tahun_akademik')->select('id_tahun_akademik', 'nama_tahun_akademik')
            ->orderByDesc('created_at')
            ->get();
        return view('laporan.luaranJurnal.pengabdian.create', $data);
    }

    public function editJurnal(string $id)
    {
        $id = Crypt::decryptString($id);
        $data = ArsipJurnal::where('id_arsip_jurnal', $id)->first();
        if ($data) {
            $data['ta'] = DB::table('tahun_akademik')->select('id_tahun_akademik', 'nama_tahun_akademik')
                ->orderByDesc('created_at')
                ->get();
            return view('laporan.luaranJurnal.pengabdian.edit', $data);
        } else {
            return redirect()->back()->with('fail', 'Data tidak ditemukan.');
        }
    }

    public function listJurnal()
    {
        $query = ArsipJurnal::select(
            'arsip_jurnal.id_arsip_jurnal',
            'arsip_jurnal.judul',
            'arsip_jurnal.created_by',
            'arsip_jurnal.publish',
            'arsip_jurnal.tahun_pelaksanaan',
            'tahun_akademik.nama_tahun_akademik',
            'dosen.nidn',
            'dosen.nama_dosen',
            'prodi.singkatan as prodi',
            'fakultas.singkatan as fakultas'
        )
            ->leftJoin('tahun_akademik', 'tahun_akademik.id_tahun_akademik', '=', 'arsip_jurnal.tahun_akademik_id')
            ->leftJoin('dosen', 'dosen.id_dosen', '=', 'arsip_jurnal.dosen_id')
            ->leftJoin('prodi', 'prodi.id_prodi', '=', 'dosen.prodi_id')
            ->leftJoin('fakultas', 'fakultas.id_fakultas', '=', 'prodi.fakultas_id')
            ->where('arsip_jurnal.jenis', 'Pengabdian')
            ->orderBy('arsip_jurnal.created_at', 'DESC');

        // if auth dosen
        if ($this->userRole == 'dosen' && $this->dosenRole == 'dosen') {
            $query->where('arsip_jurnal.dosen_id', $this->dosenId);
        }

        // if auth admin
        if ($this->userRole == 'admin') {
            // $proposalId = $this->dataActiveService->proposalPengabdian($taId, $request->id_owner);
        }

        // if auth kaprodi
        if ($this->userRole == 'dosen' && $this->dosenRole == 'kaprodi') {
            $query->where('dosen.prodi_id', $this->kaprodiId);
        }

        $result = $query->get()
            ->map(function ($q) {
                return [
                    'action' => Crypt::encryptString($q->id_arsip_jurnal),
                    'penginput' => $q->created_by,
                    'tahun' => $q->tahun_pelaksanaan,
                    'ta' => $q->nama_tahun_akademik,
                    'penulis' => $q->nidn . ' | ' . $q->nama_dosen . ' | ' . $q->prodi . ' - ' . $q->fakultas,
                    'judul' => $q->judul,
                    'publish' => $q->publish === 'y' ? 'y' : 't'
                ];
            });

        return DataTables::of($result)
            ->addIndexColumn()
            ->toJson();
    }

    public function storeJurnal(Request $request)
    {
        /** new */
        $validationRules = [
            'ta' => 'required',
            'judul' => 'required',
            'penerbit' => 'required',
            'kategori' => 'required',
            'peringkat' => 'required',
            'halaman' => 'required',
            'volume' => 'required',
            'nomor' => 'required',
            'issn' => 'required',
            'tahun' => 'required',
            'url' => 'url|required',
            'file' => 'mimes:pdf|max:3072',
            'abstrak' => 'required'
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
        $file_name = 'FAJ_' . uniqid() . '.' . $file->getClientOriginalExtension();

        DB::beginTransaction();
        try {
            $save['dosen_id'] = $this->userRole == 'admin' || ($this->userRole == 'dosen' && $this->dosenRole != 'dosen') ? $request->id_owner : $this->dosenId;
            $save['tahun_akademik_id'] = $request->ta;
            $save['jenis'] = 'Pengabdian';
            $save['judul'] = $request->judul;
            $save['penerbit'] = $request->penerbit;
            $save['kategori_publikasi'] = $request->kategori;
            $save['peringkat'] = $request->peringkat;
            $save['halaman'] = $request->halaman;
            $save['issn'] = $request->issn;
            $save['tahun_pelaksanaan'] = $request->tahun;
            $save['volume'] = $request->volume;
            $save['nomor'] = $request->nomor;
            $save['link'] = $request->url;
            $save['abstrak'] = $request->abstrak;
            $save['created_by'] = $this->userRole == 'admin' ? $this->userRole . '-' . Auth::user()->username : $this->dosenRole . '-' . Auth::user()->username;
            $save['file_arsip_jurnal'] = $file_name;
            $save['publish'] = $request->has('publish') ? $request->publish : 't';
            $store = ArsipJurnal::create($save);

            if ($store) {
                $file_folder = 'files/arsipJurnal';
                $file->move($file_folder, $file_name);
            }

            // Save dosen dalam data
            foreach ($request->penulis_dosen_dalam as $key => $penulisDalam) {
                if ($penulisDalam) {
                    $dosenDalam = new PenulisDalam();
                    $dosenDalam->arsip_jurnal_id = $store->id_arsip_jurnal;
                    $dosenDalam->dosen_id = $penulisDalam;
                    $dosenDalam->peran_khusus = $request->peran_dosen_dalam[$key];
                    $dosenDalam->koresponden = $request->aktif_dosen_dalam[$key];
                    $dosenDalam->afiliasi = $request->afiliasi_dosen_dalam[$key];
                    $dosenDalam->save();
                }
            }

            // Save dosen luar data
            if (is_array($request->penulis_dosen_luar)) {
                foreach ($request->penulis_dosen_luar as $key => $penulisLuar) {
                    if ($penulisLuar) {
                        $dosenLuar = new PenulisLuar();
                        $dosenLuar->arsip_jurnal_id = $store->id_arsip_jurnal;
                        $dosenLuar->dosen_luar_id = $penulisLuar;
                        $dosenLuar->peran_khusus = $request->peran_dosen_luar[$key];
                        $dosenLuar->koresponden = $request->aktif_dosen_luar[$key];
                        $dosenLuar->afiliasi = $request->afiliasi_dosen_luar[$key];
                        $dosenLuar->save();
                    }
                }
            }

            // Save dosen lain data
            if (is_array($request->penulis_dosen_lain)) {
                foreach ($request->penulis_dosen_lain as $key => $penulisLain) {
                    if ($penulisLain) {
                        $dosenLain = new PenulisLain();
                        $dosenLain->arsip_jurnal_id = $store->id_arsip_jurnal;
                        $dosenLain->dosen_lain_id = $penulisLain;
                        $dosenLain->peran_khusus = $request->peran_dosen_lain[$key];
                        $dosenLain->koresponden = $request->aktif_dosen_lain[$key];
                        $dosenLain->afiliasi = $request->afiliasi_dosen_lain[$key];
                        $dosenLain->save();
                    }
                }
            }

            DB::commit();
            return $this->permissionService->successResponse('data berhasil dibuat', $save);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Create arsip jurnal pengabdian: ' . $th->getMessage());
            return $this->permissionService->errorResponse('data gagal dibuat');
        }
    }

    public function showJurnal(string $id)
    {
        $id = Crypt::decryptString($id);
        $data = ArsipJurnal::select(
            'id_arsip_jurnal',
            'dosen_id',
            'tahun_akademik_id',
            'judul',
            'penerbit',
            'kategori_publikasi',
            'peringkat',
            'halaman',
            'issn',
            'tahun_pelaksanaan',
            'volume',
            'nomor',
            'link',
            'abstrak',
            'publish',
            'file_arsip_jurnal',
        )
            ->with('penulisDalam', function ($q) {
                $q->select('id_penulis_dalam as id_penulis', 'arsip_jurnal_id', 'dosen_id', 'dosen.nama_dosen as nama', 'peran_khusus', 'koresponden', 'afiliasi')
                    ->leftJoin('dosen', 'dosen.id_dosen', 'penulis_dalam.dosen_id');
            })
            ->with('penulisLuar', function ($q) {
                $q->select('id_penulis_luar as id_penulis', 'arsip_jurnal_id', 'dosen_luar_id as dosen_id', 'dosen_luar.nama', 'peran_khusus', 'koresponden', 'afiliasi')
                    ->leftJoin('dosen_luar', 'dosen_luar.id_dosen_luar', 'penulis_luar.dosen_luar_id');
            })
            ->with('penulisLain', function ($q) {
                $q->select('id_penulis_lain as id_penulis', 'arsip_jurnal_id', 'dosen_lain_id as dosen_id', 'dosen_lain.nama', 'peran_khusus', 'koresponden', 'afiliasi')
                    ->leftJoin('dosen_lain', 'dosen_lain.id_dosen_lain', 'penulis_lain.dosen_lain_id');
            })
            ->where('id_arsip_jurnal', $id)
            ->first();
        if ($data) {
            $data['id_cript'] = Crypt::encryptString($data->id_arsip_jurnal);
            return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $data], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => $data], 400);
        }
    }

    public function updateJurnal(Request $request, string $id)
    {
        $id = Crypt::decryptString($id);

        /** new */
        $validationRules = [
            'ta' => 'required',
            'judul' => 'required',
            'penerbit' => 'required',
            'kategori' => 'required',
            'peringkat' => 'required',
            'halaman' => 'required',
            'volume' => 'required',
            'nomor' => 'required',
            'issn' => 'required',
            'tahun' => 'required',
            'url' => 'url|required',
            'abstrak' => 'required',
            'file' => $request->hasFile('file') ? 'mimes:pdf|max:3072' : 'nullable',
        ];

        if ($this->userRole == 'admin' || ($this->userRole == 'dosen' && $this->dosenRole != 'dosen')) {
            $validationRules['id_owner'] = 'required';
        }

        $validateData = $this->permissionService->validateData($request->all(), $validationRules);
        /** new */

        if ($validateData !== null) {
            return $validateData;
        }

        $arsip = ArsipJurnal::where('id_arsip_jurnal', $id)->first();
        if (!$arsip) {
            return $this->permissionService->errorResponse('Data tidak ditemukan');
        }

        $file = $request->file('file');
        $file_name = $arsip->file_arsip_jurnal;

        DB::beginTransaction();
        try {
            // Update file if new file is uploaded
            if ($file) {
                $file_folder = 'files/arsipJurnal';
                if (!empty($file_name) && file_exists($file_folder . '/' . $file_name)) {
                    unlink($file_folder . '/' . $file_name);
                }
                $file_name = 'FAJ_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($file_folder, $file_name);
            }

            $arsip->update([
                'dosen_id' => $this->userRole == 'admin' || ($this->userRole == 'dosen' && $this->dosenRole != 'dosen') ? $request->id_owner : $arsip->dosen_id,
                'tahun_akademik_id' => $request->ta,
                'judul' => $request->judul,
                'penerbit' => $request->penerbit,
                'kategori_publikasi' => $request->kategori,
                'peringkat' => $request->peringkat,
                'halaman' => $request->halaman,
                'issn' => $request->issn,
                'tahun_pelaksanaan' => $request->tahun,
                'volume' => $request->volume,
                'nomor' => $request->nomor,
                'link' => $request->url,
                'abstrak' => $request->abstrak,
                'file_arsip_jurnal' => $file_name,
                'publish' => $request->has('publish') ? $request->publish : 't',
                'created_by' => $this->userRole == 'admin' ? $this->userRole . '-' . Auth::user()->username : $this->dosenRole . '-' . Auth::user()->username,
            ]);

            // Update or insert penulis dalam
            $existingPenulisDalamIds = PenulisDalam::where('arsip_jurnal_id', $arsip->id_arsip_jurnal)->pluck('id_penulis_dalam')->toArray();
            foreach ($request->penulis_dosen_dalam as $key => $penulisDalam) {
                if (isset($request->id_penulis_dosen_dalam[$key]) && in_array($request->id_penulis_dosen_dalam[$key], $existingPenulisDalamIds)) {
                    // Update existing penulis
                    PenulisDalam::where('id_penulis_dalam', $request->id_penulis_dosen_dalam[$key])->update([
                        'dosen_id' => $penulisDalam,
                        'peran_khusus' => $request->peran_dosen_dalam[$key],
                        'koresponden' => $request->aktif_dosen_dalam[$key],
                        'afiliasi' => $request->afiliasi_dosen_dalam[$key]
                    ]);
                    // Remove from existing IDs list
                    if (($key = array_search($request->id_penulis_dosen_dalam[$key], $existingPenulisDalamIds)) !== false) {
                        unset($existingPenulisDalamIds[$key]);
                    }
                } else {
                    // Insert new penulis
                    PenulisDalam::create([
                        'arsip_jurnal_id' => $arsip->id_arsip_jurnal,
                        'dosen_id' => $penulisDalam,
                        'peran_khusus' => $request->peran_dosen_dalam[$key],
                        'koresponden' => $request->aktif_dosen_dalam[$key],
                        'afiliasi' => $request->afiliasi_dosen_dalam[$key]
                    ]);
                }
            }
            // Delete remaining old penulis
            PenulisDalam::whereIn('id_penulis_dalam', $existingPenulisDalamIds)->delete();

            // Update or insert penulis luar
            if (is_array($request->penulis_dosen_luar)) {
                $existingPenulisLuarIds = PenulisLuar::where('arsip_jurnal_id', $arsip->id_arsip_jurnal)->pluck('id_penulis_luar')->toArray();
                foreach ($request->penulis_dosen_luar as $key => $penulisLuar) {
                    if (isset($request->id_penulis_dosen_luar[$key]) && in_array($request->id_penulis_dosen_luar[$key], $existingPenulisLuarIds)) {
                        // Update existing penulis
                        PenulisLuar::where('id_penulis_luar', $request->id_penulis_dosen_luar[$key])->update([
                            'dosen_luar_id' => $penulisLuar,
                            'peran_khusus' => $request->peran_dosen_luar[$key],
                            'koresponden' => $request->aktif_dosen_luar[$key],
                            'afiliasi' => $request->afiliasi_dosen_luar[$key]
                        ]);
                        // Remove from existing IDs list
                        if (($key = array_search($request->id_penulis_dosen_luar[$key], $existingPenulisLuarIds)) !== false) {
                            unset($existingPenulisLuarIds[$key]);
                        }
                    } else {
                        // Insert new penulis
                        PenulisLuar::create([
                            'arsip_jurnal_id' => $arsip->id_arsip_jurnal,
                            'dosen_luar_id' => $penulisLuar,
                            'peran_khusus' => $request->peran_dosen_luar[$key],
                            'koresponden' => $request->aktif_dosen_luar[$key],
                            'afiliasi' => $request->afiliasi_dosen_luar[$key]
                        ]);
                    }
                }
                // Delete remaining old penulis
                PenulisLuar::whereIn('id_penulis_luar', $existingPenulisLuarIds)->delete();
            }

            // Update or insert penulis lain
            if (is_array($request->penulis_dosen_lain)) {
                $existingPenulisLainIds = PenulisLain::where('arsip_jurnal_id', $arsip->id_arsip_jurnal)->pluck('id_penulis_lain')->toArray();
                foreach ($request->penulis_dosen_lain as $key => $penulisLain) {
                    if (isset($request->id_penulis_dosen_lain[$key]) && in_array($request->id_penulis_dosen_lain[$key], $existingPenulisLainIds)) {
                        // Update existing penulis
                        PenulisLain::where('id_penulis_lain', $request->id_penulis_dosen_lain[$key])->update([
                            'dosen_lain_id' => $penulisLain,
                            'peran_khusus' => $request->peran_dosen_lain[$key],
                            'koresponden' => $request->aktif_dosen_lain[$key],
                            'afiliasi' => $request->afiliasi_dosen_lain[$key]
                        ]);
                        // Remove from existing IDs list
                        if (($key = array_search($request->id_penulis_dosen_lain[$key], $existingPenulisLainIds)) !== false) {
                            unset($existingPenulisLainIds[$key]);
                        }
                    } else {
                        // Insert new penulis
                        PenulisLain::create([
                            'arsip_jurnal_id' => $arsip->id_arsip_jurnal,
                            'dosen_lain_id' => $penulisLain,
                            'peran_khusus' => $request->peran_dosen_lain[$key],
                            'koresponden' => $request->aktif_dosen_lain[$key],
                            'afiliasi' => $request->afiliasi_dosen_lain[$key]
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
            Log::error('Update arsip jurnal pengabdian: ' . $th->getMessage());
            return $this->permissionService->errorResponse('Data gagal diupdate');
        }
    }

    /** end:function for jurnal */

    /** begin:function for haki */

    public function indexHaki()
    {
        return view('laporan.luaranHaki.pengabdian.index');
    }

    public function createHaki()
    {
        $data['ta'] = DB::table('tahun_akademik')->select('id_tahun_akademik', 'nama_tahun_akademik')
            ->orderByDesc('created_at')
            ->get();
        return view('laporan.luaranHaki.pengabdian.create', $data);
    }

    public function editHaki(string $id)
    {
        $id = Crypt::decryptString($id);
        $data = ArsipHaki::where('id_arsip_haki', $id)->first();
        if ($data) {
            $data['ta'] = DB::table('tahun_akademik')->select('id_tahun_akademik', 'nama_tahun_akademik')
                ->orderByDesc('created_at')
                ->get();
            return view('laporan.luaranHaki.pengabdian.edit', $data);
        } else {
            return redirect()->back()->with('fail', 'Data tidak ditemukan.');
        }
    }

    public function listHaki()
    {
        $query = ArsipHaki::select(
            'arsip_haki.id_arsip_haki',
            'arsip_haki.judul',
            'arsip_haki.created_by',
            'arsip_haki.publish',
            'arsip_haki.tahun_pelaksanaan',
            'tahun_akademik.nama_tahun_akademik',
            'dosen.nidn',
            'dosen.nama_dosen',
            'prodi.singkatan as prodi',
            'fakultas.singkatan as fakultas'
        )
            ->leftJoin('tahun_akademik', 'tahun_akademik.id_tahun_akademik', '=', 'arsip_haki.tahun_akademik_id')
            ->leftJoin('dosen', 'dosen.id_dosen', '=', 'arsip_haki.dosen_id')
            ->leftJoin('prodi', 'prodi.id_prodi', '=', 'dosen.prodi_id')
            ->leftJoin('fakultas', 'fakultas.id_fakultas', '=', 'prodi.fakultas_id')
            ->where('arsip_haki.jenis', 'Pengabdian')
            ->orderBy('arsip_haki.created_at', 'DESC');

        // if auth dosen
        if ($this->userRole == 'dosen' && $this->dosenRole == 'dosen') {
            $query->where('arsip_haki.dosen_id', $this->dosenId);
        }

        // if auth admin
        if ($this->userRole == 'admin') {
            // $proposalId = $this->dataActiveService->proposalPengabdian($taId, $request->id_owner);
        }

        // if auth kaprodi
        if ($this->userRole == 'dosen' && $this->dosenRole == 'kaprodi') {
            $query->where('dosen.prodi_id', $this->kaprodiId);
        }

        $result = $query->get()
            ->map(function ($q) {
                return [
                    'action' => Crypt::encryptString($q->id_arsip_haki),
                    'penginput' => $q->created_by,
                    'tahun' => $q->tahun_pelaksanaan,
                    'ta' => $q->nama_tahun_akademik,
                    'penulis' => $q->nidn . ' | ' . $q->nama_dosen . ' | ' . $q->prodi . ' - ' . $q->fakultas,
                    'judul' => $q->judul,
                    'publish' => $q->publish === 'y' ? 'y' : 't'
                ];
            });

        return DataTables::of($result)
            ->addIndexColumn()
            ->toJson();
    }

    public function storeHaki(Request $request)
    {
        /** new */
        $validationRules = [
            'ta' => 'required',
            'judul' => 'required',
            'kategori' => 'required',
            'jenis' => 'required',
            'pemegang' => 'required',
            'nomor' => 'required',
            'tahun' => 'required',
            'url' => 'url|required',
            'file' => 'mimes:pdf|max:3072',
            'deskripsi' => 'required'
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
        $file_name = 'FAH_' . uniqid() . '.' . $file->getClientOriginalExtension();

        DB::beginTransaction();
        try {
            $save['dosen_id'] = $this->userRole == 'admin' || ($this->userRole == 'dosen' && $this->dosenRole != 'dosen') ? $request->id_owner : $this->dosenId;
            $save['tahun_akademik_id'] = $request->ta;
            $save['jenis'] = 'Pengabdian';
            $save['judul'] = $request->judul;
            $save['kategori_haki'] = $request->kategori;
            $save['jenis_haki'] = $request->jenis;
            $save['pemegang'] = $request->pemegang;
            $save['nomor'] = $request->nomor;
            $save['tahun_pelaksanaan'] = $request->tahun;
            $save['link'] = $request->url;
            $save['deskripsi'] = $request->deskripsi;
            $save['file_arsip_haki'] = $file_name;
            $save['created_by'] = $this->userRole == 'admin' ? $this->userRole . '-' . Auth::user()->username : $this->dosenRole . '-' . Auth::user()->username;
            $save['publish'] = $request->has('publish') ? $request->publish : 't';
            $store = ArsipHaki::create($save);

            if ($store) {
                $file_folder = 'files/arsipHaki';
                $file->move($file_folder, $file_name);
            }

            // Save dosen dalam data
            foreach ($request->penulis_dosen_dalam as $key => $penulisDalam) {
                if ($penulisDalam) {
                    $dosenDalam = new PenulisDalam();
                    $dosenDalam->arsip_haki_id = $store->id_arsip_haki;
                    $dosenDalam->dosen_id = $penulisDalam;
                    $dosenDalam->peran_khusus = $request->peran_dosen_dalam[$key];
                    $dosenDalam->koresponden = $request->aktif_dosen_dalam[$key];
                    $dosenDalam->afiliasi = $request->afiliasi_dosen_dalam[$key];
                    $dosenDalam->save();
                }
            }

            // Save dosen luar data
            if (is_array($request->penulis_dosen_luar)) {
                foreach ($request->penulis_dosen_luar as $key => $penulisLuar) {
                    if ($penulisLuar) {
                        $dosenLuar = new PenulisLuar();
                        $dosenLuar->arsip_haki_id = $store->id_arsip_haki;
                        $dosenLuar->dosen_luar_id = $penulisLuar;
                        $dosenLuar->peran_khusus = $request->peran_dosen_luar[$key];
                        $dosenLuar->koresponden = $request->aktif_dosen_luar[$key];
                        $dosenLuar->afiliasi = $request->afiliasi_dosen_luar[$key];
                        $dosenLuar->save();
                    }
                }
            }

            // Save dosen lain data
            if (is_array($request->penulis_dosen_lain)) {
                foreach ($request->penulis_dosen_lain as $key => $penulisLain) {
                    if ($penulisLain) {
                        $dosenLain = new PenulisLain();
                        $dosenLain->arsip_haki_id = $store->id_arsip_haki;
                        $dosenLain->dosen_lain_id = $penulisLain;
                        $dosenLain->peran_khusus = $request->peran_dosen_lain[$key];
                        $dosenLain->koresponden = $request->aktif_dosen_lain[$key];
                        $dosenLain->afiliasi = $request->afiliasi_dosen_lain[$key];
                        $dosenLain->save();
                    }
                }
            }

            DB::commit();
            return $this->permissionService->successResponse('data berhasil dibuat', $save);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Create arsip haki pengabdian: ' . $th->getMessage());
            return $this->permissionService->errorResponse('data gagal dibuat');
        }
    }

    public function showHaki(string $id)
    {
        $id = Crypt::decryptString($id);
        $data = ArsipHaki::select(
            'id_arsip_haki',
            'dosen_id',
            'tahun_akademik_id',
            'publish',
            'judul',
            'kategori_haki',
            'jenis_haki',
            'tahun_pelaksanaan',
            'pemegang',
            'nomor',
            'link',
            'deskripsi',
            'file_arsip_haki',
        )
            ->with('penulisDalam', function ($q) {
                $q->select('id_penulis_dalam as id_penulis', 'arsip_haki_id', 'dosen_id', 'dosen.nama_dosen as nama', 'peran_khusus', 'koresponden', 'afiliasi')
                    ->leftJoin('dosen', 'dosen.id_dosen', 'penulis_dalam.dosen_id');
            })
            ->with('penulisLuar', function ($q) {
                $q->select('id_penulis_luar as id_penulis', 'arsip_haki_id', 'dosen_luar_id as dosen_id', 'dosen_luar.nama', 'peran_khusus', 'koresponden', 'afiliasi')
                    ->leftJoin('dosen_luar', 'dosen_luar.id_dosen_luar', 'penulis_luar.dosen_luar_id');
            })
            ->with('penulisLain', function ($q) {
                $q->select('id_penulis_lain as id_penulis', 'arsip_haki_id', 'dosen_lain_id as dosen_id', 'dosen_lain.nama', 'peran_khusus', 'koresponden', 'afiliasi')
                    ->leftJoin('dosen_lain', 'dosen_lain.id_dosen_lain', 'penulis_lain.dosen_lain_id');
            })
            ->where('id_arsip_haki', $id)
            ->first();
        if ($data) {
            $data['id_cript'] = Crypt::encryptString($data->id_arsip_haki);
            return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $data], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => $data], 400);
        }
    }

    public function updateHaki(Request $request, string $id)
    {
        $id = Crypt::decryptString($id);
        /** new */
        $validationRules = [
            'ta' => 'required',
            'judul' => 'required',
            'kategori' => 'required',
            'jenis' => 'required',
            'pemegang' => 'required',
            'nomor' => 'required',
            'tahun' => 'required',
            'url' => 'url|required',
            'deskripsi' => 'required',
            'file' => $request->hasFile('file') ? 'mimes:pdf|max:3072' : 'nullable',
        ];

        if ($this->userRole == 'admin' || ($this->userRole == 'dosen' && $this->dosenRole != 'dosen')) {
            $validationRules['id_owner'] = 'required';
        }

        $validateData = $this->permissionService->validateData($request->all(), $validationRules);
        /** new */

        if ($validateData !== null) {
            return $validateData;
        }

        $arsip = ArsipHaki::where('id_arsip_haki', $id)->first();
        if (!$arsip) {
            return $this->permissionService->errorResponse('Data tidak ditemukan');
        }

        $file = $request->file('file');
        $file_name = $arsip->file_arsip_haki;

        DB::beginTransaction();
        try {
            // Update file if new file is uploaded
            if ($file) {
                $file_folder = 'files/arsipHaki';
                // Hanya mencoba menghapus file jika $file_name tidak kosong atau null
                if (!empty($file_name) && file_exists($file_folder . '/' . $file_name)) {
                    unlink($file_folder . '/' . $file_name);
                }
                $file_name = 'FAH_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($file_folder, $file_name);
            }

            $arsip->update([
                'dosen_id' => $this->userRole == 'admin' || ($this->userRole == 'dosen' && $this->dosenRole != 'dosen') ? $request->id_owner : $arsip->dosen_id,
                'tahun_akademik_id' => $request->ta,
                'judul' => $request->judul,
                'kategori_haki' => $request->kategori,
                'jenis_haki' => $request->jenis,
                'pemegang' => $request->pemegang,
                'nomor' => $request->nomor,
                'tahun_pelaksanaan' => $request->tahun,
                'link' => $request->url,
                'deskripsi' => $request->deskripsi,
                'file_arsip_haki' => $file_name,
                'publish' => $request->has('publish') ? $request->publish : 't',
                'created_by' => $this->userRole == 'admin' ? $this->userRole . '-' . Auth::user()->username : $this->dosenRole . '-' . Auth::user()->username,
            ]);

            // Update or insert penulis dalam
            $existingPenulisDalamIds = PenulisDalam::where('arsip_haki_id', $arsip->id_arsip_haki)->pluck('id_penulis_dalam')->toArray();
            foreach ($request->penulis_dosen_dalam as $key => $penulisDalam) {
                if (isset($request->id_penulis_dosen_dalam[$key]) && in_array($request->id_penulis_dosen_dalam[$key], $existingPenulisDalamIds)) {
                    // Update existing penulis
                    PenulisDalam::where('id_penulis_dalam', $request->id_penulis_dosen_dalam[$key])->update([
                        'dosen_id' => $penulisDalam,
                        'peran_khusus' => $request->peran_dosen_dalam[$key],
                        'koresponden' => $request->aktif_dosen_dalam[$key],
                        'afiliasi' => $request->afiliasi_dosen_dalam[$key]
                    ]);
                    // Remove from existing IDs list
                    if (($key = array_search($request->id_penulis_dosen_dalam[$key], $existingPenulisDalamIds)) !== false) {
                        unset($existingPenulisDalamIds[$key]);
                    }
                } else {
                    // Insert new penulis
                    PenulisDalam::create([
                        'arsip_haki_id' => $arsip->id_arsip_haki,
                        'dosen_id' => $penulisDalam,
                        'peran_khusus' => $request->peran_dosen_dalam[$key],
                        'koresponden' => $request->aktif_dosen_dalam[$key],
                        'afiliasi' => $request->afiliasi_dosen_dalam[$key]
                    ]);
                }
            }
            // Delete remaining old penulis
            PenulisDalam::whereIn('id_penulis_dalam', $existingPenulisDalamIds)->delete();

            // Update or insert penulis luar
            if (is_array($request->penulis_dosen_luar)) {
                $existingPenulisLuarIds = PenulisLuar::where('arsip_haki_id', $arsip->id_arsip_haki)->pluck('id_penulis_luar')->toArray();
                foreach ($request->penulis_dosen_luar as $key => $penulisLuar) {
                    if (isset($request->id_penulis_dosen_luar[$key]) && in_array($request->id_penulis_dosen_luar[$key], $existingPenulisLuarIds)) {
                        // Update existing penulis
                        PenulisLuar::where('id_penulis_luar', $request->id_penulis_dosen_luar[$key])->update([
                            'dosen_luar_id' => $penulisLuar,
                            'peran_khusus' => $request->peran_dosen_luar[$key],
                            'koresponden' => $request->aktif_dosen_luar[$key],
                            'afiliasi' => $request->afiliasi_dosen_luar[$key]
                        ]);
                        // Remove from existing IDs list
                        if (($key = array_search($request->id_penulis_dosen_luar[$key], $existingPenulisLuarIds)) !== false) {
                            unset($existingPenulisLuarIds[$key]);
                        }
                    } else {
                        // Insert new penulis
                        PenulisLuar::create([
                            'arsip_haki_id' => $arsip->id_arsip_haki,
                            'dosen_luar_id' => $penulisLuar,
                            'peran_khusus' => $request->peran_dosen_luar[$key],
                            'koresponden' => $request->aktif_dosen_luar[$key],
                            'afiliasi' => $request->afiliasi_dosen_luar[$key]
                        ]);
                    }
                }
                // Delete remaining old penulis
                PenulisLuar::whereIn('id_penulis_luar', $existingPenulisLuarIds)->delete();
            }

            // Update or insert penulis lain
            if (is_array($request->penulis_dosen_lain)) {
                $existingPenulisLainIds = PenulisLain::where('arsip_haki_id', $arsip->id_arsip_haki)->pluck('id_penulis_lain')->toArray();
                foreach ($request->penulis_dosen_lain as $key => $penulisLain) {
                    if (isset($request->id_penulis_dosen_lain[$key]) && in_array($request->id_penulis_dosen_lain[$key], $existingPenulisLainIds)) {
                        // Update existing penulis
                        PenulisLain::where('id_penulis_lain', $request->id_penulis_dosen_lain[$key])->update([
                            'dosen_lain_id' => $penulisLain,
                            'peran_khusus' => $request->peran_dosen_lain[$key],
                            'koresponden' => $request->aktif_dosen_lain[$key],
                            'afiliasi' => $request->afiliasi_dosen_lain[$key]
                        ]);
                        // Remove from existing IDs list
                        if (($key = array_search($request->id_penulis_dosen_lain[$key], $existingPenulisLainIds)) !== false) {
                            unset($existingPenulisLainIds[$key]);
                        }
                    } else {
                        // Insert new penulis
                        PenulisLain::create([
                            'arsip_haki_id' => $arsip->id_arsip_haki,
                            'dosen_lain_id' => $penulisLain,
                            'peran_khusus' => $request->peran_dosen_lain[$key],
                            'koresponden' => $request->aktif_dosen_lain[$key],
                            'afiliasi' => $request->afiliasi_dosen_lain[$key]
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
            Log::error('Update arsip haki pengabdian: ' . $th->getMessage());
            return $this->permissionService->errorResponse('Data gagal diupdate');
        }
    }

    /** end:function for haki */

    /** begin:function for buku */
    public function indexBuku()
    {
        return view('laporan.luaranBuku.pengabdian.index');
    }

    public function createBuku()
    {
        $data['ta'] = DB::table('tahun_akademik')->select('id_tahun_akademik', 'nama_tahun_akademik')
            ->orderByDesc('created_at')
            ->get();
        return view('laporan.luaranBuku.pengabdian.create', $data);
    }

    public function editBuku(string $id)
    {
        $id = Crypt::decryptString($id);
        $data = ArsipBuku::where('id_arsip_buku', $id)->first();
        if ($data) {
            $data['ta'] = DB::table('tahun_akademik')->select('id_tahun_akademik', 'nama_tahun_akademik')
                ->orderByDesc('created_at')
                ->get();
            return view('laporan.luaranBuku.pengabdian.edit', $data);
        } else {
            return redirect()->back()->with('fail', 'Data tidak ditemukan.');
        }
    }

    public function listBuku()
    {
        $query = ArsipBuku::select(
            'arsip_buku.id_arsip_buku',
            'arsip_buku.judul',
            'arsip_buku.created_by',
            'arsip_buku.publish',
            'arsip_buku.tahun_terbit',
            'dosen.nama_dosen',
            'tahun_akademik.nama_tahun_akademik',
            'dosen.nidn',
            'dosen.nama_dosen',
            'prodi.singkatan as prodi',
            'fakultas.singkatan as fakultas'
        )
            ->leftJoin('tahun_akademik', 'tahun_akademik.id_tahun_akademik', '=', 'arsip_buku.tahun_akademik_id')
            ->leftJoin('dosen', 'dosen.id_dosen', '=', 'arsip_buku.dosen_id')
            ->leftJoin('prodi', 'prodi.id_prodi', '=', 'dosen.prodi_id')
            ->leftJoin('fakultas', 'fakultas.id_fakultas', '=', 'prodi.fakultas_id')
            ->where('arsip_buku.jenis', 'Pengabdian')
            ->orderBy('arsip_buku.created_at', 'DESC');

        // if auth dosen
        if ($this->userRole == 'dosen' && $this->dosenRole == 'dosen') {
            $query->where('arsip_buku.dosen_id', $this->dosenId);
        }

        // if auth admin
        if ($this->userRole == 'admin') {
            // $proposalId = $this->dataActiveService->proposalPengabdian($taId, $request->id_owner);
        }

        // if auth kaprodi
        if ($this->userRole == 'dosen' && $this->dosenRole == 'kaprodi') {
            $query->where('dosen.prodi_id', $this->kaprodiId);
        }

        $result = $query->get()
            ->map(function ($q) {
                return [
                    'action' => Crypt::encryptString($q->id_arsip_buku),
                    'penginput' => $q->created_by,
                    'tahun' => $q->tahun_terbit,
                    'ta' => $q->nama_tahun_akademik,
                    'penulis' => $q->nidn . ' | ' . $q->nama_dosen . ' | ' . $q->prodi . ' - ' . $q->fakultas,
                    'judul' => $q->judul,
                    'publish' => $q->publish === 'y' ? 'y' : 't'
                ];
            });

        return DataTables::of($result)
            ->addIndexColumn()
            ->toJson();
    }

    public function storeBuku(Request $request)
    {
        /** new */
        $validationRules = [
            'ta' => 'required',
            'judul' => 'required',
            'kategori' => 'required',
            'isbn' => 'required',
            'jumlah' => 'required',
            'penerbit' => 'required',
            'kota' => 'required',
            'tahun' => 'required',
            'url' => 'url|required',
            'file' => 'mimes:pdf|max:3072',
            'deskripsi' => 'required'
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
        $file_name = 'FAB_' . uniqid() . '.' . $file->getClientOriginalExtension();

        DB::beginTransaction();
        try {
            $save['dosen_id'] = $this->userRole == 'admin' || ($this->userRole == 'dosen' && $this->dosenRole != 'dosen') ? $request->id_owner : $this->dosenId;
            $save['tahun_akademik_id'] = $request->ta;
            $save['jenis'] = 'Pengabdian';
            $save['judul'] = $request->judul;
            $save['kategori_buku'] = $request->kategori;
            $save['isbn'] = $request->isbn;
            $save['jumlah_halaman'] = $request->jumlah;
            $save['penerbit'] = $request->penerbit;
            $save['kota_penerbit'] = $request->kota;
            $save['tahun_terbit'] = $request->tahun;
            $save['link'] = $request->url;
            $save['deskripsi'] = $request->deskripsi;
            $save['created_by'] = $this->userRole == 'admin' ? $this->userRole . '-' . Auth::user()->username : $this->dosenRole . '-' . Auth::user()->username;
            $save['publish'] = $request->has('publish') ? $request->publish : 't';
            $save['file_arsip_buku'] = $file_name;
            $store = ArsipBuku::create($save);

            if ($store) {
                $file_folder = 'files/arsipBuku';
                $file->move($file_folder, $file_name);
            }

            // Save dosen dalam data
            foreach ($request->penulis_dosen_dalam as $key => $penulisDalam) {
                if ($penulisDalam) {
                    $dosenDalam = new PenulisDalam();
                    $dosenDalam->arsip_buku_id = $store->id_arsip_buku;
                    $dosenDalam->dosen_id = $penulisDalam;
                    $dosenDalam->peran_khusus = $request->peran_dosen_dalam[$key];
                    $dosenDalam->koresponden = $request->aktif_dosen_dalam[$key];
                    $dosenDalam->afiliasi = $request->afiliasi_dosen_dalam[$key];
                    $dosenDalam->save();
                }
            }

            // Save dosen luar data
            if (is_array($request->penulis_dosen_luar)) {
                foreach ($request->penulis_dosen_luar as $key => $penulisLuar) {
                    if ($penulisLuar) {
                        $dosenLuar = new PenulisLuar();
                        $dosenLuar->arsip_buku_id = $store->id_arsip_buku;
                        $dosenLuar->dosen_luar_id = $penulisLuar;
                        $dosenLuar->peran_khusus = $request->peran_dosen_luar[$key];
                        $dosenLuar->koresponden = $request->aktif_dosen_luar[$key];
                        $dosenLuar->afiliasi = $request->afiliasi_dosen_luar[$key];
                        $dosenLuar->save();
                    }
                }
            }

            // Save dosen lain data
            if (is_array($request->penulis_dosen_lain)) {
                foreach ($request->penulis_dosen_lain as $key => $penulisLain) {
                    if ($penulisLain) {
                        $dosenLain = new PenulisLain();
                        $dosenLain->arsip_buku_id = $store->id_arsip_buku;
                        $dosenLain->dosen_lain_id = $penulisLain;
                        $dosenLain->peran_khusus = $request->peran_dosen_lain[$key];
                        $dosenLain->koresponden = $request->aktif_dosen_lain[$key];
                        $dosenLain->afiliasi = $request->afiliasi_dosen_lain[$key];
                        $dosenLain->save();
                    }
                }
            }

            DB::commit();
            return $this->permissionService->successResponse('data berhasil dibuat', $save);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Create arsip buku pengabdian: ' . $th->getMessage());
            return $this->permissionService->errorResponse('data gagal dibuat');
        }
    }

    public function showBuku(string $id)
    {
        $id = Crypt::decryptString($id);
        $data = ArsipBuku::select(
            'id_arsip_buku',
            'dosen_id',
            'tahun_akademik_id',
            'publish',
            'judul',
            'kategori_buku',
            'isbn',
            'tahun_terbit',
            'jumlah_halaman',
            'penerbit',
            'kota_penerbit',
            'link',
            'deskripsi',
            'file_arsip_buku',
        )
            ->with('penulisDalam', function ($q) {
                $q->select('id_penulis_dalam as id_penulis', 'arsip_buku_id', 'dosen_id', 'dosen.nama_dosen as nama', 'peran_khusus', 'koresponden', 'afiliasi')
                    ->leftJoin('dosen', 'dosen.id_dosen', 'penulis_dalam.dosen_id');
            })
            ->with('penulisLuar', function ($q) {
                $q->select('id_penulis_luar as id_penulis', 'arsip_buku_id', 'dosen_luar_id as dosen_id', 'dosen_luar.nama', 'peran_khusus', 'koresponden', 'afiliasi')
                    ->leftJoin('dosen_luar', 'dosen_luar.id_dosen_luar', 'penulis_luar.dosen_luar_id');
            })
            ->with('penulisLain', function ($q) {
                $q->select('id_penulis_lain as id_penulis', 'arsip_buku_id', 'dosen_lain_id as dosen_id', 'dosen_lain.nama', 'peran_khusus', 'koresponden', 'afiliasi')
                    ->leftJoin('dosen_lain', 'dosen_lain.id_dosen_lain', 'penulis_lain.dosen_lain_id');
            })
            ->where('id_arsip_buku', $id)
            ->first();
        if ($data) {
            $data['id_cript'] = Crypt::encryptString($data->id_arsip_buku);
            return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $data], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => $data], 400);
        }
    }

    public function updateBuku(Request $request, string $id)
    {
        $id = Crypt::decryptString($id);
        /** new */
        $validationRules = [
            'ta' => 'required',
            'judul' => 'required',
            'kategori' => 'required',
            'isbn' => 'required',
            'jumlah' => 'required',
            'penerbit' => 'required',
            'kota' => 'required',
            'tahun' => 'required',
            'url' => 'url|required',
            'deskripsi' => 'required',
            'file' => $request->hasFile('file') ? 'mimes:pdf|max:3072' : 'nullable',
        ];

        if ($this->userRole == 'admin' || ($this->userRole == 'dosen' && $this->dosenRole != 'dosen')) {
            $validationRules['id_owner'] = 'required';
        }

        $validateData = $this->permissionService->validateData($request->all(), $validationRules);
        /** new */

        if ($validateData !== null) {
            return $validateData;
        }

        $arsip = ArsipBuku::where('id_arsip_buku', $id)->first();
        if (!$arsip) {
            return $this->permissionService->errorResponse('Data tidak ditemukan');
        }

        $file = $request->file('file');
        $file_name = $arsip->file_arsip_buku;

        DB::beginTransaction();
        try {
            // Update file if new file is uploaded
            if ($file) {
                $file_folder = 'files/arsipBuku';
                // Hanya mencoba menghapus file jika $file_name tidak kosong atau null
                if (!empty($file_name) && file_exists($file_folder . '/' . $file_name)) {
                    unlink($file_folder . '/' . $file_name);
                }
                $file_name = 'FAB_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($file_folder, $file_name);
            }

            $arsip->update([
                'dosen_id' => $this->userRole == 'admin' || ($this->userRole == 'dosen' && $this->dosenRole != 'dosen') ? $request->id_owner : $arsip->dosen_id,
                'tahun_akademik_id' => $request->ta,
                'judul' => $request->judul,
                'kategori_buku' => $request->kategori,
                'isbn' => $request->isbn,
                'jumlah_halaman' => $request->jumlah,
                'penerbit' => $request->penerbit,
                'kota_penerbit' => $request->kota,
                'tahun_terbit' => $request->tahun,
                'link' => $request->url,
                'deskripsi' => $request->deskripsi,
                'file_arsip_buku' => $file_name,
                'publish' => $request->has('publish') ? $request->publish : 't',
                'created_by' => $this->userRole == 'admin' ? $this->userRole . '-' . Auth::user()->username : $this->dosenRole . '-' . Auth::user()->username,
            ]);

            // Update or insert penulis dalam
            $existingPenulisDalamIds = PenulisDalam::where('arsip_buku_id', $arsip->id_arsip_buku)->pluck('id_penulis_dalam')->toArray();
            foreach ($request->penulis_dosen_dalam as $key => $penulisDalam) {
                if (isset($request->id_penulis_dosen_dalam[$key]) && in_array($request->id_penulis_dosen_dalam[$key], $existingPenulisDalamIds)) {
                    // Update existing penulis
                    PenulisDalam::where('id_penulis_dalam', $request->id_penulis_dosen_dalam[$key])->update([
                        'dosen_id' => $penulisDalam,
                        'peran_khusus' => $request->peran_dosen_dalam[$key],
                        'koresponden' => $request->aktif_dosen_dalam[$key],
                        'afiliasi' => $request->afiliasi_dosen_dalam[$key]
                    ]);
                    // Remove from existing IDs list
                    if (($key = array_search($request->id_penulis_dosen_dalam[$key], $existingPenulisDalamIds)) !== false) {
                        unset($existingPenulisDalamIds[$key]);
                    }
                } else {
                    // Insert new penulis
                    PenulisDalam::create([
                        'arsip_buku_id' => $arsip->id_arsip_buku,
                        'dosen_id' => $penulisDalam,
                        'peran_khusus' => $request->peran_dosen_dalam[$key],
                        'koresponden' => $request->aktif_dosen_dalam[$key],
                        'afiliasi' => $request->afiliasi_dosen_dalam[$key]
                    ]);
                }
            }
            // Delete remaining old penulis
            PenulisDalam::whereIn('id_penulis_dalam', $existingPenulisDalamIds)->delete();

            // Update or insert penulis luar
            if (is_array($request->penulis_dosen_luar)) {
                $existingPenulisLuarIds = PenulisLuar::where('arsip_buku_id', $arsip->id_arsip_buku)->pluck('id_penulis_luar')->toArray();
                foreach ($request->penulis_dosen_luar as $key => $penulisLuar) {
                    if (isset($request->id_penulis_dosen_luar[$key]) && in_array($request->id_penulis_dosen_luar[$key], $existingPenulisLuarIds)) {
                        // Update existing penulis
                        PenulisLuar::where('id_penulis_luar', $request->id_penulis_dosen_luar[$key])->update([
                            'dosen_luar_id' => $penulisLuar,
                            'peran_khusus' => $request->peran_dosen_luar[$key],
                            'koresponden' => $request->aktif_dosen_luar[$key],
                            'afiliasi' => $request->afiliasi_dosen_luar[$key]
                        ]);
                        // Remove from existing IDs list
                        if (($key = array_search($request->id_penulis_dosen_luar[$key], $existingPenulisLuarIds)) !== false) {
                            unset($existingPenulisLuarIds[$key]);
                        }
                    } else {
                        // Insert new penulis
                        PenulisLuar::create([
                            'arsip_buku_id' => $arsip->id_arsip_buku,
                            'dosen_luar_id' => $penulisLuar,
                            'peran_khusus' => $request->peran_dosen_luar[$key],
                            'koresponden' => $request->aktif_dosen_luar[$key],
                            'afiliasi' => $request->afiliasi_dosen_luar[$key]
                        ]);
                    }
                }
                // Delete remaining old penulis
                PenulisLuar::whereIn('id_penulis_luar', $existingPenulisLuarIds)->delete();
            }

            // Update or insert penulis lain
            if (is_array($request->penulis_dosen_lain)) {
                $existingPenulisLainIds = PenulisLain::where('arsip_buku_id', $arsip->id_arsip_buku)->pluck('id_penulis_lain')->toArray();
                foreach ($request->penulis_dosen_lain as $key => $penulisLain) {
                    if (isset($request->id_penulis_dosen_lain[$key]) && in_array($request->id_penulis_dosen_lain[$key], $existingPenulisLainIds)) {
                        // Update existing penulis
                        PenulisLain::where('id_penulis_lain', $request->id_penulis_dosen_lain[$key])->update([
                            'dosen_lain_id' => $penulisLain,
                            'peran_khusus' => $request->peran_dosen_lain[$key],
                            'koresponden' => $request->aktif_dosen_lain[$key],
                            'afiliasi' => $request->afiliasi_dosen_lain[$key]
                        ]);
                        // Remove from existing IDs list
                        if (($key = array_search($request->id_penulis_dosen_lain[$key], $existingPenulisLainIds)) !== false) {
                            unset($existingPenulisLainIds[$key]);
                        }
                    } else {
                        // Insert new penulis
                        PenulisLain::create([
                            'arsip_buku_id' => $arsip->id_arsip_buku,
                            'dosen_lain_id' => $penulisLain,
                            'peran_khusus' => $request->peran_dosen_lain[$key],
                            'koresponden' => $request->aktif_dosen_lain[$key],
                            'afiliasi' => $request->afiliasi_dosen_lain[$key]
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
            Log::error('Update arsip buku pengabdian: ' . $th->getMessage());
            return $this->permissionService->errorResponse('Data gagal diupdate');
        }
    }
    /** end:function for buku */

    /** begin:function for prototype */

    public function indexPrototype()
    {
        return view('laporan.luaranPrototype.pengabdian.index');
    }

    public function createPrototype()
    {
        $data['ta'] = DB::table('tahun_akademik')->select('id_tahun_akademik', 'nama_tahun_akademik')
            ->orderByDesc('created_at')
            ->get();
        return view('laporan.luaranPrototype.pengabdian.create', $data);
    }

    public function editPrototype(string $id)
    {
        $id = Crypt::decryptString($id);
        $data = ArsipPrototype::where('id_arsip_prototype', $id)->first();
        if ($data) {
            $data['ta'] = DB::table('tahun_akademik')->select('id_tahun_akademik', 'nama_tahun_akademik')
                ->orderByDesc('created_at')
                ->get();
            return view('laporan.luaranPrototype.pengabdian.edit', $data);
        } else {
            return redirect()->back()->with('fail', 'Data tidak ditemukan.');
        }
    }

    public function listPrototype()
    {
        $query = ArsipPrototype::select(
            'arsip_prototype.id_arsip_prototype',
            'arsip_prototype.judul',
            'arsip_prototype.created_by',
            'arsip_prototype.publish',
            'arsip_prototype.tahun_pelaksanaan',
            'dosen.nama_dosen',
            'tahun_akademik.nama_tahun_akademik',
            'dosen.nidn',
            'dosen.nama_dosen',
            'prodi.singkatan as prodi',
            'fakultas.singkatan as fakultas'
        )
            ->leftJoin('tahun_akademik', 'tahun_akademik.id_tahun_akademik', '=', 'arsip_prototype.tahun_akademik_id')
            ->leftJoin('dosen', 'dosen.id_dosen', '=', 'arsip_prototype.dosen_id')
            ->leftJoin('prodi', 'prodi.id_prodi', '=', 'dosen.prodi_id')
            ->leftJoin('fakultas', 'fakultas.id_fakultas', '=', 'prodi.fakultas_id')
            ->where('arsip_prototype.jenis', 'Pengabdian')
            ->orderBy('arsip_prototype.created_at', 'DESC');

        // if auth dosen
        if ($this->userRole == 'dosen' && $this->dosenRole == 'dosen') {
            $query->where('arsip_prototype.dosen_id', $this->dosenId);
        }

        // if auth admin
        if ($this->userRole == 'admin') {
            // $proposalId = $this->dataActiveService->proposalPengabdian($taId, $request->id_owner);
        }

        // if auth kaprodi
        if ($this->userRole == 'dosen' && $this->dosenRole == 'kaprodi') {
            $query->where('dosen.prodi_id', $this->kaprodiId);
        }

        $result = $query->get()
            ->map(function ($q) {
                return [
                    'action' => Crypt::encryptString($q->id_arsip_prototype),
                    'penginput' => $q->created_by,
                    'tahun' => $q->tahun_pelaksanaan,
                    'ta' => $q->nama_tahun_akademik,
                    'penulis' => $q->nidn . ' | ' . $q->nama_dosen . ' | ' . $q->prodi . ' - ' . $q->fakultas,
                    'judul' => $q->judul,
                    'publish' => $q->publish === 'y' ? 'y' : 't'
                ];
            });

        return DataTables::of($result)
            ->addIndexColumn()
            ->toJson();
    }

    public function storePrototype(Request $request)
    {
        $dosen = Crypt::decryptString($request->dosen);
        $arsip = Crypt::decryptString($request->arsip);

        /** new */
        $validationRules = [
            'arsip' => 'required',
            'ta' => 'required',
            'judul'  => 'required',
            'tkt' => 'required',
            'level' => 'required',
            'tahun' => 'required',
            'deskripsi' => 'required',
            'file' => 'required|mimes:pdf|max:3072',
            'cover' => 'required|mimes:jpeg,jpg,png|max:3072'
        ];

        $validateData = $this->permissionService->validateData($request->all(), $validationRules);
        /** new */

        if ($validateData !== null) {
            return $validateData;
        }

        $file = $request->file('file');
        $file_name = 'FAPT_' . uniqid() . '.' . $file->getClientOriginalExtension();

        $cover = $request->file('cover');
        $cover_name = 'CAPT_' . uniqid() . '.' . $cover->getClientOriginalExtension();

        DB::beginTransaction();
        try {
            $save['arsip_id'] = $arsip;
            $save['dosen_id'] = $this->userRole == 'admin' || ($this->userRole == 'dosen' && $this->dosenRole != 'dosen') ? $dosen : $this->dosenId;
            $save['tahun_akademik_id'] = $request->ta;
            $save['jenis'] = 'Pengabdian';
            $save['judul'] = $request->judul;
            $save['tkt'] = $request->tkt;
            $save['level'] = $request->level;
            $save['tahun_pelaksanaan'] = $request->tahun;
            $save['deskripsi'] = $request->deskripsi;
            $save['created_by'] = $this->userRole == 'admin' ? $this->userRole . '-' . Auth::user()->username : $this->dosenRole . '-' . Auth::user()->username;
            $save['publish'] = $request->has('publish') ? $request->publish : 't';
            $save['file_arsip_prototype'] = $file_name;
            $save['cover_arsip_prototype'] = $cover_name;
            $store = ArsipPrototype::create($save);

            if ($store) {
                $file_folder = 'files/arsipPrototype';
                $file->move($file_folder, $file_name);

                $cover_folder = 'imgs/arsipPrototype';
                $cover->move($cover_folder, $cover_name);
            }

            DB::commit();
            return $this->permissionService->successResponse('data berhasil dibuat', $save);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Create arsip prototype pengabdian: ' . $th->getMessage());
            return $this->permissionService->errorResponse('data gagal dibuat');
        }
    }

    public function showPrototype(string $id)
    {
        $id = Crypt::decryptString($id);
        $data = ArsipPrototype::select(
            'arsip_id',
            'dosen_id',
            'tahun_akademik_id',
            'jenis',
            'publish',
            'judul',
            'tkt',
            'level',
            'tahun_pelaksanaan',
            'deskripsi',
            'file_arsip_prototype',
            'cover_arsip_prototype',
        )

            ->where('id_arsip_prototype', $id)
            ->first();
        if ($data) {
            $data['id_cript'] = Crypt::encryptString($data->id_arsip_prototype);
            $data['id_arsip_cript'] = Crypt::encryptString($data->arsip_id);
            return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $data], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => $data], 400);
        }
    }

    public function updatePrototype(Request $request, string $id)
    {
        $id = Crypt::decryptString($id);
        $dosen = Crypt::decryptString($request->dosen);
        $arsipId = Crypt::decryptString($request->arsip);

        /** new */
        $validationRules = [
            'arsip' => 'required',
            'ta' => 'required',
            'judul'  => 'required',
            'tkt' => 'required',
            'level' => 'required',
            'tahun' => 'required',
            'deskripsi' => 'required',
            'file' => $request->hasFile('file') ? 'mimes:pdf|max:3072' : 'nullable',
            'cover' => $request->hasFile('cover') ? 'mimes:jpeg,jpg,png|max:3072' : 'nullable',
        ];

        $validateData = $this->permissionService->validateData($request->all(), $validationRules);
        /** new */

        if ($validateData !== null) {
            return $validateData;
        }

        $arsip = ArsipPrototype::where('id_arsip_prototype', $id)->first();
        if (!$arsip) {
            return $this->permissionService->errorResponse('Data tidak ditemukan');
        }

        $file = $request->file('file');
        $file_name = $arsip->file_arsip_prototype;

        $cover = $request->file('cover');
        $cover_name = $arsip->cover_arsip_prototype;

        DB::beginTransaction();
        try {
            // Update file if new file is uploaded
            if ($file) {
                $file_folder = 'files/arsipPrototype';
                // Hanya mencoba menghapus file jika $file_name tidak kosong atau null
                if (!empty($file_name) && file_exists($file_folder . '/' . $file_name)) {
                    unlink($file_folder . '/' . $file_name);
                }
                $file_name = 'FAPT_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($file_folder, $file_name);
            }

            if ($cover) {
                $cover_folder = 'imgs/arsipPrototype';
                // Hanya mencoba menghapus file jika $file_name tidak kosong atau null
                if (!empty($cover_name) && file_exists($cover_folder . '/' . $cover_name)) {
                    unlink($cover_folder . '/' . $cover_name);
                }
                $cover_name = 'CAPT_' . uniqid() . '.' . $cover->getClientOriginalExtension();
                $cover->move($cover_folder, $cover_name);
            }

            $arsip->update([
                'arsip_id' => $arsipId,
                'dosen_id' => $this->userRole == 'admin' || ($this->userRole == 'dosen' && $this->dosenRole != 'dosen') ? $dosen : $this->dosenId,
                'tahun_akademik_id' => $request->ta,
                'judul' => $request->judul,
                'tkt' => $request->tkt,
                'level' => $request->level,
                'tahun_pelaksanaan' => $request->tahun,
                'deskripsi' => $request->deskripsi,
                'file_arsip_prototype' => $file_name,
                'cover_arsip_prototype' => $cover_name,
                'publish' => $request->has('publish') ? $request->publish : 't',
                'created_by' => $this->userRole == 'admin' ? $this->userRole . '-' . Auth::user()->username : $this->dosenRole . '-' . Auth::user()->username,
            ]);

            DB::commit();
            return $this->permissionService->successResponse('Data berhasil diupdate', $arsip);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Update arsip prototype pengabdian: ' . $th->getMessage());
            return $this->permissionService->errorResponse('Data gagal diupdate');
        }
    }
    /** end:function for prototype */

    /** begin:function for produk */
    public function indexProduk()
    {
        return view('laporan.luaranProduk.pengabdian.index');
    }

    public function createProduk()
    {
        $data['ta'] = DB::table('tahun_akademik')->select('id_tahun_akademik', 'nama_tahun_akademik')
            ->orderByDesc('created_at')
            ->get();
        return view('laporan.luaranProduk.pengabdian.create', $data);
    }

    public function editProduk(string $id)
    {
        $id = Crypt::decryptString($id);
        $data = ArsipProduk::where('id_arsip_produk', $id)->first();
        if ($data) {
            $data['ta'] = DB::table('tahun_akademik')->select('id_tahun_akademik', 'nama_tahun_akademik')
                ->orderByDesc('created_at')
                ->get();
            return view('laporan.luaranProduk.pengabdian.edit', $data);
        } else {
            return redirect()->back()->with('fail', 'Data tidak ditemukan.');
        }
    }

    public function listProduk()
    {
        $query = ArsipProduk::select(
            'arsip_produk.id_arsip_produk',
            'arsip_produk.judul',
            'arsip_produk.created_by',
            'arsip_produk.publish',
            'arsip_produk.tahun_pelaksanaan',
            'dosen.nama_dosen',
            'tahun_akademik.nama_tahun_akademik',
            'dosen.nidn',
            'dosen.nama_dosen',
            'prodi.singkatan as prodi',
            'fakultas.singkatan as fakultas'
        )
            ->leftJoin('tahun_akademik', 'tahun_akademik.id_tahun_akademik', '=', 'arsip_produk.tahun_akademik_id')
            ->leftJoin('dosen', 'dosen.id_dosen', '=', 'arsip_produk.dosen_id')
            ->leftJoin('prodi', 'prodi.id_prodi', '=', 'dosen.prodi_id')
            ->leftJoin('fakultas', 'fakultas.id_fakultas', '=', 'prodi.fakultas_id')
            ->where('arsip_produk.jenis', 'Pengabdian')
            ->orderBy('arsip_produk.created_at', 'DESC');

        // if auth dosen
        if ($this->userRole == 'dosen' && $this->dosenRole == 'dosen') {
            $query->where('arsip_produk.dosen_id', $this->dosenId);
        }

        // if auth admin
        if ($this->userRole == 'admin') {
            // $proposalId = $this->dataActiveService->proposalPengabdian($taId, $request->id_owner);
        }

        // if auth kaprodi
        if ($this->userRole == 'dosen' && $this->dosenRole == 'kaprodi') {
            $query->where('dosen.prodi_id', $this->kaprodiId);
        }

        $result = $query->get()
            ->map(function ($q) {
                return [
                    'action' => Crypt::encryptString($q->id_arsip_produk),
                    'penginput' => $q->created_by,
                    'tahun' => $q->tahun_pelaksanaan,
                    'ta' => $q->nama_tahun_akademik,
                    'penulis' => $q->nidn . ' | ' . $q->nama_dosen . ' | ' . $q->prodi . ' - ' . $q->fakultas,
                    'judul' => $q->judul,
                    'publish' => $q->publish === 'y' ? 'y' : 't'
                ];
            });

        return DataTables::of($result)
            ->addIndexColumn()
            ->toJson();
    }

    public function storeProduk(Request $request)
    {
        $dosen = Crypt::decryptString($request->dosen);
        $arsip = Crypt::decryptString($request->arsip);

        /** new */
        $validationRules = [
            'arsip' => 'required',
            'ta' => 'required',
            'judul'  => 'required',
            'tkt' => 'required',
            'level' => 'required',
            'tahun' => 'required',
            'link' => 'url|required',
            'mitra' => 'required',
            'jenis_mitra' => 'required',
            'negara_mitra' => 'required',
            'deskripsi' => 'required',
            'file' => 'required|mimes:pdf|max:3072',
            'cover' => 'required|mimes:jpeg,jpg,png|max:3072'
        ];

        $validateData = $this->permissionService->validateData($request->all(), $validationRules);
        /** new */

        if ($validateData !== null) {
            return $validateData;
        }

        $file = $request->file('file');
        $file_name = 'FAPR_' . uniqid() . '.' . $file->getClientOriginalExtension();

        $cover = $request->file('cover');
        $cover_name = 'CAPR_' . uniqid() . '.' . $cover->getClientOriginalExtension();

        DB::beginTransaction();
        try {
            $save['arsip_id'] = $arsip;
            $save['dosen_id'] = $this->userRole == 'admin' || ($this->userRole == 'dosen' && $this->dosenRole != 'dosen') ? $dosen : $this->dosenId;
            $save['tahun_akademik_id'] = $request->ta;
            $save['jenis'] = 'Pengabdian';
            $save['judul'] = $request->judul;
            $save['tkt'] = $request->tkt;
            $save['level'] = $request->level;
            $save['tahun_pelaksanaan'] = $request->tahun;
            $save['link'] = $request->link;
            $save['mitra'] = $request->mitra;
            $save['jenis_mitra'] = $request->jenis_mitra;
            $save['negara_mitra'] = $request->negara_mitra;
            $save['deskripsi'] = $request->deskripsi;
            $save['created_by'] = $this->userRole == 'admin' ? $this->userRole . '-' . Auth::user()->username : $this->dosenRole . '-' . Auth::user()->username;
            $save['publish'] = $request->has('publish') ? $request->publish : 't';
            $save['file_arsip_produk'] = $file_name;
            $save['cover_arsip_produk'] = $cover_name;
            $store = ArsipProduk::create($save);

            if ($store) {
                $file_folder = 'files/arsipProduk';
                $file->move($file_folder, $file_name);

                $cover_folder = 'imgs/arsipProduk';
                $cover->move($cover_folder, $cover_name);
            }

            DB::commit();
            return $this->permissionService->successResponse('data berhasil dibuat', $save);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Create arsip produk pengabdian: ' . $th->getMessage());
            return $this->permissionService->errorResponse('data gagal dibuat');
        }
    }

    public function showProduk(string $id)
    {
        $id = Crypt::decryptString($id);
        $data = ArsipProduk::select(
            'arsip_id',
            'dosen_id',
            'tahun_akademik_id',
            'jenis',
            'publish',
            'judul',
            'tkt',
            'level',
            'tahun_pelaksanaan',
            'link',
            'mitra',
            'jenis_mitra',
            'negara_mitra',
            'deskripsi',
            'file_arsip_produk',
            'cover_arsip_produk',
        )

            ->where('id_arsip_produk', $id)
            ->first();
        if ($data) {
            $data['id_cript'] = Crypt::encryptString($data->id_arsip_produk);
            $data['id_arsip_cript'] = Crypt::encryptString($data->arsip_id);
            return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $data], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => $data], 400);
        }
    }

    public function updateProduk(Request $request, string $id)
    {
        $id = Crypt::decryptString($id);
        $dosen = Crypt::decryptString($request->dosen);
        $arsipId = Crypt::decryptString($request->arsip);

        /** new */
        $validationRules = [
            'arsip' => 'required',
            'ta' => 'required',
            'judul'  => 'required',
            'tkt' => 'required',
            'level' => 'required',
            'tahun' => 'required',
            'link' => 'url|required',
            'mitra' => 'required',
            'jenis_mitra' => 'required',
            'negara_mitra' => 'required',
            'deskripsi' => 'required',
            'file' => $request->hasFile('file') ? 'mimes:pdf|max:3072' : 'nullable',
            'cover' => $request->hasFile('cover') ? 'mimes:jpeg,jpg,png|max:3072' : 'nullable',
        ];

        $validateData = $this->permissionService->validateData($request->all(), $validationRules);
        /** new */

        if ($validateData !== null) {
            return $validateData;
        }

        $arsip = ArsipProduk::where('id_arsip_produk', $id)->first();
        if (!$arsip) {
            return $this->permissionService->errorResponse('Data tidak ditemukan');
        }

        $file = $request->file('file');
        $file_name = $arsip->file_arsip_produk;

        $cover = $request->file('cover');
        $cover_name = $arsip->cover_arsip_produk;

        DB::beginTransaction();
        try {
            // Update file if new file is uploaded
            if ($file) {
                $file_folder = 'files/arsipProduk';
                // Hanya mencoba menghapus file jika $file_name tidak kosong atau null
                if (!empty($file_name) && file_exists($file_folder . '/' . $file_name)) {
                    unlink($file_folder . '/' . $file_name);
                }
                $file_name = 'FAPR_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($file_folder, $file_name);
            }

            if ($cover) {
                $cover_folder = 'imgs/arsipProduk';
                // Hanya mencoba menghapus file jika $file_name tidak kosong atau null
                if (!empty($cover_name) && file_exists($cover_folder . '/' . $cover_name)) {
                    unlink($cover_folder . '/' . $cover_name);
                }
                $cover_name = 'CAPR_' . uniqid() . '.' . $cover->getClientOriginalExtension();
                $cover->move($cover_folder, $cover_name);
            }

            $arsip->update([
                'arsip_id' => $arsipId,
                'dosen_id' => $this->userRole == 'admin' || ($this->userRole == 'dosen' && $this->dosenRole != 'dosen') ? $dosen : $this->dosenId,
                'tahun_akademik_id' => $request->ta,
                'judul' => $request->judul,
                'tkt' => $request->tkt,
                'level' => $request->level,
                'tahun_pelaksanaan' => $request->tahun,
                'link' => $request->link,
                'mitra' => $request->mitra,
                'jenis_mitra' => $request->jenis_mitra,
                'negara_mitra' => $request->negara_mitra,
                'deskripsi' => $request->deskripsi,
                'file_arsip_produk' => $file_name,
                'cover_arsip_produk' => $cover_name,
                'publish' => $request->has('publish') ? $request->publish : 't',
                'created_by' => $this->userRole == 'admin' ? $this->userRole . '-' . Auth::user()->username : $this->dosenRole . '-' . Auth::user()->username,
            ]);

            DB::commit();
            return $this->permissionService->successResponse('Data berhasil diupdate', $arsip);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Update arsip produk pengabdian: ' . $th->getMessage());
            return $this->permissionService->errorResponse('Data gagal diupdate');
        }
    }
    /** end:function for produk */
}
