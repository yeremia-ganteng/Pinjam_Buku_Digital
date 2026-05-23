<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Borrow;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{

    /**
     * Tampilan untuk Admin (Daftar Buku Lengkap)
     */
   public function index()
    {
        // 1. Ambil 8 buku terbaru
        $books = Book::latest()->take(8)->get();

        // 2. Default-kan semua buku TIDAK sedang dipinjam
        foreach ($books as $book) {
            $book->is_borrowed_by_user = false; 
        }

        // 3. Jika user login, baru cek apakah buku itu benar-benar dipinjam user ini
        if (Auth::check()) {
            $borrowedBookIds = Borrow::where('user_id', Auth::id())
                                    ->where('status', 'Dipinjam')
                                    ->pluck('book_id')
                                    ->toArray();

            foreach ($books as $book) {
                // Ini baru benar: hanya set true jika ID buku ada di daftar pinjaman user
                $book->is_borrowed_by_user = in_array($book->id, $borrowedBookIds);
            }
        }

        $activeBorrowCount = Auth::check() ? Borrow::where('user_id', Auth::id())->where('status', 'Dipinjam')->count() : 0;

        return view('welcome', compact('books', 'activeBorrowCount'));
    }

    /**
     * Halaman Beranda (Home/Welcome)
     * Hanya menampilkan buku populer, tidak menangani pencarian utama.
     */
    public function welcome(Request $request)
    {
        // 1. Ambil data populer
        $popularBooks = Book::with('category')
            ->withCount('borrows')
            ->orderBy('borrows_count', 'desc')
            ->take(4)
            ->get();

        // 🔥 WAJIB PANGGIL HELPER INI agar is_borrowed_by_user terisi
        $this->checkUserBorrowStatus($popularBooks);

        // 2. Hitung limit pinjaman
        $activeBorrowCount = Auth::check() 
            ? \App\Models\Borrow::where('user_id', Auth::id())
                ->whereIn('status', ['Dipinjam', 'dipinjam', 'DIPINJAM', 'Pending', 'pending', 'PENDING', 'borrowed'])
                ->count() 
            : 0;

        $isSearching = false;
        return view('welcome', compact('popularBooks', 'isSearching', 'activeBorrowCount'));
    }

    /**
     * Halaman Katalog Lengkap
     * Menangani daftar semua buku, filter kategori, dan pencarian.
     */
    public function catalog(Request $request)
    {
        $search = $request->input('search');
        $category = $request->input('category');
        
        $query = Book::with('category');

        // Logika Pencarian & Filter Kategori (Tetap di halaman Katalog)
        if ($search || $category) {
            $query->when($search, function ($q, $search) {
                return $q->where(function($sub) use ($search) {
                    $sub->where('title', 'like', "%{$search}%")
                        ->orWhere('author', 'like', "%{$search}%")
                        ->orWhere('isbn', 'like', "%{$search}%");
                });
            })->when($category, function ($q, $category) {
                return $q->whereHas('category', function($sub) use ($category) {
                    $sub->where('slug', $category)
                        ->orWhere('name', 'like', "%{$category}%");
                });
            });
        }

        // Gunakan pagination agar tampilan rapi dan load cepat
        $books = $query->latest()->paginate(12);

        // 1. Suntikkan status pinjam ke data pagination katalog
        $this->checkUserBorrowStatus($books);

        // 2. 🔥 PERBAIKAN: Hitung limit termasuk status pending/proses di halaman katalog
        $activeBorrowCount = Auth::check() 
            ? \App\Models\Borrow::where('user_id', Auth::id())
                ->whereIn('status', ['Dipinjam', 'dipinjam', 'DIPINJAM', 'Pending', 'pending', 'PENDING', 'borrowed'])
                ->count() 
            : 0;

        // UX: Jika hasil pencarian tepat 1 buku, langsung arahkan ke detail
        if ($search && $books->count() === 1) {
            return redirect()->route('user.books.show', $books->first()->id);
        }

        return view('catalog', compact('books', 'category', 'search', 'activeBorrowCount'));
    }

    /**
     * Helper: Mengecek apakah buku sedang dipinjam oleh user yang login
     */
    private function checkUserBorrowStatus($books)
    {
        if (Auth::check()) {
            $userId = Auth::id();
            
            // 🔥 PERBAIKAN: Gunakan whereIn bypass multi-case huruf besar/kecil status database
            $borrowedBookIds = DB::table('borrows')
                ->where('user_id', $userId)
                ->whereIn('status', ['Dipinjam', 'dipinjam', 'DIPINJAM', 'Pending', 'pending', 'PENDING', 'borrowed'])
                ->pluck('book_id')
                ->toArray();

            foreach ($books as $book) {
                $book->is_borrowed_by_user = in_array($book->id, $borrowedBookIds);
            }
        }
    }

/**
     * Detail Buku
     */
    public function show($id)
    {
        // 1. Load data buku beserta relasi category dan borrows yang aktif (termasuk pending)
        $book = Book::with(['category', 'borrows' => function($q) {
            $q->whereIn('status', ['Dipinjam', 'dipinjam', 'DIPINJAM', 'Pending', 'pending', 'PENDING', 'borrowed']);
        }])->findOrFail($id);

        // 2. Inisialisasi default saklar peminjaman personal user
        $isBorrowedByUser = false;
        $activeBorrowCount = 0;

        // 3. Jika user sudah login, hitung limit global dan cek status buku ini
        if (\Illuminate\Support\Facades\Auth::check()) {
            $userId = \Illuminate\Support\Facades\Auth::id();

            // Hitung total buku yang sedang dipinjam mahasiswa ini (Menggunakan variabel $activeBorrowCount)
            $activeBorrowCount = \App\Models\Borrow::where('user_id', $userId)
                ->whereIn('status', ['Dipinjam', 'dipinjam', 'DIPINJAM', 'Pending', 'pending', 'PENDING', 'borrowed'])
                ->count();

            // Cek apakah buku spesifik ini ada di dalam daftar pinjaman aktif/pending mahasiswa ini
            $isBorrowedByUser = \App\Models\Borrow::where('user_id', $userId)
                ->where('book_id', $id)
                ->whereIn('status', ['Dipinjam', 'dipinjam', 'DIPINJAM', 'Pending', 'pending', 'PENDING', 'borrowed'])
                ->exists(); 
        }

        // 4. Lempar variabel ke dalam compact()
        return view('books.show', compact('book', 'activeBorrowCount', 'isBorrowedByUser'));
    }

    public function create()
    {
        // Ambil semua kategori untuk isi dropdown di form
        $categories = Category::all();
        return view('admin.books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'isbn' => 'required|unique:books,isbn',
            'title' => 'required',
            'author' => 'required',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'nullable',
            'stock' => 'required|numeric',
        ]);

        // 2. Handle Upload Gambar (jika ada)
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('covers', 'public');
        }

        // 3. Simpan ke Database
        Book::create([
            'isbn' => $request->isbn,
            'title' => $request->title,
            'author' => $request->author,
            'category_id' => $request->category_id,
            'image' => $imagePath,
            'description' => $request->description,
            'stock' => $request->stock,
            'status' => $request->stock > 0 ? 'Tersedia' : 'Tidak Tersedia',
        ]);

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $categories = \App\Models\Category::all();
        return view('admin.books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $request->validate([
            'isbn' => 'required|unique:books,isbn,' . $id,
            'title' => 'required',
            'author' => 'required',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'stock' => 'required|numeric',
            'description' => 'nullable',
        ]);

        // Ambil semua input kecuali image dulu
        $data = $request->except('image');

        // Handle Image secara terpisah
        if ($request->hasFile('image')) {
            // Hapus file lama
            if ($book->image && Storage::disk('public')->exists($book->image)) {
                Storage::disk('public')->delete($book->image);
            }
            // Simpan file baru
            $data['image'] = $request->file('image')->store('covers', 'public');
        }

        $data['status'] = $request->stock > 0 ? 'Tersedia' : 'Tidak Tersedia';

        $book->update($data);

        return redirect()->route('books.index')->with('success', 'Informasi buku berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        // Hapus gambar dari storage jika ada
        if ($book->image && Storage::disk('public')->exists($book->image)) {
            Storage::disk('public')->delete($book->image);
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus!');
    }
}