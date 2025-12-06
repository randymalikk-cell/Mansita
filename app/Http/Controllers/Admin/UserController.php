<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Otorisasi: Hanya Admin yang dapat mengakses (Use Case 6)
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'admin') {
                abort(403, 'Akses hanya untuk Administrator.');
            }
            return $next($request);
        });
    }

    /**
     * Menampilkan daftar pengguna.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Filter role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter search (opsional)
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                ->orWhere('username', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Menampilkan form pembuatan pengguna baru.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Menyimpan pengguna baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|unique:users|max:255',
            'email' => 'nullable|email|unique:users|max:255',
            'role' => ['required', Rule::in(['admin', 'staf produksi', 'pengurus'])],
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'nama' => $validated['nama'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => Hash::make($validated['password']),
        ]);
        
        \App\Models\LogAktivitas::create(['user_id' => auth()->id(), 'aktivitas' => 'Menambah pengguna baru: ' . $validated['username']]);

        return redirect()->route('admin.users.index')->with('success', 'Akun pengguna berhasil dibuat.');
    }

    /**
     * Menampilkan form edit pengguna.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Memperbarui data pengguna.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', Rule::in(['admin', 'staf produksi', 'pengurus'])],
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->update([
            'nama' => $validated['nama'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        \App\Models\LogAktivitas::create(['user_id' => auth()->id(), 'aktivitas' => 'Memperbarui data pengguna: ' . $user->username]);

        return redirect()->route('admin.users.index')->with('success', 'Akun pengguna berhasil diperbarui.');
    }

    /**
     * Menghapus pengguna (Menonaktifkan).
     */
    public function destroy(User $user)
    {
        // Pencegahan agar Admin tidak menghapus akun sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $username = $user->username;
        $user->delete();

        \App\Models\LogAktivitas::create(['user_id' => auth()->id(), 'aktivitas' => 'Menghapus/menonaktifkan pengguna: ' . $username]);
        
        return redirect()->route('admin.users.index')->with('success', 'Akun pengguna berhasil dinonaktifkan.');
    }
}