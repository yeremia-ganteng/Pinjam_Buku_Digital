<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // 1. Hitung total data untuk statistik
        $totalBuku = Book::count();
        $totalUser = User::where('role', '!=', 'admin')->count(); // Asumsi ada kolom role
        $peminjamanAktif = Borrow::whereIn('status', ['dipinjam', 'Dipinjam'])->count();
        
        // 2. Hitung total seluruh denda yang terkunci di database
        $totalDendaMasuk = Borrow::sum('denda');

        // 3. Ambil daftar peminjaman terbaru untuk ditampilkan di tabel admin
        $allBorrows = Borrow::with(['user', 'book'])
            ->latest()
            ->paginate(10); // Menampilkan 10 data per halaman

        return view('admin.dashboard', compact('totalBuku', 'totalUser', 'peminjamanAktif', 'totalDendaMasuk', 'allBorrows'));
    }
}