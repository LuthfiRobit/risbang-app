<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // User dengan user_role 'admin'
        DB::table('users')->insert([
            'email' => $faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'username' => $faker->userName,
            'password' => Hash::make('admin'), // you can replace 'password' with the desired password
            'phone_number' => $faker->phoneNumber,
            'user_role' => 'admin',
            'dosen_role' => null,
            'active' => 'y',
            'profile_pict' => $faker->imageUrl(640, 480, 'people', true)
        ]);

        // User dengan user_role 'developer'
        DB::table('users')->insert([
            'email' => $faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'username' => $faker->userName,
            'password' => Hash::make('developer'), // you can replace 'password' with the desired password
            'phone_number' => $faker->phoneNumber,
            'user_role' => 'developer',
            'dosen_role' => null,
            'active' => 'y',
            'profile_pict' => $faker->imageUrl(640, 480, 'people', true)
        ]);

        // 20 User dengan user_role 'dosen' dan dosen_role 'dosen'
        for ($i = 0; $i < 20; $i++) {
            DB::table('users')->insert([
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'username' => $faker->userName,
                'password' => Hash::make($faker->userName), // you can replace 'password' with the desired password
                'phone_number' => $faker->phoneNumber,
                'user_role' => 'dosen',
                'dosen_role' => 'dosen',
                'active' => $faker->randomElement(['y', 't']),
                'profile_pict' => $faker->imageUrl(640, 480, 'people', true)
            ]);
        }
    }
}