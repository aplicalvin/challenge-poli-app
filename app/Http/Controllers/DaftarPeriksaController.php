<?php

namespace App\Http\Controllers;

use App\Models\Periksa;
use App\Models\JadwalJaga;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DaftarPeriksaController extends Controller
{
    public function index()
    {
        $pasien = auth()->user()->pasien;
        if (!$pasien) {
            return redirect()->route('patient.dashboard')->with('error', 'Data pasien tidak ditemukan.');
        }

        $daftarPeriksa = Periksa::where('id_pasien', $pasien->id)
            ->where('status_periksa', '!=', 'batal') // Added: Hide cancelled entries
            ->with(['jadwalJaga.dokter', 'jadwalJaga.shift', 'jadwalJaga.ruang.poli'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('patient.registration.index', compact('daftarPeriksa'));
    }

    public function getSchedules(Request $request)
    {
        $request->validate([
            'date' => 'required|date'
        ]);

        $date = $request->date;
        $dayOfWeek = Carbon::parse($date)->locale('id')->dayName; // e.g., "Senin", "Selasa"
        $dayOfWeek = ucfirst($dayOfWeek); // Ensure first letter is uppercase
        
        $schedules = JadwalJaga::with(['dokter', 'shift', 'ruang.poli'])
            ->whereHas('shift', function ($query) use ($dayOfWeek) {
                $query->where('hari', $dayOfWeek);
            })
            ->get()
            ->map(function ($s) {
                return [
                    'id' => $s->id,
                    'dokter_nama' => $s->dokter->nama,
                    'poli_nama' => $s->ruang->poli->nama_poli ?? '-',
                    'jam' => $s->shift->jam_masuk . ' - ' . $s->shift->jam_keluar,
                ];
            });

        return response()->json($schedules);
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'id_jadwal_jaga' => 'required|exists:jadwal_jaga,id',
            'keluhan' => 'required|string',
        ]);

        $pasien = auth()->user()->pasien;
        if (!$pasien) {
             return response()->json(['success' => false, 'message' => 'Data pasien tidak ditemukan.'], 404);
        }

        // Feature: Duplicate check for the same shift (active status only)
        // Rule from user: "cannot register more than one appointment in one time (one sif)"
        $existing = Periksa::where('id_pasien', $pasien->id)
            ->where('id_jadwal_jaga', $request->id_jadwal_jaga)
            ->whereNotIn('status_periksa', ['selesai', 'batal'])
            ->exists();
        
        if ($existing) {
            return response()->json([
                'success' => false, 
                'message' => 'Anda sudah terdaftar di jadwal ini dan sedang dalam proses atau antri.'
            ], 422);
        }

        // Calculate no_antrian based on the appointment date
        $count = Periksa::where('id_jadwal_jaga', $request->id_jadwal_jaga)
            ->whereDate('tgl_periksa', $request->date) // Updated to check tgl_periksa instead of created_at
            ->count();
        
        $no_antrian = $count + 1;

        // Determination of initial status
        $schedule = JadwalJaga::with('shift')->find($request->id_jadwal_jaga);
        $now = Carbon::now();
        $startDate = Carbon::parse($request->date . ' ' . $schedule->shift->jam_masuk);
        
        $status = 'belum_saatnya';
        if ($now->greaterThanOrEqualTo($startDate)) {
            $status = 'antri';
        }

        $periksa = Periksa::create([
            'id_pasien' => $pasien->id,
            'id_jadwal_jaga' => $request->id_jadwal_jaga,
            'keluhan' => $request->keluhan,
            'no_antrian' => $no_antrian,
            'status_periksa' => $status,
            'tgl_periksa' => $request->date . ' ' . $schedule->shift->jam_masuk, // Store the appointment date/time
            'added_by' => auth()->id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran berhasil!',
            'data' => $periksa
        ]);
    }

    public function cancel($id)
    {
        $pasien = auth()->user()->pasien;
        if (!$pasien) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $periksa = Periksa::where('id_pasien', $pasien->id)->findOrFail($id);

        if (!in_array($periksa->status_periksa, ['belum_saatnya', 'antri'])) {
            return response()->json([
                'success' => false,
                'message' => 'Pendaftaran tidak dapat dibatalkan karena pemeriksaan sudah dimulai atau selesai.'
            ], 422);
        }

        $periksa->update(['status_periksa' => 'batal']);

        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran berhasil dibatalkan.'
        ]);
    }

    public function checkStatus()
    {
        $pasien = auth()->user()->pasien;
        if (!$pasien) return response()->json(['status' => 'none']);

        $activePeriksa = Periksa::where('id_pasien', $pasien->id)
            ->whereIn('status_periksa', ['antri', 'sedang_periksa'])
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$activePeriksa) return response()->json(['status' => 'none']);

        return response()->json([
            'status' => $activePeriksa->status_periksa,
            'id' => $activePeriksa->id,
            'no_antrian' => $activePeriksa->no_antrian
        ]);
    }
}
