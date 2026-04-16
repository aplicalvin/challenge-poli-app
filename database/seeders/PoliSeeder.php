<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PoliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $poli = [
            ['nama_poli' => 'Poli Umum', 'keterangan' => 'Pemeriksaan kesehatan umum', 'added_by' => 1, 'edited_by' => 1],
            ['nama_poli' => 'Poli Gigi', 'keterangan' => 'Pemeriksaan kesehatan gigi dan mulut', 'added_by' => 1, 'edited_by' => 1],
        ];

        foreach ($poli as $p) {
            \App\Models\Poli::create($p);
        }
    }
}
