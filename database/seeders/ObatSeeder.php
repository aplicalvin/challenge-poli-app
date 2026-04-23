<?php

namespace Database\Seeders;

use App\Models\Obat;
use Illuminate\Database\Seeder;

class ObatSeeder extends Seeder
{
    public function run(): void
    {
        $obats = [
            [
                'nama_obat' => 'Paracetamol 500mg',
                'kemasan' => 'Strip',
                'harga' => 5000,
                'stok' => 100
            ],
            [
                'nama_obat' => 'Amoxicillin 500mg',
                'kemasan' => 'Strip',
                'harga' => 15000,
                'stok' => 50
            ],
            [
                'nama_obat' => 'Ibuprofen 400mg',
                'kemasan' => 'Strip',
                'harga' => 8000,
                'stok' => 80
            ],
            [
                'nama_obat' => 'Cetirizine 10mg',
                'kemasan' => 'Strip',
                'harga' => 12000,
                'stok' => 60
            ],
            [
                'nama_obat' => 'Omeprazole 20mg',
                'kemasan' => 'Strip',
                'harga' => 20000,
                'stok' => 40
            ],
            [
                'nama_obat' => 'Antasida Doen',
                'kemasan' => 'Strip',
                'harga' => 3000,
                'stok' => 150
            ],
            [
                'nama_obat' => 'OBH Combi Plus',
                'kemasan' => 'Botol 60ml',
                'harga' => 18000,
                'stok' => 30
            ],
            [
                'nama_obat' => 'Betadine Antiseptic',
                'kemasan' => 'Botol 15ml',
                'harga' => 10000,
                'stok' => 25
            ],
            [
                'nama_obat' => 'Vitamin C 500mg',
                'kemasan' => 'Botol 30 Tablet',
                'harga' => 25000,
                'stok' => 20
            ],
            [
                'nama_obat' => 'Oralit',
                'kemasan' => 'Sachet',
                'harga' => 2000,
                'stok' => 200
            ],
        ];

        foreach ($obats as $obat) {
            Obat::create($obat);
        }
    }
}
