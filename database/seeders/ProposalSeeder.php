<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ProposalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Ambil semua dosen_id dari tabel dosen
        $dosenIds = DB::table('dosen')->pluck('id_dosen')->toArray();

        // Ambil semua tahun_akademik_id dari tabel tahun_akademik
        $tahunAkademikIds = DB::table('tahun_akademik')->pluck('id_tahun_akademik')->toArray();

        foreach ($tahunAkademikIds as $tahunAkademikId) {
            foreach ($dosenIds as $dosenId) {
                // Buat proposal jenis 'Penelitian'
                DB::table('proposal')->insert([
                    'dosen_id' => $dosenId,
                    'tahun_akademik_id' => $tahunAkademikId,
                    'jenis' => 'Penelitian',
                    'status' => $faker->randomElement(['Pengajuan', 'Kemajuan', 'Pelaksanaan', 'Selesai', 'Terhenti']),
                    'status_review' => $faker->randomElement(['Diterima', 'Ditolak', 'Direvisi']),
                    'jenis_penelitian' => $faker->randomElement(['Dasar', 'Terapan', 'Strategis Nasional']),
                    'jenis_pengabdian' => null,
                    'judul' => $faker->sentence,
                    'abstrak' => $faker->paragraph,
                    'kata_kunci' => implode('; ', $faker->words(3)),
                    'latar_belakang' => $faker->text,
                    'metode' => $faker->text,
                    'rencana' => $faker->text,
                    'dapus' => $faker->text,
                    // 'file_proposal' => $faker->url
                ]);

                // Buat proposal jenis 'Pengabdian'
                DB::table('proposal')->insert([
                    'dosen_id' => $dosenId,
                    'tahun_akademik_id' => $tahunAkademikId,
                    'jenis' => 'Pengabdian',
                    'status' => $faker->randomElement(['Pengajuan', 'Kemajuan', 'Pelaksanaan', 'Selesai', 'Terhenti']),
                    'status_review' => $faker->randomElement(['Diterima', 'Ditolak', 'Direvisi']),
                    'jenis_penelitian' => null,
                    'jenis_pengabdian' => $faker->randomElement(['Layanan', 'Pendampingan', 'Pemberdayaan', 'Pengembangan Produk']),
                    'judul' => $faker->sentence,
                    'abstrak' => $faker->paragraph,
                    'kata_kunci' => implode('; ', $faker->words(3)),
                    'latar_belakang' => $faker->text,
                    'metode' => $faker->text,
                    'rencana' => $faker->text,
                    'dapus' => $faker->text,
                    // 'file_proposal' => $faker->url
                ]);
            }
        }
    }
}
