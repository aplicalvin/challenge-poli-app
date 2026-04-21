<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = null;

        if ($user->role === 'dokter') {
            $profile = Dokter::where('id_user', $user->id)->first();
        } elseif ($user->role === 'pasien') {
            $profile = Pasien::where('id_user', $user->id)->first();
        } elseif (in_array($user->role, ['kasir', 'apoteker'])) {
            $profile = Staff::where('id_user', $user->id)->first();
        }

        return view('profile.index', compact('user', 'profile'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        // Normalize username: lowercase and replace spaces with underscore
        if ($request->has('username')) {
            $normalizedUsername = strtolower(str_replace(' ', '_', $request->username));
            $request->merge(['username' => $normalizedUsername]);
        }

        $rules = [
            'username' => [
                'required', 
                'string', 
                'max:255', 
                'unique:users,username,' . $user->id,
                'regex:/^[a-z0-9_]+$/' // No spaces, only lowercase alphanumeric and underscore
            ],
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
        ];

        // Add role-specific profile validation
        if ($user->role !== 'admin') {
            $rules['nama'] = 'required|string|max:255';
            $rules['alamat'] = 'nullable|string';
            $rules['no_hp'] = 'nullable|string|max:50';
        }

        if ($user->role === 'dokter' || $user->role === 'pasien') {
            $rules['no_ktp'] = 'nullable|string';
        }

        // Validate
        $request->validate($rules, [
            'username.regex' => 'Username tidak boleh mengandung spasi atau karakter khusus selain underscore.',
            'email.email' => 'Format email harus valid (contoh: nama@example.com).',
        ]);

        // Update User
        $user->username = $request->username;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        // Update Role-Specific Profile (using updateOrCreate for robustness)
        if ($user->role === 'dokter') {
            Dokter::updateOrCreate(
                ['id_user' => $user->id],
                [
                    'nama' => $request->nama,
                    'alamat' => $request->alamat,
                    'no_hp' => $request->no_hp,
                    'no_ktp' => $request->no_ktp,
                    'edited_by' => Auth::id(),
                ]
            );
        } elseif ($user->role === 'pasien') {
            Pasien::updateOrCreate(
                ['id_user' => $user->id],
                [
                    'nama' => $request->nama,
                    'alamat' => $request->alamat,
                    'no_hp' => $request->no_hp,
                    'no_ktp' => $request->no_ktp,
                ]
            );
        } elseif (in_array($user->role, ['kasir', 'apoteker'])) {
            Staff::updateOrCreate(
                ['id_user' => $user->id],
                [
                    'nama' => $request->nama,
                    'alamat' => $request->alamat,
                    'no_hp' => $request->no_hp,
                    'edited_by' => Auth::id(),
                ]
            );
        }

        // Fetch latest data for AJAX partial
        $user = Auth::user();
        $profile = null;
        if ($user->role === 'dokter') {
            $profile = Dokter::where('id_user', $user->id)->first();
        } elseif ($user->role === 'pasien') {
            $profile = Pasien::where('id_user', $user->id)->first();
        } elseif (in_array($user->role, ['kasir', 'apoteker'])) {
            $profile = Staff::where('id_user', $user->id)->first();
        }

        $html = view('profile.partials.details', compact('user', 'profile'))->render();

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui.',
            'html' => $html
        ]);
    }
}
