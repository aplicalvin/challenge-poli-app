<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            // Admin (1 orang)
            [
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
            // Dokter (2 orang)
            [
                'username' => 'dokter_satu',
                'email' => 'dokter1@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'dokter',
            ],
            [
                'username' => 'dokter_dua',
                'email' => 'dokter2@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'dokter',
            ],
            // Pasien (1 orang)
            [
                'username' => 'pasien_satu',
                'email' => 'pasien@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'pasien',
            ],
            // Apoteker (1 orang)
            [
                'username' => 'apoteker_satu',
                'email' => 'apoteker@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'apoteker',
            ],
            // Kasir (1 orang)
            [
                'username' => 'kasir_satu',
                'email' => 'kasir@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'kasir',
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->insert(array_merge($user, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}