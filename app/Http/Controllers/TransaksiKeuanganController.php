<?php

namespace App\Http\Controllers;

use App\Models\Periksa;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        return DB::transaction(function () use ($id) {
            $periksa = Periksa::findOrFail($id);
            
            // Update status_periksa to bagian_obat
            $periksa->update(['status_periksa' => 'bagian_obat']);

            // Ensure pembayaran record exists and is verified
            Pembayaran::updateOrCreate(
                ['id_periksa' => $id],
                [
                    'status_pembayaran' => 'verified',
                    'verified_by' => Auth::id(),
                    'total_bayar' => $periksa->total_biaya,
                    'tgl_bayar' => now()
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil dikonfirmasi.'
            ]);
        });
    }

    public function reject(Request $request, $id)
    {
        return DB::transaction(function () use ($id) {
            $periksa = Periksa::findOrFail($id);
            
            // Find or create pembayaran record and set to rejected
            $pembayaran = Pembayaran::where('id_periksa', $id)->first();
            
            if ($pembayaran) {
                $pembayaran->update([
                    'status_pembayaran' => 'rejected',
                    'verified_by' => Auth::id()
                ]);
            } else {
                // If they reject even before upload, create a rejected record
                Pembayaran::create([
                    'id_periksa' => $id,
                    'status_pembayaran' => 'rejected',
                    'verified_by' => Auth::id(),
                    'total_bayar' => $periksa->total_biaya,
                    'tgl_bayar' => now()
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran ditolak. Pasien akan diminta mengunggah ulang bukti pembayaran.'
            ]);
        });
    }
}
