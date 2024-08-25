<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ArsipJurnalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Ambil semua proposal dari tabel proposal
        $proposals = DB::table('proposal')->get();

        foreach ($proposals as $proposal) {
            // Ambil data dosen terkait
            $dosen = DB::table('dosen')->where('id_dosen', $proposal->dosen_id)->first();
            // Ambil data user terkait
            $user = DB::table('users')->where('id_user', $dosen->user_id)->first();

            // Tentukan kategori publikasi dan peringkat berdasarkan kategori publikasi
            $kategoriPublikasi = $faker->randomElement(['Internasional', 'Nasional Terakreditasi', 'Nasional Tidak Terakreditasi']);
            $peringkat = null;
            switch ($kategoriPublikasi) {
                case 'Internasional':
                    $peringkat = $faker->randomElement(['Q1', 'Q2', 'Q3', 'Q4', 'Sinta 1']);
                    break;
                case 'Nasional Terakreditasi':
                    $peringkat = $faker->randomElement(['Sinta 2', 'Sinta 3', 'Sinta 4', 'Sinta 5', 'Sinta 6']);
                    break;
                case 'Nasional Tidak Terakreditasi':
                    $peringkat = 'Tidak Terakreditasi';
                    break;
            }

            DB::table('arsip_jurnal')->insert([
                'proposal_id' => $proposal->id_proposal,
                'dosen_id' => $proposal->dosen_id,
                'tahun_akademik_id' => $proposal->tahun_akademik_id,
                'jenis' => $proposal->jenis,
                'publish' => $faker->randomElement(['y', 't']),
                'judul' => $proposal->judul,
                'penerbit' => $faker->company,
                'kategori_publikasi' => $kategoriPublikasi,
                'peringkat' => $peringkat,
                'halaman' => $faker->numberBetween(1, 100),
                'issn' => $faker->isbn13,
                'tahun_pelaksanaan' => $faker->year,
                'volume' => $faker->numberBetween(1, 10),
                'nomor' => $faker->numberBetween(1, 100),
                'link' => $faker->url,
                'abstrak' => $proposal->abstrak,
                // 'file_arsip_jurnal' => $faker->url,
                'created_by' => $user->user_role . '-' . $user->username,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
