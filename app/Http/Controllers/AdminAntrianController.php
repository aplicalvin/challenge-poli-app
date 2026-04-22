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
        // Get active queues per polyclinic
        // We look for patients with status 'sedang_periksa' or the latest 'selesai' to show current progress
        // Actually, the requirement says "current queue number being served"
        
        $queues = Poli::with(['jadwalJaga' => function($q) {
            $q->where('hari', date('l')) // Today's schedules
              ->with('dokter');
        }])->get()->map(function($poli) {
            // Find current patient being examined in this poli
            $currentServing = Periksa::whereHas('jadwalJaga', function($q) use ($poli) {
                $q->where('id_poli', $poli->id);
            })
            ->where('tgl_periksa', date('Y-m-d'))
            ->where('status_periksa', 'sedang_periksa')
            ->orderBy('no_antrian', 'asc')
            ->first();

            // If no one is 'sedang_periksa', maybe show the last one 'selesai' or 'menunggu_pembayaran'?
            // Usually, 'sedang_periksa' is the most accurate for "Now Serving"
            
            $doctorName = "-";
            if ($poli->jadwalJaga->count() > 0) {
                $doctorName = $poli->jadwalJaga->first()->dokter->nama;
            }

            return [
                'poli_name' => $poli->nama_poli,
                'doctor_name' => $doctorName,
                'current_number' => $currentServing ? $currentServing->no_antrian : '0',
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $queues
        ]);
    }
}
