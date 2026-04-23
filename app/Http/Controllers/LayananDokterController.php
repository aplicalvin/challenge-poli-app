<?php

namespace App\Http\Controllers;

use App\Models\Periksa;
use App\Models\DetailPeriksaObat;
use App\Models\Obat;
use App\Models\JadwalJaga;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LayananDokterController extends Controller
{
    public function index()
    {
        $dokter = auth()->user()->dokter;
        if (!$dokter) {
             return redirect()->route('doctor.dashboard')->with('error', 'Data dokter tidak ditemukan.');
        }

        $now = Carbon::now();
        $today = $now->locale('id')->dayName;
        $currentTime = $now->format('H:i:s');

        // Find active schedule for this doctor right now
        $activeSchedule = JadwalJaga::where('id_dokter', $dokter->id)
            ->whereHas('shift', function ($q) use ($today, $currentTime) {
                $q->where('hari', $today)
                  ->where('jam_masuk', '<=', $currentTime)
                  ->where('jam_keluar', '>=', $currentTime);
            })
            ->first();

        $antrian = [];
        if ($activeSchedule) {
            $antrian = Periksa::where('id_jadwal_jaga', $activeSchedule->id)
                ->whereIn('status_periksa', ['antri', 'sedang_periksa']) // Include ongoing to show progress
                ->whereDate('tgl_periksa', Carbon::today())
                ->with('pasien')
                ->orderBy('no_antrian', 'asc')
                ->get();
        }

        return view('doctor.queue.index', compact('antrian', 'activeSchedule'));
    }

    public function startExamine($id)
    {
        $periksa = Periksa::findOrFail($id);
        
        // Update status to sedang_periksa
        $periksa->update([
            'status_periksa' => 'sedang_periksa',
            'tgl_periksa' => Carbon::now()
        ]);

        return redirect()->route('doctor.queue.examine', $id);
    }

    public function examine($id)
    {
        $periksa = Periksa::with('pasien', 'jadwalJaga.ruang.poli')->findOrFail($id);
        $obats = Obat::all();

        return view('doctor.queue.examine', compact('periksa', 'obats'));
    }

    public function finishExamine(Request $request, $id)
    {
        $request->validate([
            'nama_penyakit' => 'required|string',
            'catatan' => 'required|string',
            'obats' => 'required|array',
            'obats.*.id' => 'required|exists:obat,id',
            'obats.*.jumlah' => 'required|integer|min:1',
        ]);

        $periksa = Periksa::findOrFail($id);

        DB::beginTransaction();
        try {
            $totalBiaya = 0;
            
            // Aggregated Medicine Quantities from form
            $requestedTotals = [];
            foreach ($request->obats as $item) {
                $requestedTotals[$item['id']] = ($requestedTotals[$item['id']] ?? 0) + $item['jumlah'];
            }

            // Backend Stock Validation
            foreach ($requestedTotals as $id => $totalRequested) {
                $obat = Obat::find($id);
                
                // Calculate pending quantity (same as ObatController@checkAvailableStock)
                $pendingQuantity = \App\Models\DetailPeriksaObat::where('id_obat', $obat->id)
                    ->whereHas('periksa', function ($query) {
                        $query->whereIn('status_periksa', ['menunggu_pembayaran', 'bagian_obat', 'sedang_periksa']);
                    })
                    ->sum('jumlah');
                
                $available = $obat->stok - $pendingQuantity;
                
                if ($totalRequested > $available) {
                    throw new \Exception("Total permintaan obat '{$obat->nama_obat}' tidak mencukupi. Tersedia: {$available}");
                }
            }

            foreach ($request->obats as $item) {
                $obat = Obat::find($item['id']);
                $subtotal = $obat->harga * $item['jumlah'];
                $totalBiaya += $subtotal;

                DetailPeriksaObat::create([
                    'id_periksa' => $periksa->id,
                    'id_obat' => $obat->id,
                    'jumlah' => $item['jumlah'],
                    'harga_saat_ini' => $obat->harga,
                    'added_by' => auth()->id(),
                ]);
            }

            $periksa->update([
                'nama_penyakit' => $request->nama_penyakit,
                'catatan' => $request->catatan,
                'biaya_periksa' => $totalBiaya,
                'status_periksa' => 'menunggu_pembayaran',
                'edited_by' => auth()->id(),
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Pemeriksaan selesai.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
}
