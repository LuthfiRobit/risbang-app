<?php

namespace App\Imports;

use App\Models\BidangIlmu;
use App\Models\Dosen;
use App\Models\Kepakaran;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
// use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class DosenImport implements ToCollection, WithHeadingRow, SkipsOnFailure, WithBatchInserts, WithChunkReading
{
    use Importable, SkipsFailures;

    protected $successfulRows = [];
    protected $failures = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            $row = $row->toArray();
            $errors = [];

            // Validasi kolom wajib
            if (empty($row['nik'])) {
                $errors[] = 'nik : kosong';
            }
            if (empty($row['nidn'])) {
                $errors[] = 'nidn : kosong';
            }
            if (empty($row['no_tlpn'])) {
                $errors[] = 'no_tlpn : kosong';
            }
            if (empty($row['email'])) {
                $errors[] = 'email : kosong';
            }
            if (empty($row['nama_dosen'])) {
                $errors[] = 'nama_dosen : kosong';
            }
            if (empty($row['prodi_id'])) {
                $errors[] = 'prodi_id : kosong';
            }

            // Validasi prodi_id
            if (!Prodi::where('id_prodi', $row['prodi_id'])->exists()) {
                $errors[] = 'prodi_id : tidak valid';
            }

            // Validasi uniqueness
            if (User::where('email', $row['email'])->exists()) {
                $errors[] = 'email : sudah ada';
            }
            if (Dosen::where('nik', $row['nik'])->exists()) {
                $errors[] = 'nik : sudah ada';
            }
            if (Dosen::where('nidn', $row['nidn'])->exists()) {
                $errors[] = 'nidn : sudah ada';
            }
            if (Dosen::where('no_tlpn', $row['no_tlpn'])->exists()) {
                $errors[] = 'no_tlpn : sudah ada';
            }

            // Validasi bidang_ilmu_id dan kepakaran_id jika diisi
            if (!empty($row['bidang_ilmu_id']) && !BidangIlmu::where('id_bidang_ilmu', $row['bidang_ilmu_id'])->exists()) {
                $errors[] = 'bidang_ilmu_id : tidak valid';
            }
            if (!empty($row['kepakaran_id']) && !Kepakaran::where('id_kepakaran', $row['kepakaran_id'])->exists()) {
                $errors[] = 'kepakaran_id : tidak valid';
            }

            // Jika ada kesalahan, tambahkan ke kegagalan dan masukkan nomor baris
            if (!empty($errors)) {
                $this->failures[] = [
                    'row' => $row,
                    'row_number' => $index + 2, // +2 untuk mengimbangi heading row
                    'errors' => $errors
                ];
                continue;
            }

            // Jika lolos validasi, simpan data ke dalam database
            DB::beginTransaction();
            try {
                // Buat user
                $user = User::create([
                    'email' => $row['email'],
                    'email_verified_at' => now(),
                    'username' => $row['nidn'],
                    'password' => Hash::make($row['nidn']),
                    'phone_number' => $row['no_tlpn'],
                    'user_role' => 'dosen',
                    'dosen_role' => 'dosen',
                ]);

                // Jika user berhasil dibuat, simpan data dosen
                if ($user) {
                    $dosenData = [
                        'user_id' => $user->id_user,
                        'prodi_id' => $row['prodi_id'],
                        'bidang_ilmu_id' => $row['bidang_ilmu_id'] ?? null,
                        'kepakaran_id' => $row['kepakaran_id'] ?? null,
                        'nidn' => $row['nidn'],
                        'nik' => $row['nik'],
                        'no_tlpn' => $row['no_tlpn'],
                        'email' => $row['email'],
                        'nama_dosen' => $row['nama_dosen'],
                        'jk' => $row['jk'] ?? null,
                        'kode_pos' => $row['kode_pos'] ?? null,
                        'alamat' => $row['alamat'] ?? null,
                        'status_dosen' => $row['status_dosen'] ?? null,
                        'jabatan' => $row['jabatan'] ?? 'lecture',
                        'status_serdos' => $row['status_serdos'] ?? null,
                    ];

                    Dosen::create($dosenData);
                }

                // Simpan data yang berhasil
                DB::commit();
                $this->successfulRows[] = $dosenData;
            } catch (\Exception $e) {
                DB::rollBack();
                $this->failures[] = [
                    'row' => $row,
                    'row_number' => $index + 2, // Tambahkan nomor baris yang gagal
                    'errors' => ['Database error: ' . $e->getMessage()]
                ];
                Log::error('Error inserting user or dosen:', ['error' => $e->getMessage(), 'row' => $row]);
            }
        }
    }

    public function failures()
    {
        return $this->failures;
    }

    public function successfulRows()
    {
        return $this->successfulRows;
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function chunkSize(): int
    {
        return 100;
    }

    public function headingRow(): int
    {
        return 1;
    }
}
