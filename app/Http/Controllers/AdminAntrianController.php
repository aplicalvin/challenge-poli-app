<?php

namespace App\Http\Controllers;

use App\Models\Periksa;
use App\Models\Poli;
use App\Models\JadwalJaga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminAntrianController extends Controller
{
    public function index()
    {
        return view('admin.antrian-realtime');
    }

    public function getQueueData()
    {
        // Map English day to Indonesian day
        $days = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];
        $todayName = $days[date('l')];

        // Find all schedules active today
        $activeSchedules = JadwalJaga::whereHas('shift', function($q) use ($todayName) {
            $q->where('hari', $todayName);
        })
        ->with(['dokter', 'ruang.poli'])
        ->get();

        $data = $activeSchedules->map(function($schedule) {
            // Find current patient being examined in THIS schedule today
            $currentServing = Periksa::where('id_jadwal_jaga', $schedule->id)
                ->whereDate('tgl_periksa', date('Y-m-d'))
                ->where('status_periksa', 'sedang_periksa')
                ->orderBy('no_antrian', 'asc')
                ->first();

            return [
                'poli_name' => $schedule->ruang->poli->nama_poli ?? '-',
                'doctor_name' => $schedule->dokter->nama,
                'current_number' => $currentServing ? $currentServing->no_antrian : '0',
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
