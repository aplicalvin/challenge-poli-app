<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PoliController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $polis = Poli::latest()->paginate(10);
        return view('admin.poli', compact('polis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_poli' => 'required|max:25',
            'keterangan' => 'nullable|string',
        ]);

        $validated['added_by'] = Auth::id();

        Poli::create($validated);

        if ($request->ajax()) {
            $polis = Poli::latest()->paginate(10);
            $html = view('admin.poli-table', compact('polis'))->render();
            return response()->json([
                'success' => true,
                'message' => 'Poli created successfully!',
                'html' => $html
            ]);
        }

        return redirect()->route('admin.poli')->with('success', 'Poli created successfully!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $poli = Poli::findOrFail($id);

        $validated = $request->validate([
            'nama_poli' => 'required|max:25',
            'keterangan' => 'nullable|string',
        ]);

        $validated['edited_by'] = Auth::id();

        $poli->update($validated);

        if ($request->ajax()) {
            $polis = Poli::latest()->paginate(10);
            $html = view('admin.poli-table', compact('polis'))->render();
            return response()->json([
                'success' => true,
                'message' => 'Poli updated successfully!',
                'html' => $html
            ]);
        }

        return redirect()->route('admin.poli')->with('success', 'Poli updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $poli = Poli::findOrFail($id);
        $poli->delete();

        if ($request->ajax()) {
            $polis = Poli::latest()->paginate(10);
            $html = view('admin.poli-table', compact('polis'))->render();
            return response()->json([
                'success' => true,
                'message' => 'Poli deleted successfully!',
                'html' => $html
            ]);
        }

        return redirect()->route('admin.poli')->with('success', 'Poli deleted successfully!');
    }
}
