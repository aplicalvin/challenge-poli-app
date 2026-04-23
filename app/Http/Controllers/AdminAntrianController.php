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
        $currentTime = date('H:i:s');

        // Find all schedules active today AND currently on duty based on shift hours
        $activeSchedules = JadwalJaga::whereHas('shift', function($q) use ($todayName, $currentTime) {
            $q->where('hari', $todayName)
              ->where('jam_masuk', '<=', $currentTime)
              ->where('jam_keluar', '>=', $currentTime);
        })
        ->with(['dokter', 'ruang.poli'])
        ->get();

        // Group by Poli ID to ensure 1 card per Polyclinic
        $data = $activeSchedules->groupBy(function($item) {
            return $item->ruang->id_poli ?? 'unknown';
        })->map(function($schedules) {
            $first = $schedules->first();
            $scheduleIds = $schedules->pluck('id');

            // Find current patient being examined in any of these active schedules today
            $currentServing = Periksa::whereIn('id_jadwal_jaga', $scheduleIds)
                ->whereDate('tgl_periksa', date('Y-m-d'))
                ->where('status_periksa', 'sedang_periksa')
                ->orderBy('no_antrian', 'asc')
                ->first();

            return [
                'poli_name' => $first->ruang->poli->nama_poli ?? '-',
                'doctor_name' => $schedules->pluck('dokter.nama')->unique()->join(', '),
                'current_number' => $currentServing ? $currentServing->no_antrian : '0',
                'is_on_duty' => true // Since we filtered by time, they are on duty
            ];
        })->values();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
