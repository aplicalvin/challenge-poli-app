<?php

namespace App\Http\Controllers;

use App\Models\Periksa;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LayananFarmasiController extends Controller
{
    public function index()
    {
        $antrian = Periksa::where('status_periksa', 'bagian_obat')
            ->with(['pasien'])
            ->orderBy('created_at', 'asc')
            ->get();

        return view('pharmacist.service.index', compact('antrian'));
    }

    public function detail($id)
    {
        $periksa = Periksa::with(['pasien', 'detailPeriksaObat.obat'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $periksa
        ]);
    }

    public function complete(Request $request, $id)
    {
        return DB::transaction(function () use ($id) {
            $periksa = Periksa::with('detailPeriksaObat.obat')->findOrFail($id);

            if ($periksa->status_periksa !== 'bagian_obat') {
                return response()->json(['success' => false, 'message' => 'Status tidak valid.'], 400);
            }

            // Validate stock
            foreach ($periksa->detailPeriksaObat as $detail) {
                if ($detail->obat->stok < $detail->jumlah) {
                    return response()->json([
                        'success' => false,
                        'message' => "Stok obat '{$detail->obat->nama_obat}' tidak mencukupi (Tersedia: {$detail->obat->stok})."
                    ], 422);
                }
            }

            // Decrease stock
            foreach ($periksa->detailPeriksaObat as $detail) {
                $detail->obat->decrement('stok', $detail->jumlah);
            }

            // Update status
            $periksa->update(['status_periksa' => 'selesai']);

            return response()->json([
                'success' => true,
                'message' => 'Layanan farmasi selesai. Stok telah diperbarui.'
            ]);
        });
    }
}
