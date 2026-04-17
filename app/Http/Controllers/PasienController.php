<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pasiens = Pasien::with('user')->latest()->paginate(10);
        return view('admin.pasien', compact('pasiens'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username|max:255',
            'password' => 'required|string|min:6',
            'no_ktp' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Create User
            $user = User::create([
                'username' => $request->username,
                'email' => $request->username . '@poli.app',
                'password' => Hash::make($request->password),
                'role' => 'pasien',
            ]);

            // Generate No RM (YYYYMM-XXX)
            $date = date('Ym');
            $count = Pasien::where('no_rm', 'like', $date . '-%')->count() + 1;
            $no_rm = $date . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);

            Pasien::create([
                'id_user' => $user->id,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'no_ktp' => $request->no_ktp,
                'no_hp' => $request->no_hp,
                'no_rm' => $no_rm,
                'added_by' => Auth::id(),
            ]);

            DB::commit();

            if ($request->ajax()) {
                $pasiens = Pasien::with('user')->latest()->paginate(10);
                $html = view('admin.pasien-table', compact('pasiens'))->render();
                return response()->json([
                    'success' => true,
                    'message' => 'Pasien created successfully! RM: ' . $no_rm,
                    'html' => $html
                ]);
            }

            return redirect()->route('admin.pasien')->with('success', 'Pasien created successfully!');
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
        $pasien = Pasien::findOrFail($id);
        $user = User::findOrFail($pasien->id_user);

        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username,' . $user->id . '|max:255',
            'password' => 'nullable|string|min:6',
            'no_ktp' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $userData = ['username' => $request->username];
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            $user->update($userData);

            $pasien->update([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'no_ktp' => $request->no_ktp,
                'no_hp' => $request->no_hp,
                'edited_by' => Auth::id(),
            ]);

            DB::commit();

            if ($request->ajax()) {
                $pasiens = Pasien::with('user')->latest()->paginate(10);
                $html = view('admin.pasien-table', compact('pasiens'))->render();
                return response()->json([
                    'success' => true,
                    'message' => 'Pasien updated successfully!',
                    'html' => $html
                ]);
            }

            return redirect()->route('admin.pasien')->with('success', 'Pasien updated successfully!');
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
        $pasien = Pasien::findOrFail($id);
        $user = User::find($pasien->id_user);

        try {
            DB::beginTransaction();
            $pasien->delete();
            if ($user) $user->delete();
            DB::commit();

            if ($request->ajax()) {
                $pasiens = Pasien::with('user')->latest()->paginate(10);
                $html = view('admin.pasien-table', compact('pasiens'))->render();
                return response()->json([
                    'success' => true,
                    'message' => 'Pasien deleted successfully!',
                    'html' => $html
                ]);
            }

            return redirect()->route('admin.pasien')->with('success', 'Pasien deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
