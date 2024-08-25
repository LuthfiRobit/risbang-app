<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class BeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 20; $i++) {
            $createdAt = Carbon::now()->subDays(rand(0, 30)); // Waktu acak selama sebulan terakhir

            DB::table('berita')->insert([
                'publish' => $faker->randomElement(['y', 't']),
                'judul' => $faker->sentence,
                'slug' => $faker->slug,
                'deskripsi' => $faker->paragraph,
                'img_berita' => 'CAPR_66b7f19d9f602.png',
                'created_by' => $faker->userName,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
        }
    }
}
