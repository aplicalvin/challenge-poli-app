<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Periksa;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanKeuanganController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembayaran::where('status_pembayaran', 'lunas')
            ->with(['periksa.pasien', 'verifier'])
            ->orderBy('tgl_bayar', 'desc');

        // Filter by Date Range
        if ($request->filled('start_date')) {
            $query->whereDate('tgl_bayar', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('tgl_bayar', '<=', $request->end_date);
        }

        $laporan = $query->get();

        // Summary Stats
        $today = Carbon::today();
        $thisWeek = [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()];
        $thisMonth = Carbon::now()->month;

        $stats = [
            'today' => Pembayaran::where('status_pembayaran', 'lunas')->whereDate('tgl_bayar', $today)->sum('total_bayar'),
            'week' => Pembayaran::where('status_pembayaran', 'lunas')->whereBetween('tgl_bayar', $thisWeek)->sum('total_bayar'),
            'month' => Pembayaran::where('status_pembayaran', 'lunas')->whereMonth('tgl_bayar', $thisMonth)->whereYear('tgl_bayar', Carbon::now()->year)->sum('total_bayar'),
        ];

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'html' => view('keuangan.laporan_table', compact('laporan'))->render()
            ]);
        }

        return view('keuangan.laporan', compact('laporan', 'stats'));
    }

    public function exportCsv(Request $request)
    {
        $query = Pembayaran::where('status_pembayaran', 'lunas')
            ->with(['periksa.pasien', 'verifier'])
            ->orderBy('tgl_bayar', 'desc');

        if ($request->filled('start_date')) {
            $query->whereDate('tgl_bayar', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('tgl_bayar', '<=', $request->end_date);
        }

        $data = $query->get();
        $csvFileName = 'laporan_keuangan_' . date('Ymd_His') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Tanggal Bayar', 'Nama Pasien', 'Total Pembayaran', 'Diverifikasi Oleh'];

        $callback = function() use($data, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($data as $item) {
                fputcsv($file, [
                    $item->tgl_bayar,
                    $item->periksa->pasien->nama,
                    $item->total_bayar,
                    $item->verifier->username ?? '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
