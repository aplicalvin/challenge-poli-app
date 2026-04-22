<?php
namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index()
    {
        $obats = Obat::latest()->paginate(10);
        return view('obat.list', compact('obats'));
    }

    public function stok()
    {
        $obats = Obat::latest()->paginate(10);
        return view('obat.stok', compact('obats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:50',
            'kemasan' => 'required|string|max:35',
            'harga' => 'required|integer|min:0',
            'stok' => 'nullable|integer|min:0',
        ]);

        Obat::create([
            'nama_obat' => $request->nama_obat,
            'kemasan' => $request->kemasan,
            'harga' => $request->harga,
            'stok' => $request->stok ?? 0,
            'added_by' => auth()->id(),
        ]);

        $obats = Obat::latest()->paginate(10);
        
        // Decide which table to return based on the referer or a custom flag
        $view = $request->input('view_type') === 'stok' ? 'obat.stok-table' : 'obat.obat-table';
        $html = view($view, compact('obats'))->render();

        return response()->json([
            'success' => true,
            'message' => 'Obat berhasil ditambahkan',
            'html' => $html
        ]);
    }

    public function update(Request $request, Obat $obat)
    {
        $request->validate([
            'nama_obat' => 'sometimes|required|string|max:50',
            'kemasan' => 'sometimes|required|string|max:35',
            'harga' => 'sometimes|required|integer|min:0',
            'stok' => 'sometimes|required|integer|min:0',
        ]);

        $obat->update([
            'nama_obat' => $request->nama_obat ?? $obat->nama_obat,
            'kemasan' => $request->kemasan ?? $obat->kemasan,
            'harga' => $request->harga ?? $obat->harga,
            'stok' => $request->stok ?? $obat->stok,
            'edited_by' => auth()->id(),
        ]);

        $obats = Obat::latest()->paginate(10);
        $view = $request->input('view_type') === 'stok' ? 'obat.stok-table' : 'obat.obat-table';
        $html = view($view, compact('obats'))->render();

        return response()->json([
            'success' => true,
            'message' => 'Data obat berhasil diperbarui',
            'html' => $html
        ]);
    }

    public function destroy(Obat $obat)
    {
        $obat->delete();

        $obats = Obat::latest()->paginate(10);
        // Default to list view for delete unless updated frequently via stok view
        $html = view('obat.obat-table', compact('obats'))->render();

        return response()->json([
            'success' => true,
            'message' => 'Obat berhasil dihapus',
            'html' => $html
        ]);
    }
}
