<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // database/seeders/ProfileSeeder.php
    public function run(): void
    {
        // 1. Data Dokter (Mengambil user role dokter)
        $userDokters = \App\Models\User::where('role', 'dokter')->get();
        $polis = \App\Models\Poli::all();

        foreach ($userDokters as $index => $user) {
            \App\Models\Dokter::create([
                'id_user' => $user->id,
                'id_poli' => $polis[$index]->id, // Dokter 1 di Poli 1, Dokter 2 di Poli 2
                'nama' => 'Dr. ' . ($index == 0 ? 'Suhardi' : 'Anisa'),
                'alamat' => 'Jl. Dr. Sutomo No. ' . ($index + 1),
                'no_hp' => '08123456789' . $index,
            ]);
        }

        // 2. Data Pasien
        $userPasien = \App\Models\User::where('role', 'pasien')->first();
        \App\Models\Pasien::create([
            'id_user' => $userPasien->id,
            'nama' => 'Budi Santoso',
            'alamat' => 'Jl. Imam Bonjol No. 207',
            'no_ktp' => '3301012345670001',
            'no_hp' => '085641000999',
            'no_rm' => '202604-001', // Format: YYYYMM-XXX 
        ]);

        // 3. Data Staff (Apoteker & Kasir)
        $staffUsers = \App\Models\User::whereIn('role', ['apoteker', 'kasir'])->get();
        foreach ($staffUsers as $user) {
            \App\Models\Staff::create([
                'id_user' => $user->id,
                'nama' => 'Staff ' . ucfirst($user->role),
                'alamat' => 'Kantor Pusat Poliklinik',
                'no_hp' => '089999888777',
            ]);
        }
    }
}
