<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class PengumumanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        // Generate 10 data berjenis 'Pengumuman'
        for ($i = 0; $i < 10; $i++) {
            $isFileLarge = $faker->boolean; // Determine if the file size is more than 3MB

            DB::table('pengumuman')->insert([
                'jenis' => 'Pengumuman',
                'publish' => $faker->randomElement(['y', 't']),
                'judul' => $faker->sentence,
                'url' => $isFileLarge ? 'https://www.youtube.com/watch?v=dQw4w9WgXcQ' : null,
                'deskripsi' => $faker->paragraph,
                'file_pengumuman' => $isFileLarge ? null : 'FAPT_66b6b42dd654d.pdf',
                'created_by' => $faker->userName,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Generate 15 data berjenis 'Pedoman'
        for ($i = 0; $i < 15; $i++) {
            $isFileLarge = $faker->boolean; // Determine if the file size is more than 3MB

            DB::table('pengumuman')->insert([
                'jenis' => 'Pedoman',
                'publish' => $faker->randomElement(['y', 't']),
                'judul' => $faker->sentence,
                'url' => $isFileLarge ? 'https://www.youtube.com/watch?v=dQw4w9WgXcQ' : null,
                'deskripsi' => $faker->paragraph,
                'file_pengumuman' => $isFileLarge ? null : 'FAPT_66b6b42dd654d.pdf',
                'created_by' => $faker->userName,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
