<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ArsipBukuSeeder extends Seeder
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

            DB::table('arsip_buku')->insert([
                'proposal_id' => $proposal->id_proposal,
                'dosen_id' => $proposal->dosen_id,
                'tahun_akademik_id' => $proposal->tahun_akademik_id,
                'jenis' => $proposal->jenis,
                'publish' => $faker->randomElement(['y', 't']),
                'judul' => $proposal->judul,
                'kategori_buku' => $faker->randomElement(['Buku Ajar', 'Buku Referensi', 'Monograf', 'Modul Ajar']),
                'isbn' => $faker->isbn13,
                'tahun_terbit' => $faker->year($max = '2024', $min = '2020'),
                'jumlah_halaman' => $faker->numberBetween(100, 500),
                'penerbit' => $faker->company,
                'kota_penerbit' => $faker->city,
                'link' => $faker->url,
                'deskripsi' => $faker->text,
                // 'file_arsip_buku' => $faker->url,
                'created_by' => $user->user_role . '-' . $user->username,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
