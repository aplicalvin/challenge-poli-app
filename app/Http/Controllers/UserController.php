<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,dokter,pasien,apoteker,kasir',
        ]);

        User::create([
            'username' => $request->username,
            'email' => $request->username . '@poli.app',
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

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
