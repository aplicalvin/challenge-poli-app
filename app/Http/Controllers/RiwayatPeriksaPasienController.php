<?php

namespace App\Http\Controllers;

use App\Models\Periksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RiwayatPeriksaPasienController extends Controller
{
    public function index(Request $request)
    {
        $pasien = Auth::user()->pasien;
        if (!$pasien) {
            return redirect()->back()->with('error', 'Data pasien tidak ditemukan.');
        }

        $query = Periksa::where('id_pasien', $pasien->id)
            ->with(['jadwalJaga.dokter.poli', 'detailPeriksaObat.obat'])
            ->orderBy('tgl_periksa', 'desc');

        // Filter by Date Range
        if ($request->filled('start_date')) {
            $query->whereDate('tgl_periksa', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('tgl_periksa', '<=', $request->end_date);
        }

        $riwayat = $query->get();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'html' => view('patient.history.table', compact('riwayat'))->render()
            ]);
        }

        return view('patient.history.index', compact('riwayat'));
    }

    public function detail($id)
    {
        $periksa = Periksa::with(['jadwalJaga.dokter.poli', 'detailPeriksaObat.obat', 'pembayaran'])->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $periksa
        ]);
    }

    public function pay(Request $request, $id)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $periksa = Periksa::findOrFail($id);
        
        $path = $request->file('bukti_pembayaran')->store('payments', 'public');

        \App\Models\Pembayaran::updateOrCreate(
            ['id_periksa' => $id],
            [
                'total_bayar' => $periksa->total_biaya,
                'bukti_pembayaran' => $path,
                'status_pembayaran' => 'pending',
                'tgl_bayar' => now(),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Bukti pembayaran berhasil diunggah.'
        ]);
    }
}
