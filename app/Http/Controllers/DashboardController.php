<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use App\Models\Borrow;

class DashboardController extends Controller
{
    // Ini fungsi untuk dashboard user biasa
    public function index()
    {
        // 1. Ambil data user yang sedang login
        $user = \Illuminate\Support\Facades\Auth::user();

        // 2. JEMBATAN OTOMATIS: Cek kalau dia Admin, langsung oper ke fungsi adminIndex()
        if ($user->role === 'admin') {
            return $this->adminIndex();
        }

        // ===================================================================
        // LOGIKA DASHBOARD USER BIASA
        // ===================================================================
        
        // Sesuai dengan database lo, statusnya pakai huruf kecil semua ('dipinjam')
        $activeBorrows = \App\Models\Borrow::where('user_id', $user->id)
                        ->whereIn('status', ['dipinjam', 'Dipinjam', 'DIPINJAM']) 
                        ->get();

        // Logika Hitung Denda Real-Time
        $hariIni = \Carbon\Carbon::today()->format('Y-m-d'); 
        $tarifDendaPerHari = 1000; 
        $totalDendaUser = 0;

        foreach ($activeBorrows as $borrow) {
            $dateRaw = $borrow->getRawOriginal('return_date') ?? $borrow->return_date;

            if ($dateRaw) {
                $stringTanggal = substr((string)$dateRaw, 0, 10);
                
                if ($hariIni > $stringTanggal) {
                    $dueDate = \Carbon\Carbon::parse($stringTanggal)->startOfDay();
                    $now = \Carbon\Carbon::today();
                    
                    $hariTerlambat = $now->diffInDays($dueDate);
                    $totalDendaUser += ($hariTerlambat * $tarifDendaPerHari);
                }
            }
        }

        // Hitung jumlah untuk widget info buku
        $jumlahPinjam = $activeBorrows->count();
        $limitBuku = 5; 
        
        // 🔥 PENYELARASAN VARIABEL: Buat variabel $activeBorrowCount agar seragam dengan view/katalog
        $activeBorrowCount = $jumlahPinjam;

        // Hitung persentase bar profil
        $persentase = $limitBuku > 0 ? ($jumlahPinjam / $limitBuku) * 100 : 0;

        // Tampilkan view dashboard user biasa (Kirim variabel activeBorrowCount ke blade)
        return view('user.user_dashboard', compact('jumlahPinjam', 'limitBuku', 'persentase', 'totalDendaUser', 'activeBorrowCount'));
    }

    // Fungsi untuk dashboard Admin
    public function adminIndex()
    {
        // 1. Ambil data statistik dari database
        $totalBuku = Book::count();
        $totalUser = User::where('role', '!=', 'admin')->count(); // Biar akun admin gak kehitung jadi member
        
        // Sesuaikan dengan variabel yang diminta Blade (peminjamanAktif)
        $peminjamanAktif = Borrow::whereIn('status', ['dipinjam', 'Dipinjam', 'DIPINJAM'])->count();
        
        // Ambil total denda yang masuk
        $totalDendaMasuk = Borrow::sum('denda');

        // 2. Ambil data log transaksi untuk mengisi tabel global di bagian bawah dashboard
        $allBorrows = Borrow::with(['user', 'book'])
            ->latest()
            ->paginate(10);

        // 3. Masukkan SEMUA variabel ke dalam compact agar diterima oleh file Blade
        return view('admin.dashboard', compact(
            'totalBuku', 
            'totalUser', 
            'peminjamanAktif', 
            'totalDendaMasuk', 
            'allBorrows'
        ));
    }
}