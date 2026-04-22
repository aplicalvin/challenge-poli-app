<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatPembayaranPasienController extends Controller
{
    public function index(Request $request)
    {
        $pasien = Auth::user()->pasien;
        if (!$pasien) {
            return redirect()->back()->with('error', 'Data pasien tidak ditemukan.');
        }

        $query = Pembayaran::whereHas('periksa', function ($q) use ($pasien) {
            $q->where('id_pasien', $pasien->id);
        })->with(['periksa'])->orderBy('created_at', 'desc');

        // Filters
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        if ($request->filled('status')) {
            $query->where('status_pembayaran', $request->status);
        }

        $pembayaran = $query->get();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'html' => view('patient.payment.table', compact('pembayaran'))->render()
            ]);
        }

        return view('patient.payment.history', compact('pembayaran'));
    }
}
