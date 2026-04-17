<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staffs = Staff::with('user')->latest()->paginate(10);
        return view('admin.staff', compact('staffs'));
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
            'role' => 'required|in:kasir,apoteker',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:50',
        ]);

        try {
            DB::beginTransaction();

            $user = User::create([
                'username' => $request->username,
                'email' => $request->username . '@poli.app',
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            Staff::create([
                'id_user' => $user->id,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'added_by' => Auth::id(),
            ]);

            DB::commit();

            if ($request->ajax()) {
                $staffs = Staff::with('user')->latest()->paginate(10);
                $html = view('admin.staff-table', compact('staffs'))->render();
                return response()->json([
                    'success' => true,
                    'message' => 'Staff created successfully!',
                    'html' => $html
                ]);
            }

            return redirect()->route('admin.staff')->with('success', 'Staff created successfully!');
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
        $staff = Staff::findOrFail($id);
        $user = User::findOrFail($staff->id_user);

        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username,' . $user->id . '|max:255',
            'role' => 'required|in:kasir,apoteker',
            'password' => 'nullable|string|min:6',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:50',
        ]);

        try {
            DB::beginTransaction();

            $userData = [
                'username' => $request->username,
                'role' => $request->role,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            $staff->update([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'edited_by' => Auth::id(),
            ]);

            DB::commit();

            if ($request->ajax()) {
                $staffs = Staff::with('user')->latest()->paginate(10);
                $html = view('admin.staff-table', compact('staffs'))->render();
                return response()->json([
                    'success' => true,
                    'message' => 'Staff updated successfully!',
                    'html' => $html
                ]);
            }

            return redirect()->route('admin.staff')->with('success', 'Staff updated successfully!');
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
        $staff = Staff::findOrFail($id);
        $user = User::find($staff->id_user);

        try {
            DB::beginTransaction();
            $staff->delete();
            if ($user) $user->delete();
            DB::commit();

            if ($request->ajax()) {
                $staffs = Staff::with('user')->latest()->paginate(10);
                $html = view('admin.staff-table', compact('staffs'))->render();
                return response()->json([
                    'success' => true,
                    'message' => 'Staff deleted successfully!',
                    'html' => $html
                ]);
            }

            return redirect()->route('admin.staff')->with('success', 'Staff deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
