<?php

use App\Http\Controllers\BorrowController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController; // 1. SUDAH DI-IMPORT BIAR GAK ERROR NYARI CLASS
use App\Models\User;
use Illuminate\Support\Facades\Route;

// --- GUEST: Hanya bisa diakses jika BELUM login ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [CustomAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [CustomAuthController::class, 'login'])->name('login.post');
    Route::get('/register', [CustomAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [CustomAuthController::class, 'register'])->name('register.store');
});

// --- AUTH: Hanya bisa diakses jika SUDAH login ---
Route::middleware('auth')->group(function () {

    // Ganti URL-nya saja, name-nya biarin tetap 'books.show'
    Route::get('/detail-buku/{id}', [BookController::class, 'show'])->name('user.books.show');
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
    Route::get('/profile', [UserController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [UserController::class, 'updateProfile'])->name('profile.update');


    // Rute Katalog untuk User 
    Route::get('/', [BookController::class, 'welcome'])->name('welcome');
    Route::get('/catalog', [BookController::class, 'catalog'])->name('catalog');

    Route::post('/borrow/return/{id}', [BorrowController::class, 'returnBook'])->name('borrow.return');
    
    // 4. --- KHUSUS ADMIN ---
    Route::middleware(['admin'])->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'adminIndex'])->name('admin.dashboard');
        
        // PENTING: Rute spesifik 'tambah' harus di atas resource
        Route::get('/books/tambah', [BookController::class, 'create'])->name('books.create');
        Route::resource('books', BookController::class)->except(['create', 'show']);
        
        // MANAJEMEN USER: Dialihkan dengan benar ke UserController (Anti-Dempet & Sesuai Desain Baru)
        Route::get('/admin/users', [UserController::class, 'index'])->name('users.index');
        Route::resource('users', UserController::class)->except(['index']);
        
        // MANAJEMEN SIRKULASI
        Route::get('/admin/borrows', [BorrowController::class, 'index'])->name('borrows.index');
    });

    // 5. Rute yang pakai parameter {id} TARUH DI PALING BAWAH
    Route::post('/borrow/{id}', [BorrowController::class, 'store'])->name('borrow.store');
    Route::get('/riwayat', [BorrowController::class, 'history'])->name('riwayat');
    
    Route::post('/logout', [CustomAuthController::class, 'logout'])->name('logout');
});