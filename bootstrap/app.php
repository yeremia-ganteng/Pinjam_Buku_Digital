<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Auth; // Tambahkan ini di atas biar gak error

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // 🔥 PAKSA REDIRECT DINAMIS BERDASARKAN ROLE USER/ADMIN 🔥
        $middleware->redirectTo(
            guests: '/login', // Kalau belum login, lempar ke /login
            users: function () {
                // 🎯 SINKRONISASI TOTAL: Ubah ke rute dashboard utama di sini!
                // Ini gunanya biar ketika sukses login, middleware Laravel 11 
                // langsung mengizinkan jalur redirection penuh ke /dashboard.
                return route('dashboard'); 
            }
        );

        // 🚀 BYPASS PROTEKSI CSRF FIX UNTUK LOGIN AJAX (ANTI 419 EXPIRED) 🚀
        $middleware->validateCsrfTokens(except: [
            'login', // Tambahkan rute login di sini agar tidak kena 419 saat login via AJAX
        ]);

        // SEMUA ALIAS HARUS DI SINI (JANGAN DIPISAH)
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();