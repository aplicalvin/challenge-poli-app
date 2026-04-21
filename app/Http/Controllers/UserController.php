<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Staff;
use App\Models\Dokter;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->with(['dokter', 'pasien', 'staff'])->latest()->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'html' => view('admin.users-table', compact('users'))->render()
            ]);
        }

        return view('admin.users', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'nullable|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,dokter,pasien,apoteker,kasir',
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->username . '@poli.app',
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Synchronize Profile
        $name = $request->nama ?? $request->username;
        if (in_array($user->role, ['kasir', 'apoteker'])) {
            Staff::create([
                'id_user' => $user->id,
                'nama' => $name,
            ]);
        } elseif ($user->role === 'dokter') {
            // Note: Dokter creation via generic page might default to Poli 1 if exists, 
            // but usually doctors should be created via Dokter Management page.
            // For now, we just ensure the record exists if possible or skip if id_poli is missing.
        } elseif ($user->role === 'pasien') {
            Pasien::create([
                'id_user' => $user->id,
                'nama' => $name,
                'no_rm' => date('Ym') . '-' . sprintf('%03d', Pasien::count() + 1),
            ]);
        }

        $users = User::latest()->paginate(10);
        $html = view('admin.users-table', compact('users'))->render();

        return response()->json([
            'success' => true,
            'message' => 'Akun berhasil dibuat',
            'html' => $html
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'nama' => 'nullable|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role' => 'required|in:admin,dokter,pasien,apoteker,kasir',
            'password' => 'nullable|string|min:8',
        ]);

        $data = [
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        // Synchronize Profile
        if (in_array($user->role, ['kasir', 'apoteker'])) {
            Staff::updateOrCreate(
                ['id_user' => $user->id],
                ['nama' => $request->nama ?? $user->username]
            );
        } elseif ($user->role === 'pasien') {
            if (!Pasien::where('id_user', $user->id)->exists()) {
                Pasien::create([
                    'id_user' => $user->id,
                    'nama' => $request->nama ?? $user->username,
                    'no_rm' => date('Ym') . '-' . sprintf('%03d', Pasien::count() + 1),
                ]);
            } else {
                Pasien::where('id_user', $user->id)->update([
                    'nama' => $request->nama ?? $user->username
                ]);
            }
        }

        $users = User::latest()->paginate(10);
        $html = view('admin.users-table', compact('users'))->render();

        return response()->json([
            'success' => true,
            'message' => 'Akun berhasil diperbarui',
            'html' => $html
        ]);
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.'
            ], 403);
        }

        $user->delete();

        $users = User::latest()->paginate(10);
        $html = view('admin.users-table', compact('users'))->render();

        return response()->json([
            'success' => true,
            'message' => 'Akun berhasil dihapus',
            'html' => $html
        ]);
    }
}
