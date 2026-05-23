@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 overflow-hidden">
    
    {{-- TOMBOL KEMBALI KE BERANDA (Animasi: Masuk dari Kiri) --}}
    <div class="mb-8 opacity-0 animate-fade-in-left">
        <a href="{{ route('welcome') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-bold transition-all group">
            <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Beranda
        </a>
    </div>

    {{-- JUDUL HALAMAN (Animasi: Masuk dari Atas) --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4 opacity-0 animate-fade-in-down">
        <div>
            <h2 class="text-3xl font-black text-slate-800 tracking-tight">
                Katalog <span class="text-blue-600">Lengkap</span>
            </h2>
            <p class="text-slate-400 text-sm mt-1 font-medium">Temukan bacaan favorit Anda dari koleksi terbaik kami.</p>
        </div>
        <p class="text-slate-500 font-medium bg-slate-100 px-4 py-2 rounded-2xl text-sm self-start shadow-sm">
            Total: {{ $books->total() }} Buku
        </p>
    </div>

    {{-- FITUR PENCARIAN & FILTER (Animasi: Masuk dari Kanan) --}}
    <div class="flex flex-col gap-6 mb-12 opacity-0 animate-fade-in-right">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
            <div class="hidden md:block">
                <span class="text-slate-500 font-bold bg-slate-100 px-5 py-3 rounded-2xl text-xs uppercase tracking-wider shadow-sm">
                    📚 Total: {{ $books->total() }} Koleksi
                </span>
            </div>

            <div class="md:col-span-2 relative">
                <form action="{{ route('catalog') }}" method="GET" class="relative flex items-center">
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Cari judul buku, penulis, atau ISBN..." 
                        style="padding-right: 3.5rem;" 
                        class="w-full pl-5 py-4 bg-white border border-slate-200 rounded-2xl text-sm font-bold text-slate-600 focus:ring-4 focus:ring-blue-50 focus:border-blue-400 focus:outline-none transition-all shadow-sm">

                    <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </form>
            </div>
        </div>

        {{-- Filter Pills --}}
        <div class="flex items-center gap-3 overflow-x-auto pb-2 no-scrollbar">
            <span class="text-xs font-black text-slate-400 uppercase tracking-widest mr-2">Filter:</span>

            <a href="{{ route('catalog') }}"
            class="whitespace-nowrap px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm
            {{ !request('category') ? 'bg-blue-600 text-white shadow-blue-200' : 'bg-white text-slate-500 border border-slate-100 hover:bg-slate-50' }}">
                ✨ Semua Koleksi
            </a>

            @php
            $categories = [
                'fiksi'     => '📖',
                'bisnis'    => '💼',
                'teknologi' => '🖥️',
                'sejarah'   => '🧭',
            ];
            @endphp

            @foreach($categories as $cat => $icon)
                <a href="{{ route('catalog', ['category' => $cat]) }}"
                class="whitespace-nowrap px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm
                {{ strtolower(request('category')) == $cat ? 'bg-blue-600 text-white shadow-blue-200' : 'bg-white text-slate-500 border border-slate-100 hover:bg-slate-50' }}">
                    {{ $icon }} {{ ucfirst($cat) }}
                </a>
            @endforeach
        </div>
    </div>

   {{-- GRID BUKU --}}
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
        @forelse($books as $index => $book)
            <div class="scroll-reveal opacity-0 translate-y-12 bg-white shadow-sm border border-slate-100 rounded-[2.5rem] p-5 hover:shadow-2xl hover:shadow-blue-100 hover:-translate-y-2 transition-all duration-500 flex flex-col h-full min-h-[600px] transform-gpu">
                
                {{-- Container Gambar --}}
                <div class="relative mb-6 overflow-hidden rounded-[2rem] shadow-sm aspect-[3/4]">
                    <img src="{{ Str::startsWith($book->image, 'http') ? $book->image : asset('storage/' . $book->image) }}" 
                         onerror="this.src='https://via.placeholder.com/300x400?text=Cover+Tidak+Ada'"
                         alt="{{ $book->title }}" 
                         class="w-full h-full object-cover transition-transform duration-700 hover:scale-110">
                    
                    {{-- 🟥 BADGE STATUS DINAMIS: Dipinjam menggunakan warna Merah (bg-rose-500) --}}
                    <div class="absolute top-4 right-4">
                        <span class="px-3 py-1.5 text-[10px] font-black uppercase tracking-widest rounded-xl shadow-sm
                            @if(Auth::check() && isset($book->is_borrowed_by_user) && $book->is_borrowed_by_user)
                                bg-rose-500 text-white
                            @elseif($book->status === 'Tersedia' && $book->stock > 0)
                                bg-emerald-500 text-white
                            @else
                                bg-rose-500 text-white
                            @endif">
                            
                            @if(Auth::check() && isset($book->is_borrowed_by_user) && $book->is_borrowed_by_user)
                                Dipinjam
                            @elseif($book->status === 'Tersedia' && $book->stock > 0)
                                Tersedia
                            @else
                                Habis
                            @endif
                        </span>
                    </div>
                </div>

                {{-- Info Buku --}}
                <div class="flex flex-col flex-grow px-2">
                    <h3 class="text-lg font-black text-slate-800 line-clamp-2 leading-tight mb-2 uppercase tracking-tight">{{ $book->title }}</h3>
                    <p class="text-sm text-slate-400 font-bold mb-4 uppercase italic">By {{ $book->author }}</p>

                    {{-- LIVE INDICATOR STOK FISIK --}}
                    <div class="mb-4 flex items-center justify-between text-xs font-bold bg-slate-50 p-3 rounded-xl border border-slate-100">
                        <span class="text-slate-400">Sisa Stok:</span>
                        @if($book->stock > 0)
                            <span class="text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-xl shadow-inner">{{ $book->stock }} Buku</span>
                        @else
                            <span class="text-rose-600 bg-rose-50 px-2.5 py-1 rounded-xl shadow-inner">Stok Kosong</span>
                        @endif
                    </div>

                    <div class="mt-auto pt-4 border-t border-slate-50 flex flex-col gap-4">
                        @if($book->status === 'Tersedia' && $book->stock > 0)
                            
                            {{-- FORM INTERCEPTOR KONDISIONAL BERDASARKAN STATUS USER --}}
                            <div class="flex flex-col gap-3">
                                {{-- Dropdown Durasi Pinjam --}}
                                <div class="relative">
                                    <select name="duration" form="form-pinjam-{{ $book->id }}" class="w-full pl-4 pr-10 py-3 bg-slate-50 border-none rounded-xl text-xs font-bold text-slate-600 appearance-none focus:ring-2 focus:ring-blue-100 cursor-pointer uppercase">
                                        <option value="3">⚡ 3 Hari</option>
                                        <option value="7" selected>📅 1 Minggu</option>
                                        <option value="14">📚 2 Minggu</option>
                                        <option value="30">🏢 1 Bulan</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between gap-2 w-full">
                                    {{-- 1. KONDISI JIKA STOK HABIS / KOSONG --}}
                                    @if($book->stock <= 0)
                                        <div class="w-full flex items-center justify-between gap-2">
                                            <button disabled class="flex-grow bg-slate-100 text-slate-400 border border-slate-200 py-4 rounded-2xl font-black text-[10px] cursor-not-allowed uppercase tracking-wider flex items-center justify-center gap-1">
                                                <span>Tidak Tersedia</span>
                                            </button>
                                            
                                            <a href="{{ route('user.books.show', $book->id) }}" class="p-4 bg-slate-50 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-2xl transition-colors" title="Detail Buku">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </a>
                                        </div>

                                    {{-- 2. KONDISI JIKA STOK MASIH ADA, TAPI USER SUDAH MEMINJAM BUKU INI --}}
                                    @elseif(Auth::check() && isset($book->is_borrowed_by_user) && $book->is_borrowed_by_user)
                                        <div class="w-full flex items-center justify-between gap-2">
                                            <button disabled class="flex-grow bg-slate-100 text-slate-400 border border-slate-200 py-4 rounded-2xl font-black text-[10px] cursor-not-allowed uppercase tracking-wider flex items-center justify-center gap-1">
                                                <span>Sedang Kamu Pinjam</span>
                                            </button>
                                            
                                            <a href="{{ route('user.books.show', $book->id) }}" class="p-4 bg-slate-50 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-2xl transition-colors" title="Detail Buku">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </a>
                                        </div>

                                    {{-- 3. KONDISI JIKA LIMIT AKUN PENUH (TOMBOL MERAH ROSE) --}}
                                    @elseif(isset($activeBorrowCount) && $activeBorrowCount >= 5)
                                        <div class="w-full flex items-center justify-between gap-2">
                                            <button type="button" onclick="tampilkanSkripWarningLimit()" class="flex-grow bg-rose-500 hover:bg-rose-600 text-white py-4 rounded-2xl font-black text-[10px] transition-all shadow-lg shadow-rose-100 uppercase tracking-wider">
                                                <span>Pinjam Sekarang</span>
                                            </button>
                                            
                                            <a href="{{ route('user.books.show', $book->id) }}" class="p-4 bg-slate-50 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-2xl transition-colors" title="Detail Buku">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </a>
                                        </div>

                                    {{-- 4. KONDISI NORMAL (BISA DIPINJAM - TOMBOL BIRU) --}}
                                    @else
                                        @php
                                            // Cek role admin sekali saja di atas agar rapi
                                            $isAdmin = Auth::check() && Auth::user()->role === 'admin';
                                        @endphp

                                        <form id="form-pinjam-{{ $book->id }}" action="{{ route('borrow.store', $book->id) }}" method="POST" class="borrow-form flex-grow m-0 w-full flex items-center justify-between gap-2">
                                            @csrf
                                            
                                            {{-- 🔥 FIX SENIOR: Admin pakai type="button" agar tidak memicu loading overlay global --}}
                                            <button type="{{ $isAdmin ? 'button' : 'submit' }}" 
                                                data-is-admin="{{ $isAdmin ? 'true' : 'false' }}"
                                                class="borrow-btn flex-grow bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-2xl font-black text-[10px] transition-all shadow-lg shadow-blue-100 uppercase tracking-wider">
                                                <span>Pinjam Sekarang</span>
                                            </button>

                                            <a href="{{ route('user.books.show', $book->id) }}" class="p-4 bg-slate-50 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-2xl transition-colors" title="Detail Buku">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </a>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="flex flex-col gap-3">
                                <div class="relative opacity-60">
                                    <select disabled class="w-full pl-4 pr-10 py-3 bg-slate-100 border-none rounded-xl text-xs font-bold text-slate-400 appearance-none cursor-not-allowed uppercase">
                                        <option>Tidak Tersedia</option>
                                    </select>
                                </div>
                                <div class="flex items-center justify-between gap-2">
                                    <button disabled class="flex-grow bg-slate-100 text-slate-400 py-4 rounded-2xl font-black text-[10px] cursor-not-allowed uppercase tracking-wider border border-slate-200">
                                        {{ $book->stock <= 0 ? 'Stok Kosong' : 'Sedang Dipinjam' }}
                                    </button>
                                    <a href="{{ route('user.books.show', $book->id) }}" class="p-4 bg-slate-50 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-2xl transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center">
                <div class="bg-slate-50 rounded-[3rem] p-10 inline-block border border-dashed border-slate-200">
                    <svg class="w-16 h-16 text-slate-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <h3 class="text-xl font-bold text-slate-800">Buku tidak ditemukan</h3>
                    <p class="text-slate-400 mt-2">Maaf, kami tidak dapat menemukan buku dengan kata kunci tersebut.</p>
                </div>
            </div>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    <div class="mt-16 flex justify-center opacity-0 animate-fade-in-up">
        <div class="bg-white p-4 rounded-3xl shadow-sm border border-slate-100">
            {{ $books->links() }}
        </div>
    </div>
</div>

<style>
    .animate-fade-in-left { animation: fadeInLeft 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; animation-delay: 50ms; }
    .animate-fade-in-down { animation: fadeInDown 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards; animation-delay: 150ms; }
    .animate-fade-in-right { animation: fadeInRight 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards; animation-delay: 250ms; }
    .animate-fade-in-up { animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; animation-delay: 400ms; }

    .scroll-reveal {
        opacity: 0;
        transform: translateY(50px);
        transition: opacity 0.8s cubic-bezier(0.34, 1.56, 0.64, 1), 
                    transform 0.8s cubic-bezier(0.34, 1.56, 0.64, 1),
                    box-shadow 0.5s ease,
                    border-color 0.5s ease;
    }
    
    .scroll-reveal.revealed { opacity: 1; transform: translateY(0); }

    @keyframes fadeInLeft { from { opacity: 0; transform: translateX(-40px); } to { opacity: 1; transform: translateX(0); } }
    @keyframes fadeInRight { from { opacity: 0; transform: translateX(40px); } to { opacity: 1; transform: translateX(0); } }
    @keyframes fadeInDown { from { opacity: 0; transform: translateY(-30px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(50px); } to { opacity: 1; transform: translateY(0); } }

    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

{{-- SCRIPT INTERCEPTOR --}}
<script>
    {{-- 🔥 FUNGSI SWEETALERT WARNING LIMIT PEMINJAMAN AKUN --}}
    function tampilkanSkripWarningLimit() {
        Swal.fire({
            title: 'Limit Tercapai!',
            html: `
                <div class="text-sm font-medium text-slate-500 leading-relaxed mt-2 text-center">
                    Kamu sudah meminjam <strong class="text-rose-500">5 buku</strong> sekaligus.<br>
                    <span class="text-xs block mt-2 text-slate-400">Kembalikan buku yang lain terlebih dahulu di halaman riwayat untuk dapat meminjam kembali.</span>
                </div>
            `,
            icon: 'warning',
            iconColor: '#f43f5e', 
            confirmButtonColor: '#f43f5e', // Disamakan murni ke tema Rose/Pink Merah
            confirmButtonText: 'Mengerti',
            background: '#ffffff',
            allowOutsideClick: true,
            customClass: {
                popup: 'rounded-[2.5rem] shadow-[0_25px_60px_rgba(0,0,0,0.15)] border border-slate-100 p-7 max-w-sm mx-auto',
                title: 'text-xl font-black text-slate-800 tracking-tight mt-3 block text-center',
                confirmButton: 'w-full px-5 py-3 rounded-xl font-bold text-xs uppercase tracking-wider shadow-md shadow-rose-200 focus:ring-0 mt-2'
            }
        });
    }

    // 🛑 1. INTERCEPTOR KHUSUS ADMIN (Mencegat via 'click' agar loading screen global tidak terpicu)
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.borrow-btn');
        
        // Jika tombol diklik dan ternyata user adalah Admin
        if (btn && btn.getAttribute('data-is-admin') === 'true') {
            e.preventDefault(); // Menghentikan bubbling event click
            e.stopPropagation(); // Amankan dari pemicu event submit form luar
            
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    position: 'center',
                    icon: 'warning',
                    iconColor: '#f59e0b',
                    title: 'Akses Ditolak!',
                    html: `<div class="text-xs font-semibold text-slate-500 leading-relaxed mt-1">Akun dengan role <strong>Admin</strong> hanya diizinkan untuk mengelola katalog, bukan untuk meminjam buku.</div>`,
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true,
                    background: '#ffffff',
                    customClass: {
                        popup: 'rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.12)] border border-slate-100 p-7 max-w-sm',
                        title: 'text-lg font-black text-slate-800 tracking-tight mt-3 block',
                        timerProgressBar: 'bg-amber-500 h-[3px]'
                    }
                });
            }
        }
    });

    // 🍏 2. LOGIKA TRANSAKSI KHUSUS MAHASISWA (Mencegat via 'submit' form resmi)
    document.addEventListener('submit', function(e) {
        if (e.target.closest('.borrow-form')) {
            const form = e.target.closest('.borrow-form');
            
            if (typeof Swal === 'undefined') {
                return; 
            }

            const btn = form.querySelector('.borrow-btn');
            
            // Proteksi berlapis: Jika entah bagaimana admin bisa memicu submit, matikan total di sini
            if (btn && btn.getAttribute('data-is-admin') === 'true') {
                e.preventDefault();
                return;
            }

            e.preventDefault(); // Tahan submit mahasiswa sebentar untuk memproses alert konfirmasi tanggal

            // Ambil judul buku dengan aman
            const cardContainer = form.closest('.scroll-reveal') || form.closest('.group') || form.parentElement.parentElement;
            const bookTitle = cardContainer ? cardContainer.querySelector('h3').innerText.trim() : 'Buku';

            // Mencari elemen dropdown duration berdasarkan ID form
            const durationSelect = document.querySelector(`select[form="${form.id}"]`);
            const jumlahHari = durationSelect ? parseInt(durationSelect.value) : 7;

            // Hitung batas waktu pengembalian secara dinamis
            const opsiSaja = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const hariIni = new Date();
            const tanggalBatasKoleksi = new Date(hariIni);
            tanggalBatasKoleksi.setDate(hariIni.getDate() + jumlahHari); 
            const formatTanggalIndo = tanggalBatasKoleksi.toLocaleDateString('id-ID', opsiSaja);

                Swal.fire({
                    title: 'Berhasil Dipinjam!',
                    html: `
                        <div class="text-sm text-slate-600 space-y-2">
                            <p>Buku <strong class="text-blue-600">"${bookTitle}"</strong> berhasil ditambahkan ke koleksi pinjamanmu.</p>
                            <div class="mt-4 p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-800 text-xs text-left">
                                <span class="font-bold uppercase block text-emerald-600 mb-1">📅 Batas Waktu Pengembalian (${jumlahHari} Hari):</span>
                                <strong class="text-sm font-black block mt-0.5">${formatTanggalIndo}</strong>
                                <span class="text-[10px] block text-emerald-500 mt-1">*Halaman katalog akan diperbarui otomatis.</span>
                            </div>
                        </div>
                    `,
                    icon: 'success',
                    iconColor: '#10b981',
                    timer: 2500, 
                    timerProgressBar: true, 
                    confirmButtonText: 'Ke Halaman Riwayat', 
                    buttonsStyling: false, 
                    allowOutsideClick: false,
                    customClass: {
                        popup: 'rounded-[2rem] shadow-2xl p-6',
                        title: 'text-xl font-black text-slate-800',
                        // 🔥 PERBAIKAN RADIKAL: Menambahkan !text-white dan !bg-[#10b981] agar tidak bisa ditimpa oleh internal CSS SweetAlert
                        confirmButton: 'inline-flex items-center justify-center px-6 py-3 !bg-[#10b981] hover:!bg-[#059669] !text-white font-bold text-sm rounded-xl w-full mt-2 shadow-lg shadow-emerald-100 transition-all focus:outline-none focus:ring-0 cursor-pointer'
                    }
                }).then(() => {
                    if (btn) btn.style.pointerEvents = 'none';
                    form.submit();
                });
            }
    }); // 🌟 FIX: Kurung penutup event submit yang sempat hilang sekarang sudah lengkap!

    document.addEventListener("DOMContentLoaded", function () {
        // INTERSECTION OBSERVER FOR SCROLL REVEAL
        const booksToReveal = document.querySelectorAll('.scroll-reveal');
        const revealOptions = { root: null, threshold: 0.1, rootMargin: "0px 0px -40px 0px" };

        const bookObserver = new IntersectionObserver(function(entries, observer) {
            let delayCounter = 0;
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const card = entry.target;
                    setTimeout(() => {
                        card.classList.add('revealed');
                    }, delayCounter * 80);
                    delayCounter++;
                    observer.unobserve(card);
                }
            });
        }, revealOptions);

        booksToReveal.forEach(book => { bookObserver.observe(book); });
    });
</script>
@endsection