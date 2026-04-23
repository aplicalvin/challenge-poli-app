<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Poli;
use App\Models\Ruang;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Shift;
use App\Models\JadwalJaga;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class PoliklinikSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Polis
        $poliUmum = Poli::create([
            'nama_poli' => 'Poli Umum',
            'keterangan' => 'Layanan kesehatan umum'
        ]);

        $poliGigi = Poli::create([
            'nama_poli' => 'Poli Gigi',
            'keterangan' => 'Layanan kesehatan gigi dan mulut'
        ]);

        // 2. Create Ruangs
        $ruangUmum = Ruang::create([
            'nama' => 'Ruang Umum 01',
            'id_poli' => $poliUmum->id
        ]);

        $ruangGigi = Ruang::create([
            'nama' => 'Ruang Gigi 01',
            'id_poli' => $poliGigi->id
        ]);

        // 3. Create Admin, Kasir, Apoteker
        User::create([
            'username' => 'admin',
            'email' => 'admin@poliklinik.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        User::create([
            'username' => 'kasir',
            'email' => 'kasir@poliklinik.com',
            'password' => Hash::make('password'),
            'role' => 'kasir'
        ]);

        User::create([
            'username' => 'apoteker',
            'email' => 'apoteker@poliklinik.com',
            'password' => Hash::make('password'),
            'role' => 'apoteker'
        ]);

        // 4. Create Doctors
        $doctors = [];
        $doctorNames = ['Dr. Andi', 'Dr. Budi', 'Dr. Citra', 'Dr. Dewi'];
        
        for ($i = 0; $i < 4; $i++) {
            $user = User::create([
                'username' => 'dokter' . ($i + 1),
                'email' => 'dokter' . ($i + 1) . '@poliklinik.com',
                'password' => Hash::make('password'),
                'role' => 'dokter'
            ]);

            $doctors[] = Dokter::create([
                'id_user' => $user->id,
                'id_poli' => $i < 2 ? $poliUmum->id : $poliGigi->id,
                'nama' => $doctorNames[$i],
                'no_hp' => '0812345678' . $i,
                'alamat' => 'Alamat Dokter ' . ($i + 1),
                'no_ktp' => '331234567890000' . $i
            ]);
        }

        // 5. Create 10 Patients
        for ($i = 0; $i < 10; $i++) {
            $seq = 4880 + $i;
            $username = 'a11231' . $seq;
            $email = '11120231' . $seq . '@mhs.dinus.ac.id';

            $user = User::create([
                'username' => $username,
                'email' => $email,
                'password' => Hash::make('password'),
                'role' => 'pasien'
            ]);

            Pasien::create([
                'id_user' => $user->id,
                'nama' => 'Pasien ' . ($i + 1),
                'no_rm' => 'RM/' . date('Y/m/') . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'no_ktp' => '331234567891000' . $i,
                'no_hp' => '0898765432' . $i,
                'alamat' => 'Alamat Pasien ' . ($i + 1)
            ]);
        }

        // 6. Create Shift Schedule (Monday to Friday)
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $morningShifts = [];
        $afternoonShifts = [];

        foreach ($days as $day) {
            $morningShifts[$day] = Shift::create([
                'nama' => 'Pagi',
                'hari' => $day,
                'jam_masuk' => '08:00:00',
                'jam_keluar' => '12:00:00'
            ]);

            $afternoonShifts[$day] = Shift::create([
                'nama' => 'Siang',
                'hari' => $day,
                'jam_masuk' => '13:00:00',
                'jam_keluar' => '16:00:00'
            ]);
        }

        // 7. Create Doctor Schedules (Jadwal Jaga)
        // Each doctor gets 5 shifts per week, alternating
        foreach ($days as $index => $day) {
            // Poli Umum Doctors (Doctor 1 & 2)
            if ($index % 2 === 0) {
                // Mon, Wed, Fri
                $this->createJadwal($morningShifts[$day]->id, $doctors[0]->id, $ruangUmum->id);
                $this->createJadwal($afternoonShifts[$day]->id, $doctors[1]->id, $ruangUmum->id);
                
                // Poli Gigi Doctors (Doctor 3 & 4)
                $this->createJadwal($morningShifts[$day]->id, $doctors[2]->id, $ruangGigi->id);
                $this->createJadwal($afternoonShifts[$day]->id, $doctors[3]->id, $ruangGigi->id);
            } else {
                // Tue, Thu
                $this->createJadwal($afternoonShifts[$day]->id, $doctors[0]->id, $ruangUmum->id);
                $this->createJadwal($morningShifts[$day]->id, $doctors[1]->id, $ruangUmum->id);

                // Poli Gigi Doctors (Doctor 3 & 4)
                $this->createJadwal($afternoonShifts[$day]->id, $doctors[2]->id, $ruangGigi->id);
                $this->createJadwal($morningShifts[$day]->id, $doctors[3]->id, $ruangGigi->id);
            }
        }
    }

    private function createJadwal($shiftId, $doctorId, $ruangId)
    {
        JadwalJaga::create([
            'id_shift' => $shiftId,
            'id_dokter' => $doctorId,
            'id_ruang' => $ruangId
        ]);
    }
}
