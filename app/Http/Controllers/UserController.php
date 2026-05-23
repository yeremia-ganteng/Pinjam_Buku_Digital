<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Borrow; // Tambahkan ini
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse; // Tambahkan ini
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfileUpdateRequest; // Pastikan ini ada

class UserController extends Controller
{
    // ==========================================
    // 1. FITUR PROFIL (User Login)
    // ==========================================
    public function edit(Request $request) 
    {
        $user = $request->user();
        
        $lateBorrows = Borrow::where('user_id', $user->id)
            ->where('status', 'dipinjam')
            ->where('due_date', '<', now())
            ->with('book')
            ->get();

        return view('profile.edit', compact('user', 'lateBorrows'));
    }

    // Method khusus update profil user
    public function updateProfile(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    // ==========================================
    // 2. MANAJEMEN ADMIN (CRUD User)
    // ==========================================
    public function index() {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,user',
        ]);
        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);
        return redirect()->route('users.index')->with('success', 'Anggota berhasil ditambahkan!');
    }

    // Ganti nama method menjadi updateAdmin agar tidak bentrok dengan updateProfile
    public function updateAdmin(Request $request, User $user) {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|in:admin,user',
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8']);
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);
        return redirect()->route('users.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy(User $user) {
        if ($user->id === Auth::id()) return back()->with('error', 'Tidak bisa hapus diri sendiri!');
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Anggota berhasil dihapus!');
    }
}