<?php

namespace App\Http\Controllers;

use App\Models\Periksa;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiKeuanganController extends Controller
{
    public function index()
    {
        $transaksi = Periksa::where('status_periksa', 'menunggu_pembayaran')
            ->with(['pasien', 'pembayaran'])
            ->orderBy('tgl_periksa', 'desc')
            ->get();

        return view('keuangan.transaksi', compact('transaksi'));
    }

    public function confirm(Request $request, $id)
    {
        $periksa = Periksa::findOrFail($id);
        
        // Update status_periksa to bagian_obat
        $periksa->update(['status_periksa' => 'bagian_obat']);

        // Update pembayaran status
        if ($periksa->pembayaran) {
            $periksa->pembayaran->update([
                'status_pembayaran' => 'verified',
                'verified_by' => Auth::id()
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil dikonfirmasi.'
        ]);
    }

    public function reject(Request $request, $id)
    {
        $periksa = Periksa::findOrFail($id);
        
        if ($periksa->pembayaran) {
            $periksa->pembayaran->update([
                'status_pembayaran' => 'rejected',
                'verified_by' => Auth::id()
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran ditolak.'
        ]);
    }
}
