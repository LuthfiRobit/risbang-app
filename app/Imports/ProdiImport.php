<?php

namespace App\Imports;

use App\Models\Fakultas;
use App\Models\Prodi;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProdiImport implements ToCollection, WithHeadingRow, SkipsOnFailure, WithBatchInserts, WithChunkReading
{
    use Importable, SkipsFailures;

    protected $successfulRows = [];
    protected $failures = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            $row = $row->toArray();

            $errors = [];

            // Validasi kolom
            if (empty($row['fakultas_id'])) {
                $errors[] = 'fakultas_id : kosong';
            }
            if (empty($row['nama_prodi'])) {
                $errors[] = 'nama_prodi : kosong';
            }
            if (empty($row['singkatan'])) {
                $errors[] = 'singkatan : kosong';
            }

            // Validasi fakultas_id
            if (!Fakultas::where('id_fakultas', $row['fakultas_id'])->exists()) {
                $errors[] = 'fakultas_id : tidak ada data';
            }

            // Cek duplikat nama_prodi dan singkatan
            if (Prodi::where('nama_prodi', $row['nama_prodi'])->exists()) {
                $errors[] = 'nama_prodi : sudah ada';
            }
            if (Prodi::where('singkatan', $row['singkatan'])->exists()) {
                $errors[] = 'singkatan : sudah ada';
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
                $prodiData = [
                    'fakultas_id' => $row['fakultas_id'],
                    'nama_prodi' => $row['nama_prodi'],
                    'singkatan' => $row['singkatan'],
                ];

                Prodi::create($prodiData);
                DB::commit();

                // Simpan data yang berhasil
                $this->successfulRows[] = $prodiData;
            } catch (\Exception $e) {
                DB::rollBack();
                $this->failures[] = [
                    'row' => $row,
                    'row_number' => $index + 2, // Tambahkan nomor baris yang gagal
                    'errors' => ['Database error: ' . $e->getMessage()]
                ];
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
