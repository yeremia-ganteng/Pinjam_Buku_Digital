<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        try {
            // 1. Eksekusi verifikasi kredensial (Email & Password) lewat Breeze/Laravel Core
            $request->authenticate();

            // 2. Amankan session jika data login valid
            $request->session()->regenerate();

            // 3. 🎯 LOGIKA TERPUSAT: Langsung arahkan ke rute dashboard utama lo
            $redirectUrl = route('dashboard');

            // 🚀 PROTEKSI INTERSEPSI AJAX (Kunci utama untuk hilangkan jeda putih visual)
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'redirect' => $redirectUrl
                ]);
            }

            // Fallback normal redirect jika javascript browser user mati
            return redirect()->intended($redirectUrl)->with('success', 'Selamat datang kembali, ' . Auth::user()->name . '!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            
            // 🚨 JIKA GAGAL LOGIN (Salah Email / Password) lewat Fetch API
            // Kembalikan response JSON 422 agar JavaScript menahan animasi keluar
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email atau password yang Anda masukkan salah.'
                ], 422);
            }

            // Fallback error standar bawaan Laravel jika diakses tanpa AJAX
            throw $e;
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}