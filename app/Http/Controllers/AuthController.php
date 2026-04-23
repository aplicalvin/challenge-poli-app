<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            return $this->redirectUser(auth()->user());
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }

    public function showSignup()
    {
        return view('auth.signup');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:6'],
            'nama' => ['required', 'string', 'max:255'],
            'no_ktp' => ['required', 'string', 'max:20'],
            'no_hp' => ['required', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pasien', // Registrations are only for patients
        ]);

        // Create Pasien profile immediately
        $year = date('Y');
        $month = date('m');
        $prefix = "RM/$year/$month/";
        $count = \App\Models\Pasien::where('no_rm', 'like', $prefix . '%')->count() + 1;
        $no_rm = $prefix . str_pad($count, 3, '0', STR_PAD_LEFT);

        \App\Models\Pasien::create([
            'id_user' => $user->id,
            'nama' => $request->nama,
            'no_ktp' => $request->no_ktp,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat ?? '',
            'no_rm' => $no_rm,
            'added_by' => null,
        ]);

        Auth::login($user);

        return $this->redirectUser($user);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    protected function redirectUser($user)
    {
        return match ($user->role) {
            'admin' => redirect()->intended('/admin/dashboard'),
            'dokter' => redirect()->intended('/doctor'),
            'pasien' => redirect()->intended('/patient'),
            'apoteker' => redirect()->intended('/pharmacist'),
            'kasir' => redirect()->intended('/cashier'),
            default => redirect('/'),
        };
    }
}
