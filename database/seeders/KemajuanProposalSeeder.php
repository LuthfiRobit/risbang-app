<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class KemajuanProposalSeeder extends Seeder
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

            DB::table('kemajuan_proposal')->insert([
                'proposal_id' => $proposal->id_proposal,
                'dosen_id' => $proposal->dosen_id,
                'tahun_akademik_id' => $proposal->tahun_akademik_id,
                'jenis' => $proposal->jenis,
                'status_review' => $faker->randomElement(['Diterima', 'Ditolak', 'Direvisi']),
                'link_drive' => $faker->url,
                'file_kemajuan' => $faker->word . '.pdf',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
