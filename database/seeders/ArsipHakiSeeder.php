<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ArsipHakiSeeder extends Seeder
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

            // Tentukan kategori haki dan jenis haki berdasarkan kategori haki
            $kategoriHaki = $faker->randomElement([
                'Haki', 'Merk', 'Paten', 'Rahasia Dagang',
                'Desain Industri', 'Indikasi Geografis',
                'Desain Tata Letak Sirkuit Terpadu'
            ]);
            $jenisHaki = null;
            switch ($kategoriHaki) {
                case 'Haki':
                    $jenisHaki = $faker->randomElement([
                        'Karya Tulis', 'Karya Seni', 'Komposisi Musik',
                        'Karya Audio Visual', 'Karya Fotografi',
                        'Karya Drama & Koreografi', 'Karya Rekaman',
                        'Program Komputer'
                    ]);
                    break;
                case 'Merk':
                    $jenisHaki = $faker->randomElement([
                        'Merk Dagang', 'Merk Jasa', 'Merk Dagang & Jasa'
                    ]);
                    break;
                case 'Paten':
                    $jenisHaki = $faker->randomElement([
                        'Paten', 'Paten Sederhana'
                    ]);
                    break;
                case 'Rahasia Dagang':
                    $jenisHaki = $faker->randomElement([
                        'Metode Produksi', 'Metode Penjualan', 'Metode Pengolahan'
                    ]);
                    break;
                case 'Desain Industri':
                    $jenisHaki = $faker->randomElement([
                        'Komponen', 'Produk Kompleks', 'Produk Sederhana'
                    ]);
                    break;
                case 'Indikasi Geografis':
                    $jenisHaki = $faker->randomElement([
                        'Hasil Industri', 'Sumber Daya Alam', 'Barang Kerajinan Tangan'
                    ]);
                    break;
                case 'Desain Tata Letak Sirkuit Terpadu':
                    $jenisHaki = $faker->randomElement([
                        'DTLST Satu Elemen', 'DTLST Dua Elemen', 'DTLST Tiga Elemen'
                    ]);
                    break;
            }

            DB::table('arsip_haki')->insert([
                'proposal_id' => $proposal->id_proposal,
                'dosen_id' => $proposal->dosen_id,
                'tahun_akademik_id' => $proposal->tahun_akademik_id,
                'jenis' => $proposal->jenis,
                'publish' => $faker->randomElement(['y', 't']),
                'judul' => $proposal->judul,
                'kategori_haki' => $kategoriHaki,
                'jenis_haki' => $jenisHaki,
                'tahun_pelaksanaan' => $faker->year,
                'pemegang' => $faker->name,
                'nomor' => $faker->unique()->numerify('HKI-######'),
                'link' => $faker->url,
                'deskripsi' => $faker->text,
                // 'file_arsip_haki' => $faker->url,
                'created_by' => $user->user_role . '-' . $user->username,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
