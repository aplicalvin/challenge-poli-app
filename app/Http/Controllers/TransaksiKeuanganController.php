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
                    'status_pembayaran' => 'lunas',
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
            // If rejection happens, we delete the payment record to allow patient to re-upload (since ENUM only has pending/lunas)
            $pembayaran = Pembayaran::where('id_periksa', $id)->first();
            if ($pembayaran) {
                $pembayaran->delete();
            }

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran ditolak. Pasien akan diminta mengunggah ulang bukti pembayaran.'
            ]);
        });
    }
}
