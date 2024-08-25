<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Ambil semua user_id dari tabel user dengan user_role 'dosen' yang belum ada di tabel dosen
        $userIds = DB::table('users')
            ->where('user_role', 'dosen')
            ->whereNotIn('id_user', DB::table('dosen')->pluck('user_id'))
            ->pluck('id_user')
            ->toArray();

        // Ambil semua prodi_id dari tabel prodi
        $prodiIds = DB::table('prodi')->pluck('id_prodi')->toArray();

        foreach ($userIds as $userId) {
            DB::table('dosen')->insert([
                'user_id' => $userId,
                'prodi_id' => $faker->randomElement($prodiIds),
                'nidn' => $faker->numerify('##########'),
                'nik' => $faker->numerify('############'),
                'no_tlpn' => DB::table('users')->where('id_user', $userId)->value('phone_number'),
                'email' => DB::table('users')->where('id_user', $userId)->value('email'),
                'nama_dosen' => $faker->name,
                'jk' => $faker->randomElement(['l', 'p']),
                'kode_pos' => $faker->postcode,
                'alamat' => $faker->address,
                'status_dosen' => $faker->randomElement(['tetap', 'tidak tetap']),
                'jabatan' => $faker->randomElement(['lecture', 'asisten ahli', 'lektor', 'lektor kepala', 'guru besar']),
                'status_serdos' => $faker->randomElement(['belum terferifikasi', 'terferifikasi']),
                'pendidikan_terakhir' => $faker->randomElement(['s1', 's2', 's3', 'prof']),
                'instansi_pendidikan_terakhir' => $faker->company . ' University'
            ]);
        }
    }
}
