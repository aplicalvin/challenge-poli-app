<?php

namespace App\Http\Controllers;

use App\Models\Periksa;
use App\Models\Shift;
use App\Models\DetailPeriksaObat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RiwayatPeriksaDokterController extends Controller
{
    public function index(Request $request)
    {
        $dokter = Auth::user()->dokter;
        if (!$dokter) {
            return redirect()->back()->with('error', 'Data dokter tidak ditemukan.');
        }

        $query = Periksa::whereHas('jadwalJaga', function ($q) use ($dokter) {
            $q->where('id_dokter', $dokter->id);
        })
            ->with(['pasien', 'jadwalJaga.shift', 'detailPeriksaObat.obat'])
            ->orderBy('tgl_periksa', 'desc');

        // Filter by Shift
        if ($request->filled('id_shift')) {
            $query->whereHas('jadwalJaga', function ($q) use ($request) {
                $q->where('id_shift', $request->id_shift);
            });
        }

        // Filter by Date
        if ($request->filled('date')) {
            $query->whereDate('tgl_periksa', $request->date);
        }

        $riwayat = $query->get();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'html' => view('doctor.history.table', compact('riwayat'))->render()
            ]);
        }

        // Fetch shifts for filter dropdown - only those assigned to this doctor
        $shifts = Shift::whereHas('jadwalJaga', function ($q) use ($dokter) {
            $q->where('id_dokter', $dokter->id);
        })->get();

        return view('doctor.history.index', compact('riwayat', 'shifts'));
    }

    public function detail($id)
    {
        $periksa = Periksa::with(['pasien', 'detailPeriksaObat.obat'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $periksa
        ]);
    }
}
