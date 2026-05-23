<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\Book;
use Illuminate\Http\Request; // Tambahkan ini untuk menangkap data form
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BorrowController extends Controller
{

    public function index()
    {
        // Mengambil data peminjaman beserta data user dan data buku terkait
        // Gunakan get() jika tidak pakai halaman, atau paginate(10) jika mau pakai halaman
        $borrows = \App\Models\Borrow::with(['user', 'book'])->latest()->get();

        return view('admin.borrows.index', compact('borrows'));
    }


public function store(Request $request, $id) // Tambahkan parameter Request
    {
        // 1. Auth Guard
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if (Auth::user()->role === 'admin') {
            return back()->with('error', 'Akun Admin tidak diperbolehkan untuk meminjam buku!');
        }

        $book = Book::findOrFail($id);

        // 2. Cek ketersediaan buku secara strict (Gunakan lowercase check agar aman dari typo huruf besar/kecil)
        if (strtolower($book->status) !== 'tersedia' || $book->stock <= 0) {
            return back()->with('error', 'Maaf, buku ini sedang tidak tersedia atau stok habis.');
        }

        // 3. Cek Double Borrow Protection
        $isAlreadyBorrowed = Borrow::where('user_id', Auth::id())
            ->where('book_id', $id)
            ->where('status', 'Dipinjam')
            ->exists();

        if ($isAlreadyBorrowed) {
            return back()->with('error', 'Kamu masih meminjam buku ini.');
        }

        // 🔥 3.5. GERBANG VALIDASI LIMIT MAKSIMAL 5 BUKU 🔥
        // Menghitung jumlah buku yang sedang dipinjam oleh user aktif saat ini
        $currentBorrowedCount = Borrow::where('user_id', Auth::id())
            ->where('status', 'Dipinjam')
            ->count();

        if ($currentBorrowedCount >= 5) {
            return back()->with('error', 'Gagal! Kamu sudah mencapai batas maksimal peminjaman (5 buku). Kembalikan buku lain terlebih dahulu.');
        }

        // 4. Ambil durasi dari form (default ke 7 hari jika tidak ada input)
        $duration = (int) $request->input('duration', 7);

        // 5. Database Transaction
        try {
            $tanggalPinjam = now();
            $tanggalKembali = now()->addDays($duration); 

            DB::transaction(function () use ($book, $tanggalPinjam, $tanggalKembali) {
                
                // POTONG STOK BUKU OTOMATIS (Mengurangi 1 stok)
                $book->decrement('stock');

                // REFRESH DATA STOK TERBARU SETELAH DI-DECREMENT
                $book->refresh();

                // EVALUASI STATUS SECARA AMAN: Jika stok 0 atau kurang, status ganti 'Tidak Tersedia' / 'Dipinjam'
                // Menggunakan 'Tidak Tersedia' agar sinkron dengan BookController
                $newStatus = $book->stock > 0 ? 'Tersedia' : 'Tidak Tersedia';
                $book->update(['status' => $newStatus]);

                // Buat record peminjaman ke database
                Borrow::create([
                    'user_id'     => Auth::id(),
                    'book_id'     => $book->id,
                    'borrow_date' => $tanggalPinjam,
                    'return_date' => $tanggalKembali,
                    'status'      => 'Dipinjam'
                ]);
            });

            // Berhasil! Kirim nama buku dan tanggal kembali untuk notifikasi "Wow" kita
            return redirect()->route('riwayat')->with([
                'success' => $book->title,
                'due_date' => $tanggalKembali->format('d M Y') // Kirim format tanggal cantik
            ]);

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

public function returnBook($id)
    {
        // 1. Cari data peminjaman berdasarkan ID
        $borrow = Borrow::findOrFail($id);
        $book = Book::findOrFail($borrow->book_id);

        try {
            DB::transaction(function () use ($borrow, $book) {
                
                // Ambil string format tanggal murni (YYYY-MM-DD)
                $tglPinjam = \Carbon\Carbon::parse($borrow->borrow_date)->format('Y-m-d');
                $tglTempo = \Carbon\Carbon::parse($borrow->return_date)->format('Y-m-d');
                $tglHariIni = \Carbon\Carbon::today()->format('Y-m-d');
                
                // Set ke objek Carbon bersih
                $borrowDateObj = \Carbon\Carbon::createFromFormat('Y-m-d', $tglPinjam);
                $dueDateObj = \Carbon\Carbon::createFromFormat('Y-m-d', $tglTempo);
                $hariIni = \Carbon\Carbon::createFromFormat('Y-m-d', $tglHariIni);
                
                $dendaFinal = 0;
                
                // 2. KONDISI: Jika hari ini sudah melewati jatuh tempo -> HITUNG DENDA SEJAK PINJAM
                if ($hariIni->gt($dueDateObj)) {
                    $totalHariPinjam = $hariIni->diffInDays($borrowDateObj);
                    $dendaFinal = $totalHariPinjam * 1000;
                }

                // 3. Update data peminjaman (Ubah jadi 'Selesai' & kunci nominal dendanya)
                $borrow->update([
                    'status' => 'Selesai', 
                    'denda'  => $dendaFinal     
                ]);

                // 4. KEMBALIKAN STOK FISIK BUKU (+1)
                $book->increment('stock');

                // REFRESH DATA STOK TERBARU SETELAH DI-INCREMENT
                $book->refresh();

                // 5. KATALOG BUKU: Set status otomatis berdasarkan jumlah stok setelah dikembalikan
                $newStatus = $book->stock > 0 ? 'Tersedia' : 'Tidak Tersedia';
                $book->update(['status' => $newStatus]);
            });

            return redirect()->back()->with('success', 'Buku berhasil dikembalikan!');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengembalikan buku: ' . $e->getMessage());
        }
    }

public function history()
    {
        // Ambil data peminjaman milik user yang login saat ini, sertakan relasi bukunya
        // 🔥 MODIFIKASI: Ditambahkan filter agar yang sudah dikembalikan otomatis hilang dari list
        $borrows = Borrow::with('book')
            ->where('user_id', Auth::id())
            ->where('status', 'Dipinjam') // <--- Kuncinya di sini, Yor! Hanya tampilkan yang statusnya 'Dipinjam'
            ->latest()
            ->paginate(10);

        // Lempar data ke view riwayat.blade.php yang ada di folder user/ atau root views
        // Sesuai struktur folder lo, file riwayat lo ada di: resources/views/riwayat.blade.php
        return view('riwayat', compact('borrows'));
    }
}