<?php
namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    public function index()
    {
        $shifts = Shift::latest()->paginate(10);
        return view('penjadwalan.shift', compact('shifts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:50',
            'jam_masuk' => 'required',
            'jam_keluar' => 'required',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
        ]);

        $shift = Shift::create([
            'nama' => $request->nama,
            'jam_masuk' => $request->jam_masuk,
            'jam_keluar' => $request->jam_keluar,
            'hari' => $request->hari,
        ]);

        $shifts = Shift::latest()->paginate(10);
        $html = view('penjadwalan.shift-table', compact('shifts'))->render();

        return response()->json([
            'success' => true,
            'message' => 'Shift berhasil ditambahkan',
            'html' => $html
        ]);
    }

    public function update(Request $request, Shift $shift)
    {
        $request->validate([
            'nama' => 'required|string|max:50',
            'jam_masuk' => 'required',
            'jam_keluar' => 'required',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
        ]);

        $shift->update([
            'nama' => $request->nama,
            'jam_masuk' => $request->jam_masuk,
            'jam_keluar' => $request->jam_keluar,
            'hari' => $request->hari,
        ]);

        $shifts = Shift::latest()->paginate(10);
        $html = view('penjadwalan.shift-table', compact('shifts'))->render();

        return response()->json([
            'success' => true,
            'message' => 'Shift berhasil diperbarui',
            'html' => $html
        ]);
    }

    public function destroy(Shift $shift)
    {
        $shift->delete();

        $shifts = Shift::latest()->paginate(10);
        $html = view('penjadwalan.shift-table', compact('shifts'))->render();

        return response()->json([
            'success' => true,
            'message' => 'Shift berhasil dihapus',
            'html' => $html
        ]);
    }
}
