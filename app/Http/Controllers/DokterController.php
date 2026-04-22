<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Poli;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DokterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dokters = Dokter::with(['user', 'poli'])->latest()->paginate(10);
        $polis = Poli::all();
        return view('admin.dokter', compact('dokters', 'polis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'id_poli' => 'required|exists:poli,id',
            'username' => 'required|string|unique:users,username|max:255',
            'password' => 'required|string|min:6',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:50',
            'no_ktp' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $user = User::create([
                'username' => $request->username,
                'email' => $request->username . '@poli.app',
                'password' => Hash::make($request->password),
                'role' => 'dokter',
            ]);

            Dokter::create([
                'id_user' => $user->id,
                'id_poli' => $request->id_poli,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'no_ktp' => $request->no_ktp,
                'added_by' => Auth::id(),
            ]);

            DB::commit();

            if ($request->ajax()) {
                $dokters = Dokter::with(['user', 'poli'])->latest()->paginate(10);
                $polis = Poli::all();
                $html = view('admin.dokter-table', compact('dokters', 'polis'))->render();
                return response()->json([
                    'success' => true,
                    'message' => 'Dokter created successfully!',
                    'html' => $html
                ]);
            }

            return redirect()->route('admin.dokter')->with('success', 'Dokter created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dokter = Dokter::findOrFail($id);
        $user = User::findOrFail($dokter->id_user);

        $request->validate([
            'nama' => 'required|string|max:255',
            'id_poli' => 'required|exists:poli,id',
            'username' => 'required|string|unique:users,username,' . $user->id . '|max:255',
            'password' => 'nullable|string|min:6',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:50',
            'no_ktp' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $userData = ['username' => $request->username];
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            $user->update($userData);

            $dokter->update([
                'nama' => $request->nama,
                'id_poli' => $request->id_poli,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'no_ktp' => $request->no_ktp,
                'edited_by' => Auth::id(),
            ]);

            DB::commit();

            if ($request->ajax()) {
                $dokters = Dokter::with(['user', 'poli'])->latest()->paginate(10);
                $polis = Poli::all();
                $html = view('admin.dokter-table', compact('dokters', 'polis'))->render();
                return response()->json([
                    'success' => true,
                    'message' => 'Dokter updated successfully!',
                    'html' => $html
                ]);
            }

            return redirect()->route('admin.dokter')->with('success', 'Dokter updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $dokter = Dokter::findOrFail($id);
        $user = User::find($dokter->id_user);

        try {
            DB::beginTransaction();
            $dokter->delete();
            if ($user) $user->delete();
            DB::commit();

            if ($request->ajax()) {
                $dokters = Dokter::with(['user', 'poli'])->latest()->paginate(10);
                $polis = Poli::all();
                $html = view('admin.dokter-table', compact('dokters', 'polis'))->render();
                return response()->json([
                    'success' => true,
                    'message' => 'Dokter deleted successfully!',
                    'html' => $html
                ]);
            }

            return redirect()->route('admin.dokter')->with('success', 'Dokter deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
