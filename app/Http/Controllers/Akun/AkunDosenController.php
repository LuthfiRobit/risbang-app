<?php

namespace App\Http\Controllers\Akun;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\User;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AkunDosenController extends Controller
{
    protected PermissionService $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function index()
    {
        return view('akun.dosen.index');
    }

    public function show()
    {
        $data = User::select(
            'users.id_user',
            'users.username',
            'users.email',
            'users.phone_number',
            'users.profile_pict',
            'dosen.bidang_ilmu_id',
            'dosen.kepakaran_id',
            'dosen.nidn',
            'dosen.nik',
            'dosen.no_npwp',
            'dosen.nama_dosen',
            'dosen.kode_pos',
            'dosen.alamat',
            'dosen.status_dosen',
            'dosen.jabatan',
            'dosen.status_serdos',
            'dosen.pendidikan_terakhir',
            'dosen.instansi_pendidikan_terakhir',
            'dosen.rekening',
            'dosen.namabank_kantorcabang',
            'dosen.nama_akunbank',
            'dosen.link_google_scholar',
            'dosen.link_sinta',
            'dosen.link_scopus',
            'dosen.link_orcid',
            'dosen.link_publons',
            'dosen.link_garuda',
            'dosen.file_ktp',
            'dosen.file_sk_dosen',
            'dosen.file_npwp',
            'dosen.img_ttd'
        )
            ->where('id_user', Auth::user()->id_user)
            ->where('user_role', 'dosen')
            ->leftJoin('dosen', 'dosen.user_id', 'users.id_user')
            ->first();
        if ($data) {
            return response()->json(['success' => true, 'message' => 'data tersedia', 'data' => $data], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'data tidak ditemukan', 'data' => $data], 400);
        }
    }

    public function update(Request $request)
    {
        $validateData = $this->permissionService->validateData($request->all(), [

            'nik' => 'required',
            'nidn' => 'required',
            'npwp' => 'required',
            'bidang_ilmu' => 'required',
            'kepakaran' => 'required',
            'jafung' => 'required',
            'status_serdos' => 'required',
            'pendidikan_terakhir' => 'required',
            'perguruan' => 'required',
            'alamat' => 'required',
            'kode_pos' => 'required',

            'name' => 'required',
            'email' => 'required|email:rfc,dns',
            'username' => 'required',
            'phone_number' => 'required|',
            'avatar' => $request->hasFile('avatar') ? 'mimes:jpeg,jpg,png|max:2048' : 'nullable'
        ]);

        if ($validateData !== null) {
            return $validateData;
        }

        $user = User::where('id_user', Auth::user()->id_user)->first();
        if (!$user) {
            return $this->permissionService->errorResponse('Data tidak ditemukan');
        }

        $file = $request->file('avatar');
        $file_name = $user->profile_pict;

        DB::beginTransaction();
        try {
            // Update file if new file is uploaded
            if ($file) {
                $file_folder = 'imgs/profileUser';
                if ($file_name !== null) {
                    if (file_exists($file_folder . '/' . $file_name)) {
                        unlink($file_folder . '/' . $file_name);
                    }
                }
                $file_name = 'PD_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($file_folder, $file_name);
            }

            $user->update([
                'email' => $request->email,
                'username' => $request->username,
                'phone_number' => $request->phone_number,
                'profile_pict' => $file_name,
            ]);

            $dosen = Dosen::where('user_id', Auth::user()->id_user)->first();
            $dosen->update([
                'nik' => $request->nik,
                'nidn' => $request->nidn,
                'no_npwp' => $request->npwp,
                'bidang_ilmu_id' => $request->bidang_ilmu,
                'kepakaran_id' => $request->kepakaran,
                'jabatan' => $request->jafung,
                'status_serdos' => $request->status_serdos,
                'pendidikan_terakhir' => $request->pendidikan_terakhir,
                'instansi_pendidikan_terakhir' => $request->perguruan,
                'alamat' => $request->alamat,
                'kode_pos' => $request->kode_pos,
                'nama_dosen' => $request->name,
            ]);

            DB::commit();
            return $this->permissionService->successResponse('Data berhasil diupdate', $user);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Update admin gagal: ' . $th->getMessage());
            return $this->permissionService->errorResponse('Data gagal diupdate');
        }
    }

    public function updateBank(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $validateData = $this->permissionService->validateData($request->all(), [
            'norek' => $request->filled('norek') ? 'integer' : 'nullable',
            'nama_bank' => $request->filled('nama_bank') ? 'max:100' : 'nullable',
            'nama_akun' => $request->filled('nama_akun') ? 'max:250' : 'nullable'
        ]);

        if ($validateData !== null) {
            return $validateData;
        }

        $user = Dosen::where('id_dosen', $id)->first();
        if (!$user) {
            return $this->permissionService->errorResponse('Data tidak ditemukan');
        }

        DB::beginTransaction();
        try {

            $user->update([
                'rekening' => $request->norek,
                'namabank_kantorcabang' => $request->nama_bank,
                'nama_akunbank' => $request->nama_akun,
            ]);

            DB::commit();
            return $this->permissionService->successResponse('Data berhasil diupdate', $user);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Update admin gagal: ' . $th->getMessage());
            return $this->permissionService->errorResponse('Data gagal diupdate');
        }
    }

    public function updateResearch(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $validateData = $this->permissionService->validateData($request->all(), [
            'link_scholar' => $request->filled('link_scholar') ? 'url' : 'nullable',
            'link_sinta' => $request->filled('link_sinta') ? 'url' : 'nullable',
            'link_scopus' => $request->filled('link_scopus') ? 'url' : 'nullable',
            'link_publons' => $request->filled('link_publons') ? 'url' : 'nullable',
            'link_orcid' => $request->filled('link_orcid') ? 'url' : 'nullable',
            'link_garuda' => $request->filled('link_garuda') ? 'url' : 'nullable',
        ]);

        if ($validateData !== null) {
            return $validateData;
        }

        $user = Dosen::where('id_dosen', $id)->first();
        if (!$user) {
            return $this->permissionService->errorResponse('Data tidak ditemukan');
        }

        DB::beginTransaction();
        try {

            $user->update([
                'link_google_scholar' => $request->link_scholar,
                'link_sinta' => $request->link_sinta,
                'link_scopus' => $request->link_scopus,
                'link_orcid' => $request->link_orcid,
                'link_publons' => $request->link_publons,
                'link_garuda' => $request->link_garuda,
            ]);

            DB::commit();
            return $this->permissionService->successResponse('Data berhasil diupdate', $user);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Update admin gagal: ' . $th->getMessage());
            return $this->permissionService->errorResponse('Data gagal diupdate');
        }
    }

    public function updateFile(Request $request, $id)
    {
        $id = Crypt::decrypt($id);

        $validationRules = [
            'file_ktp' => $request->hasFile('file_ktp') ? 'mimes:jpeg,jpg,png|max:2048' : 'nullable',
            'file_npwp' => $request->hasFile('file_npwp') ? 'mimes:jpeg,jpg,png|max:2048' : 'nullable',
            'file_sk' => $request->hasFile('file_sk') ? 'mimes:pdf|max:3072' : 'nullable',
            'file_ttd' => $request->hasFile('file_ttd') ? 'mimes:jpeg,jpg,png|max:2048' : 'nullable',
        ];

        $validateData = $this->permissionService->validateData($request->all(), $validationRules);
        if ($validateData !== null) {
            return $validateData;
        }

        $user = Dosen::find($id);
        if (!$user) {
            return $this->permissionService->errorResponse('Data tidak ditemukan');
        }

        // Tentukan file dan folder tujuan
        $files = [
            'file_ktp' => ['folder' => 'imgs/pkt', 'old_file' => $user->file_ktp, 'prefix' => 'FKD_'],
            'file_sk' => ['folder' => 'files/skDosen', 'old_file' => $user->file_sk_dosen, 'prefix' => 'FSD_'],
            'file_npwp' => ['folder' => 'imgs/npwp', 'old_file' => $user->file_npwp, 'prefix' => 'FND_'],
            'file_ttd' => ['folder' => 'imgs/dtt', 'old_file' => $user->img_ttd, 'prefix' => 'FTD_']
        ];

        // Mulai transaksi database
        DB::beginTransaction();
        try {
            foreach ($files as $inputName => $fileInfo) {
                // Jika ada file yang diupload
                if ($request->hasFile($inputName)) {
                    // Hapus file lama jika ada
                    if ($fileInfo['old_file'] && file_exists($fileInfo['folder'] . '/' . $fileInfo['old_file'])) {
                        unlink($fileInfo['folder'] . '/' . $fileInfo['old_file']);
                    }

                    // Simpan file baru
                    $newFileName = $fileInfo['prefix'] . uniqid() . '.' . $request->file($inputName)->getClientOriginalExtension();
                    $request->file($inputName)->move($fileInfo['folder'], $newFileName);

                    // Update nama file baru di user model
                    $columnName = $this->getColumnName($inputName);
                    $user->{$columnName} = $newFileName;
                }
            }

            // Simpan perubahan pada user
            $user->save();

            // Commit transaksi
            DB::commit();
            return $this->permissionService->successResponse('Data berhasil diupdate', $user);
        } catch (\Throwable $th) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollBack();
            Log::error('Update admin gagal: ' . $th->getMessage());
            return $this->permissionService->errorResponse('Data gagal diupdate');
        }
    }

    /**
     * Fungsi untuk mendapatkan nama kolom yang sesuai di database
     */
    private function getColumnName($inputName)
    {
        $columnMap = [
            'file_ktp' => 'file_ktp',
            'file_sk' => 'file_sk_dosen',
            'file_npwp' => 'file_npwp',
            'file_ttd' => 'img_ttd',
        ];

        return $columnMap[$inputName];
    }
}
