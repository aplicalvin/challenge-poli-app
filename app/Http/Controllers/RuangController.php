<?php
namespace App\Http\Controllers;

use App\Models\Ruang;
use App\Models\Poli;
use Illuminate\Http\Request;

class RuangController extends Controller
{
    public function index()
    {
        $ruangs = Ruang::with('poli')->latest()->paginate(10);
        $polis = Poli::all();
        return view('penjadwalan.ruang', compact('ruangs', 'polis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:50',
            'id_poli' => 'required|exists:poli,id',
        ]);

        Ruang::create([
            'nama' => $request->nama,
            'id_poli' => $request->id_poli,
            'created_by' => auth()->id(),
        ]);

        $ruangs = Ruang::with('poli')->latest()->paginate(10);
        $html = view('penjadwalan.ruang-table', compact('ruangs'))->render();

        return response()->json([
            'success' => true,
            'message' => 'Ruang berhasil ditambahkan',
            'html' => $html
        ]);
    }

    public function update(Request $request, Ruang $ruang)
    {
        $request->validate([
            'nama' => 'required|string|max:50',
            'id_poli' => 'required|exists:poli,id',
        ]);

        $ruang->update([
            'nama' => $request->nama,
            'id_poli' => $request->id_poli,
            'edited_by' => auth()->id(),
        ]);

        $ruangs = Ruang::with('poli')->latest()->paginate(10);
        $html = view('penjadwalan.ruang-table', compact('ruangs'))->render();

        return response()->json([
            'success' => true,
            'message' => 'Ruang berhasil diperbarui',
            'html' => $html
        ]);
    }

    public function destroy(Ruang $ruang)
    {
        $ruang->delete();

        $ruangs = Ruang::with('poli')->latest()->paginate(10);
        $html = view('penjadwalan.ruang-table', compact('ruangs'))->render();

        return response()->json([
            'success' => true,
            'message' => 'Ruang berhasil dihapus',
            'html' => $html
        ]);
    }
}
