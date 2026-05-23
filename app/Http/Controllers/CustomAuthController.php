<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomAuthController extends Controller
{

    // 1. Tampilkan Halaman Register
    public function showRegister()
    {
        return view('auth.custom-register');
    }

    // 2. Proses Registrasi
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Set default role jadi user
        ]);

        Auth::login($user);

        return redirect('/dashboard')->with('success', 'Akun berhasil dibuat! Selamat datang.');
    }

    // 1. Tampilkan Halaman Login
    public function showLogin()
    {
        return view('auth.custom-login');
    }

    // 2. Proses Login
public function login(Request $request)
{
    // 1. Validasi
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    // 2. Coba Login
    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();
        $user = Auth::user();
        
        $redirectUrl = ($user->role === 'admin') ? '/admin/dashboard' : '/dashboard';

        // Jika request datang dari AJAX (fetch), kirim JSON
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'redirect' => $redirectUrl]);
        }

        return redirect()->intended($redirectUrl);
    }

    // 3. JIKA GAGAL
    // Jika request datang dari AJAX (fetch), kirim JSON Error 422
    if ($request->expectsJson() || $request->ajax()) {
        return response()->json([
            'message' => 'Email atau password yang kamu masukkan salah.'
        ], 422);
    }

    // Jika request biasa, tetap pakai back()
    return back()->withErrors([
        'email' => 'Email atau password yang kamu masukkan salah.',
    ])->onlyInput('email');
}

    // 3. Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}