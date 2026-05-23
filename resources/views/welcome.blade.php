@extends('layouts.app')

@section('content')
<div class="max-w-[1440px] mx-auto px-10 py-12">
    {{-- HERO SECTION --}}
    @if(!$isSearching)
        <div class="flex flex-col lg:flex-row items-center justify-between gap-12 pt-10 mb-32">
            <div class="flex-1 fade-up" id="hero-text">
                <h1 class="text-5xl lg:text-7xl font-extrabold text-slate-900 leading-tight">
                    <span id="line1" class="typing-container"></span>
                    <span id="cursor1" class="custom-cursor">|</span><br>
                    <span id="line2" class="typing-container text-blue-600"></span>
                    <span id="cursor2" class="custom-cursor">|</span>
                </h1>
                <p class="text-xl text-slate-500 mt-6">Pinjam buku dengan mudah dan cepat tanpa antre.</p>

                {{-- SEARCH FORM --}}
                <div class="mt-16 max-w-2xl">
                    <form action="{{ route('catalog') }}" method="GET" class="relative group">
                        <div class="flex items-center bg-white rounded-2xl shadow-xl p-2 transition-all duration-300 focus-within:shadow-2xl focus-within:shadow-blue-200/60 border-none">
                            <div class="pl-4 pr-2 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" name="search" placeholder="Cari judul buku atau penulis..." 
                                class="w-full py-4 px-2 text-gray-700 bg-transparent border-none ring-0 focus:ring-0 focus:outline-none text-lg"
                                value="{{ request('search') }}">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-bold transition-all active:scale-95 shadow-lg shadow-blue-200">
                                Cari
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="flex-1 flex justify-end fade-up"> 
                <div class="w-full max-w-[450px] rounded-[3rem] overflow-hidden shadow-2xl border-8 border-white animate-float">
                    <img src="https://illustrations.popsy.co/blue/studying.svg" class="w-full h-full object-cover p-6" alt="Illustration">
                </div>
            </div>
        </div>

        {{-- CATEGORY SECTION --}}
        <div class="mb-32 fade-up">
            <h2 class="text-3xl font-black text-slate-800 mb-10 px-4">Eksplorasi <span class="text-blue-600">Kategori</span></h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @php
                    $categories = [
                        ['name' => 'Fiksi',      'icon' => '📖', 'bg' => 'bg-orange-100'],
                        ['name' => 'Bisnis',     'icon' => '💼', 'bg' => 'bg-emerald-100'],
                        ['name' => 'Teknologi',  'icon' => '🖥️', 'bg' => 'bg-blue-100'],
                        ['name' => 'Sejarah',    'icon' => '🧭', 'bg' => 'bg-amber-100'],
                    ];
                @endphp
                @foreach($categories as $cat)
                <a href="{{ route('catalog', ['category' => $cat['name']]) }}" 
                class="category-card group bg-blue-50 p-8 rounded-[2.5rem] shadow-sm transition-all duration-500 text-center hover:-translate-y-3 hover:shadow-2xl border border-slate-50 relative overflow-hidden">
                    <div class="w-16 h-16 {{ $cat['bg'] }} rounded-2xl flex items-center justify-center mx-auto mb-5 transition-all duration-500 group-hover:rotate-[15deg] shadow-inner text-3xl">
                        {{ $cat['icon'] }}
                    </div>
                    <h3 class="font-bold text-slate-700 text-sm group-hover:text-blue-600">{{ $cat['name'] }}</h3>
                </a>
                @endforeach
            </div>
        </div>

        {{-- FEATURES SECTION --}}
        <div class="mb-32 fade-up">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @php
                    $features = [
                        [
                            'title' => 'Mudah & Cepat', 
                            'desc' => 'Proses praktis', 
                            'icon' => 'M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122', 
                            'bg' => 'bg-orange-50', 
                            'text' => 'text-orange-600',
                            'href' => 'catalog',
                            'params' => [],
                        ],
                        [
                            'title' => 'Banyak Pilihan', 
                            'desc' => 'Ribuan koleksi', 
                            'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 
                            'bg' => 'bg-blue-50', 
                            'text' => 'text-blue-600',
                            'href' => 'catalog',
                            'params' => [],
                        ],
                        [
                            'title' => 'Riwayat Pesanan', 
                            'desc' => 'Pantau status', 
                            'icon' => 'M12 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4', 
                            'bg' => 'bg-purple-50', 
                            'text' => 'text-purple-600',
                            'href' => 'riwayat',
                            'params' => [],
                        ],
                    ];
                @endphp

                @foreach($features as $index => $f)
                    @php
                        $isRiwayat = $f['href'] === 'riwayat';

                        if ($isRiwayat) {
                            $tag = 'a';
                            $href = Auth::check() ? route('riwayat') : route('login');
                        } else {
                            $tag = 'a';
                            $href = route($f['href'], $f['params']);
                        }
                    @endphp

                    <{{ $tag }} href="{{ $href }}"
                        class="fade-up group bg-blue-50 p-8 rounded-[2.5rem] shadow-[0_4px_20px_rgba(0,0,0,0.03)] flex flex-col items-center text-center border border-slate-50 transition-all duration-500 hover:-translate-y-3 hover:shadow-2xl hover:border-white cursor-pointer" 
                        style="transition-delay: {{ ($index + 1) * 150 }}ms">
                        
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center transition-all duration-500 group-hover:scale-110 group-hover:rotate-[15deg] {{ $f['bg'] }} {{ $f['text'] }} shadow-inner relative overflow-hidden mb-5">
                            <div class="absolute inset-0 opacity-0 group-hover:opacity-20 transition-opacity duration-500"></div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $f['icon'] }}" />
                            </svg>
                        </div>
                        
                        <h4 class="font-bold text-slate-700 text-sm group-hover:text-blue-600 transition-colors duration-300">{{ $f['title'] }}</h4>
                        <p class="text-xs text-slate-400 font-medium mt-1">{{ $f['desc'] }}</p>

                        <span class="mt-4 text-[10px] font-black uppercase tracking-widest {{ $f['text'] }} opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center gap-1">
                            @if($isRiwayat)
                                {{ Auth::check() ? 'Lihat Riwayat' : 'Login Dulu' }}
                            @elseif($f['href'] === 'catalog' && $f['title'] === 'Banyak Pilihan')
                                Jelajahi Semua
                            @else
                                Mulai Cari
                            @endif
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </span>

                    </{{ $tag }}>
                @endforeach
            </div>
        </div>

    @endif

    {{-- Container Buku Populer --}}
    <div class="container mx-auto px-4 py-16">
        <div class="flex items-center justify-between mb-12">
            <h2 class="text-2xl md:text-4xl font-black text-slate-800 tracking-tight">
                Buku <span class="text-blue-600">Populer</span>
            </h2>
            <a href="{{ route('catalog') }}" class="text-blue-600 font-bold flex items-center gap-2 hover:gap-3 transition-all">
                Lihat Semua 
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
        </div>

        {{-- Grid Buku dengan Indikator Warna --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 md:gap-10">
            @foreach($popularBooks as $index => $book)
                @php
                    $isBorrowed = Auth::check() && \App\Models\Borrow::where('book_id', $book->id)
                                    ->where('user_id', Auth::id())
                                    ->whereIn('status', ['Dipinjam', 'Pending'])
                                    ->exists();
                @endphp

                <div class="fade-up group rounded-[2.5rem] p-4 border transition-all duration-500 flex flex-col h-full 
                    {{ $isBorrowed ? 'bg-rose-50 border-rose-200 shadow-rose-100' : 'bg-white border-slate-100 shadow-sm hover:shadow-2xl' }}"
                    style="transition-delay: {{ ($index % 4) * 150 }}ms">
                    
                    <a href="{{ route('user.books.show', $book->id) }}" class="relative mb-6 overflow-hidden rounded-[2rem] shadow-md bg-slate-50 aspect-[3/4]">
                        <img src="{{ asset('storage/' . $book->image) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        
                        <div class="absolute top-4 right-4">
                            @if($isBorrowed)
                                <span class="px-3 py-1.5 text-[9px] font-black uppercase tracking-widest rounded-xl shadow-sm bg-rose-500 text-white">Dipinjam Anda</span>
                            @elseif($book->stock > 0)
                                <span class="px-3 py-1.5 text-[9px] font-black uppercase tracking-widest rounded-xl shadow-sm bg-emerald-500 text-white">Tersedia</span>
                            @else
                                <span class="px-3 py-1.5 text-[9px] font-black uppercase tracking-widest rounded-xl shadow-sm bg-slate-400 text-white">Habis</span>
                            @endif
                        </div>
                    </a>

                    <div class="flex flex-col flex-grow px-2">
                        <h3 class="text-lg font-bold text-slate-800 line-clamp-1 mb-1">{{ $book->title }}</h3>
                        <p class="text-xs text-slate-400 font-semibold mb-3 italic">{{ $book->author }}</p>

                        <div class="mt-auto">
                            @if($isBorrowed)
                                <button disabled class="w-full py-3 bg-rose-200 text-rose-800 rounded-2xl font-bold text-xs uppercase cursor-not-allowed">
                                    Sedang Dipinjam
                                </button>
                            @elseif($book->stock > 0)
                                <form action="{{ route('borrow.store', $book->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full py-3 bg-blue-600 text-white rounded-2xl font-bold text-xs uppercase hover:bg-blue-700">
                                        Pinjam Sekarang
                                    </button>
                                </form>
                            @else
                                <button disabled class="w-full py-3 bg-slate-100 text-slate-400 rounded-2xl font-bold text-xs uppercase">
                                    Stok Kosong
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    @keyframes shimmer {
        100% { transform: translateX(100%); }
    }
    .animate-shimmer {
        animation: shimmer 1.5s infinite;
    }

    .fade-up:hover {
        transform: translateY(-12px) scale(1.02);
        transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .borrow-btn {
        backface-visibility: hidden;
        transform: translateZ(0);
        -webkit-font-smoothing: subpixel-antialiased;
    }

    .borrow-btn:hover {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    }

    .typing-container { min-height: 1.2em; display: inline; }
    .custom-cursor { color: #2563eb; font-weight: 300; margin-left: 2px; visibility: hidden; }
    .is-blinking { animation: blink 0.7s infinite; }
    @keyframes blink { 0%, 100% { opacity: 1; } 50% { opacity: 0; } }

    input[name="search"], input[name="search"]:focus {
        border: none !important; outline: none !important; box-shadow: none !important; ring: 0 !important;
    }

    .fade-up { 
        opacity: 0; 
        transform: translateY(30px); 
        transition: opacity 1.2s cubic-bezier(0.22, 1, 0.36, 1), 
                    transform 1.2s cubic-bezier(0.22, 1, 0.36, 1); 
    }
    .fade-up.show { 
        opacity: 1; 
        transform: translateY(0); 
    }

    @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-15px); } }
    .animate-float { animation: float 4s ease-in-out infinite; }

    .feature-card { transition: all 0.5s cubic-bezier(0.22, 1, 0.36, 1); }
    .feature-card:hover { transform: translateY(-10px); }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/TextPlugin.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        gsap.registerPlugin(TextPlugin);
        const l1 = document.getElementById('line1'), l2 = document.getElementById('line2');
        const c1 = document.getElementById('cursor1'), c2 = document.getElementById('cursor2');
        
        if(l1 && l2) {
            const tl = gsap.timeline({ repeat: -1 });
            tl.set([c1, c2], { visibility: "hidden" })
              .set(c1, { visibility: "visible" }).add(() => c1.classList.add('is-blinking'))
              .to(l1, { duration: 1.5, text: "Temukan & Pinjam", ease: "none" })
              .add(() => c1.classList.remove('is-blinking'))
              .set(c1, { visibility: "hidden" })
              .set(c2, { visibility: "visible" }).add(() => c2.classList.add('is-blinking'))
              .to(l2, { duration: 1.5, text: "Buku Favorit Anda", ease: "none" })
              .add(() => c2.classList.remove('is-blinking'))
              .to({}, { duration: 5 })
              .add(() => c2.classList.add('is-blinking'))
              .to(l2, { duration: 0.8, text: "", ease: "none" })
              .set(c2, { visibility: "hidden" }).add(() => c2.classList.remove('is-blinking'))
              .set(c1, { visibility: "visible" }).add(() => c1.classList.add('is-blinking'))
              .to(l1, { duration: 0.8, text: "", ease: "none" })
              .set(c1, { visibility: "hidden" }).add(() => c1.classList.remove('is-blinking'))
              .to({}, { duration: 0.5 });
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(e => { 
                if(e.isIntersecting) { 
                    e.target.classList.add('show'); 
                    observer.unobserve(e.target); 
                }
            });
        }, { threshold: 0.1 });
        
        document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));

        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.borrow-btn');
            if (btn && btn.getAttribute('data-is-admin') === 'true') {
                e.preventDefault();
                e.stopPropagation();
                
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
                            popup: 'rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.12)] border border-slate-100 p-7 max-w-sm mx-auto',
                            title: 'text-lg font-black text-slate-800 tracking-tight mt-3 block text-center',
                            timerProgressBar: 'bg-amber-500 h-[3px]'
                        }
                    });
                }
            }
        });

        document.addEventListener('submit', function(e) {
            if (e.target.closest('.borrow-form')) {
                const form = e.target.closest('.borrow-form');
                
                if (typeof Swal === 'undefined') {
                    return; 
                }

                const btn = form.querySelector('.borrow-btn');
                
                if (btn && btn.getAttribute('data-is-admin') === 'true') {
                    e.preventDefault();
                    return;
                }

                e.preventDefault(); 

                const textSpan = btn.querySelector('span');
                const bookTitle = form.closest('.group').querySelector('h3').innerText.trim();

                const durationInput = form.querySelector('input[name="duration"]');
                const jumlahHari = durationInput ? parseInt(durationInput.value) : 7;

                btn.style.pointerEvents = 'none';
                btn.classList.add('bg-emerald-500', 'scale-95');
                if (textSpan) textSpan.style.opacity = '0';
                
                setTimeout(() => {
                    if (textSpan) {
                        textSpan.innerHTML = `
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>Memproses...</span>
                        `;
                        textSpan.classList.add('flex', 'items-center', 'justify-center', 'gap-2');
                        textSpan.style.opacity = '1';
                    }

                    const opsiSaja = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                    const hariIni = new Date();
                    const tanggalBatasKoleksi = new Date(hariIni);
                    tanggalBatasKoleksi.setDate(hariIni.getDate() + jumlahHari); 
                    const formatTanggalIndo = tanggalBatasKoleksi.toLocaleDateString('id-ID', opsiSaja);

                    setTimeout(() => {
                        Swal.fire({
                            title: 'Berhasil Dipinjam!',
                            html: `
                                <div class="text-sm text-slate-600 space-y-2">
                                    <p>Buku <strong class="text-blue-600">"${bookTitle}"</strong> berhasil ditambahkan ke koleksi pinjamanmu.</p>
                                    <div class="mt-4 p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-800 text-xs text-left">
                                        <span class="font-bold uppercase block text-emerald-600 mb-1">📅 Batas Waktu Pengembalian (${jumlahHari} Hari):</span>
                                        <strong class="text-sm font-black block mt-0.5">${formatTanggalIndo}</strong>
                                        <span class="text-[10px] block text-emerald-500 mt-1">*Halaman akan berpindah otomatis dalam beberapa detik.</span>
                                    </div>
                                </div>
                            `,
                            icon: 'success',
                            iconColor: '#10b981',
                            timer: 5000,
                            timerProgressBar: true, 
                            confirmButtonColor: '#0f172a',
                            confirmButtonText: 'Lihat Riwayat Saya',
                            allowOutsideClick: false,
                            customClass: {
                                popup: 'rounded-[2rem] shadow-2xl p-6',
                                title: 'text-xl font-black text-slate-800',
                                confirmButton: 'px-6 py-2.5 rounded-xl font-bold text-sm w-full mt-2'
                            }
                        }).then((result) => {
                            form.submit();
                        });
                    }, 1000);
                }, 150);
            }
        });
    });

    function pemicuAlertKatalog() {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Limit Pinjam Tercapai!',
                html: `
                    <div class="text-sm font-medium text-slate-500">
                        Kamu sedang meminjam <strong class="text-rose-600 font-bold">5 Buku</strong> aktif.<br>
                        <span class="text-xs block mt-2 text-slate-400">Kembalikan beberapa buku terlebih dahulu melalui Dashboard untuk bisa meminjam buku baru lagi.</span>
                    </div>
                `,
                icon: 'warning',
                iconColor: '#f43f5e',
                confirmButtonColor: '#0f172a',
                confirmButtonText: 'Ke Dashboard Saya',
                showCancelButton: true,
                cancelButtonText: 'Nanti Saja',
                cancelButtonColor: '#94a3b8',
                background: '#ffffff',
                customClass: {
                    popup: 'rounded-[2rem] shadow-xl',
                    title: 'text-xl font-black text-slate-800',
                    confirmButton: 'px-4 py-2.5 rounded-xl font-bold text-sm',
                    cancelButton: 'px-4 py-2.5 rounded-xl font-bold text-sm'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('dashboard') }}"; 
                }
            });
        } else {
            alert("Limit Pinjam Tercapai! Anda sudah meminjam 5 buku aktif.");
        }
    }
</script>
@endpush