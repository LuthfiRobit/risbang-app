<?php

namespace App\Imports;

use App\Models\Dosen;
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

    // public $failures = [];

    /**
     * Process each row from the Excel file.
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Skip row if essential columns are missing
            if (empty($row['email']) || empty($row['nidn']) || empty($row['no_tlpn'])) {
                Log::warning('Skipping row due to missing required fields:', ['row' => $row]);
                continue; // Skip this row
            }

            // Check if 'nidn' is valid (example validation)
            if (empty($row['nidn'])) {
                Log::warning('Skipping row due to invalid NIDN:', ['row' => $row]);
                continue; // Skip this row
            }

            // Skip if the email already exists to avoid duplication
            if (User::where('email', $row['email'])->exists()) {
                Log::warning('Email already exists: ' . $row['email']);
                continue; // Skip this row
            }

            // Start database transaction
            DB::beginTransaction();
            try {
                // Create user
                $user = User::create([
                    'email' => $row['email'],
                    'email_verified_at' => now(),
                    'username' => $row['nidn'],
                    'password' => Hash::make($row['nidn']),
                    'phone_number' => $row['no_tlpn'],
                    'user_role' => 'dosen',
                    'dosen_role' => 'dosen',
                ]);

                // If the user is successfully created, create the related dosen data
                if ($user) {
                    $dosenData = [
                        'user_id' => $user->id_user,
                        'prodi_id' => $row['prodi_id'] ?? null,
                        'bidang_ilmu_id' => $row['bidang_ilmu_id'] ?? null,
                        'kepakaran_id' => $row['kepakaran_id'] ?? null,
                        'nidn' => $row['nidn'],
                        'nik' => $row['nik'] ?? null,
                        'no_tlpn' => $row['no_tlpn'],
                        'email' => $row['email'],
                        'nama_dosen' => $row['nama_dosen'] ?? null,
                        'jk' => $row['jk'] ?? null,
                        'kode_pos' => $row['kode_pos'] ?? null,
                        'alamat' => $row['alamat'] ?? null,
                        'status_dosen' => $row['status_dosen'] ?? null,
                        'jabatan' => $row['jabatan'] ?? null,
                        'status_serdos' => $row['status_serdos'] ?? null,
                    ];

                    // Log the data before saving
                    Log::info('Saving Dosen data:', ['dosen_data' => $dosenData]);

                    // Save dosen data
                    Dosen::create($dosenData);
                } else {
                    // Handle case where user creation fails
                    Log::error('User creation failed', ['row' => $row]);
                    DB::rollBack(); // Rollback the transaction
                    continue; // Skip to the next row
                }

                // Commit the transaction if everything is successful
                DB::commit();
            } catch (\Exception $e) {
                // Rollback the transaction in case of error
                DB::rollBack();
                Log::error('Error inserting user or dosen:', ['error' => $e->getMessage(), 'row' => $row]);
            }
        }
    }

    /**
     * Batch insert size to optimize performance.
     */
    public function batchSize(): int
    {
        return 100;
    }

    /**
     * Chunk size for reading to optimize performance.
     */
    public function chunkSize(): int
    {
        return 100;
    }

    public function headingRow(): int
    {
        return 1;
    }
}
