<?php
namespace App\Http\Controllers;

use App\Models\JadwalJaga;
use App\Models\Shift;
use App\Models\Dokter;
use App\Models\Ruang;
use Illuminate\Http\Request;

class JadwalJagaController extends Controller
{
    private function authorizeAdmin()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Hanya Admin yang diperbolehkan mengolah data jadwal.');
        }
    }

    public function index()
    {
        $jadwals = JadwalJaga::with(['shift', 'dokter', 'ruang.poli'])->latest()->paginate(10);
        $shifts = Shift::all();
        $dokters = Dokter::all();
        $ruangs = Ruang::with('poli')->get();
        
        return view('penjadwalan.jadwal', compact('jadwals', 'shifts', 'dokters', 'ruangs'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();
        $request->validate([
            'id_shift' => 'required|exists:shift,id',
            'id_dokter' => 'required|exists:dokter,id',
            'id_ruang' => 'required|exists:ruang,id',
        ]);

        JadwalJaga::create($request->all());

        $jadwals = JadwalJaga::with(['shift', 'dokter', 'ruang.poli'])->latest()->paginate(10);
        $html = view('penjadwalan.jadwal-table', compact('jadwals'))->render();

        return response()->json([
            'success' => true,
            'message' => 'Jadwal Jaga berhasil ditambahkan',
            'html' => $html
        ]);
    }

    public function update(Request $request, JadwalJaga $jadwal)
    {
        $this->authorizeAdmin();
        $request->validate([
            'id_shift' => 'required|exists:shift,id',
            'id_dokter' => 'required|exists:dokter,id',
            'id_ruang' => 'required|exists:ruang,id',
        ]);

        $jadwal->update($request->all());

        $jadwals = JadwalJaga::with(['shift', 'dokter', 'ruang.poli'])->latest()->paginate(10);
        $html = view('penjadwalan.jadwal-table', compact('jadwals'))->render();

        return response()->json([
            'success' => true,
            'message' => 'Jadwal Jaga berhasil diperbarui',
            'html' => $html
        ]);
    }

    public function destroy(JadwalJaga $jadwal)
    {
        $this->authorizeAdmin();
        $jadwal->delete();

        $jadwals = JadwalJaga::with(['shift', 'dokter', 'ruang.poli'])->latest()->paginate(10);
        $html = view('penjadwalan.jadwal-table', compact('jadwals'))->render();

        return response()->json([
            'success' => true,
            'message' => 'Jadwal Jaga berhasil dihapus',
            'html' => $html
        ]);
    }
}
