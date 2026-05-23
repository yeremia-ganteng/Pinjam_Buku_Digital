<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PinjamBuku - Library System</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-sans antialiased text-slate-900 bg-gray-50">
<div class="min-h-screen">
        @if(view()->exists('layouts.navigation'))
            @include('layouts.navigation')
        @endif

        {{-- MENU NAVIGASI KEMBALI KE DASHBOARD DINAMIS --}}
@auth
    {{-- Tombol HANYA muncul jika TIDAK sedang di beranda (welcome) DAN TIDAK di dashboard --}}
    @if(!request()->routeIs('welcome') && !request()->routeIs('dashboard') && !request()->routeIs('admin.dashboard'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 animate__animated animate__fadeIn">
            <div class="flex justify-end">
                <a href="{{ route('dashboard') }}" 
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-black tracking-wider uppercase rounded-xl shadow-lg shadow-blue-600/20 active:scale-95 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"></path>
                    </svg>
                    Kembali Ke Dashboard
                </a>
            </div>
        </div>
    @endif
@endauth

        <main>
            @yield('content')
        </main>
    </div>

    @stack('scripts')

{{-- ================= PREMIUM CENTERED AUTO-CLOSE ALERT ================= --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            
            // 1. Alert Sukses Global di Tengah (Edit Buku, Tambah Buku, dll)
            @if(session('success'))
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    iconColor: '#10b981', // Hijau Emerald khas UI Premium
                    title: 'Tindakan Sukses!',
                    html: `<div class="text-xs font-semibold text-slate-500 leading-relaxed mt-1">{{ session('success') }}</div>`,
                    showConfirmButton: false,
                    timer: 2500, // Menghilang otomatis dalam 2.5 detik biar snappy
                    timerProgressBar: true,
                    background: '#ffffff',
                    customClass: {
                        popup: 'rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.12)] border border-slate-100 p-7 max-w-sm',
                        title: 'text-lg font-black text-slate-800 tracking-tight mt-3 block',
                        timerProgressBar: 'bg-emerald-500 h-[3px]'
                    }
                });
            @endif

            // 2. Alert Peminjaman Sukses di Tengah
            @if(session('borrow_success'))
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    iconColor: '#2563eb', // Biru Royal
                    title: 'Peminjaman Sukses!',
                    html: `
                        <div class="space-y-3 mt-1">
                            <p class="text-xs font-semibold text-slate-500 leading-relaxed">
                                Buku <strong>{{ session('book_title') }}</strong> berhasil dipinjam.
                            </p>
                            <div class="bg-blue-50 text-blue-600 px-3 py-2 rounded-xl font-bold text-[11px] inline-block border border-blue-100">
                                📅 Kembali sebelum: {{ session('return_date') }}
                            </div>
                        </div>
                    `,
                    showConfirmButton: false,
                    timer: 3500, // Beri waktu lebih lama sedikit untuk membaca tanggal
                    timerProgressBar: true,
                    background: '#ffffff',
                    customClass: {
                        popup: 'rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.12)] border border-slate-100 p-7 max-w-sm',
                        title: 'text-lg font-black text-slate-800 tracking-tight mt-3 block',
                        timerProgressBar: 'bg-blue-500 h-[3px]'
                    }
                });
            @endif

        });
    </script>

{{-- ================= GLOBAL 3D MAGIC BOOK LOADING SCREEN OVERLAY ================= --}}
    <div id="global-book-loading" class="fixed inset-0 z-50 flex flex-col items-center justify-center bg-slate-50/95 backdrop-blur-md opacity-0 pointer-events-none transition-opacity duration-500">
        <div class="relative flex flex-col items-center scale-110 lg:scale-125">
            
            <div class="book-stage mb-10">
                <div class="magic-book shadow-2xl">
                    <div class="cover-left"></div>
                    <div class="spine-3d"></div>
                    
                    <div class="page-layer page-1 bg-amber-100"></div>
                    <div class="page-layer page-2 bg-emerald-100"></div>
                    <div class="page-layer page-3 bg-pink-100"></div>
                    <div class="page-layer page-4 bg-sky-100"></div>
                    
                    <div class="cover-right"></div>
                </div>
                <div class="book-shadow"></div>
            </div>
            
            <h3 class="text-xl lg:text-2xl font-black bg-clip-text text-transparent bg-gradient-to-r from-blue-600 via-indigo-600 to-violet-600 tracking-tight text-center px-4 animate-pulse">
                Memperkaya Wawasan Anda...
            </h3>
            <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-widest mt-2 flex items-center gap-0.5">
                Membuka Halaman<span class="loading-dots"></span>
            </p>
        </div>
    </div>

    {{-- STYLE ENGINE FOR 3D ANIMATION --}}
    <style>
        .book-stage {
            position: relative;
            width: 140px;
            height: 100px;
            perspective: 800px;
        }
        .magic-book {
            width: 100%;
            height: 100%;
            position: absolute;
            transform-style: preserve-3d;
            transform: rotateX(25deg) rotateY(-10deg);
            animation: floatBook 3s infinite ease-in-out;
        }
        .cover-left, .cover-right {
            position: absolute;
            width: 70px;
            height: 100px;
            background: linear-gradient(135deg, #b45309, #78350f);
            border: 2px solid #451a03;
            box-shadow: inset 0 0 8px rgba(0,0,0,0.4);
        }
        .cover-left { left: 0; border-radius: 8px 2px 2px 8px; transform-origin: right center; transform: rotateY(-15deg); }
        .cover-right { right: 0; border-radius: 2px 8px 8px 2px; transform-origin: left center; transform: rotateY(15deg); }
        .spine-3d { position: absolute; left: 50%; width: 8px; height: 102px; top: -1px; background: #451a03; transform: translateX(-50%) translateZ(-2px); border-radius: 2px; }
        .page-layer { position: absolute; top: 4px; width: 64px; height: 92px; border: 2.5px solid #1e293b; transform-style: preserve-3d; box-shadow: inset -2px 0 5px rgba(0,0,0,0.05); }
        .page-1 { right: 4px; border-radius: 2px 6px 6px 2px; transform-origin: left center; animation: flipPage3D 2.4s infinite cubic-bezier(0.4, 0, 0.2, 1); animation-delay: 0s; z-index: 4; }
        .page-2 { right: 4px; border-radius: 2px 6px 6px 2px; transform-origin: left center; animation: flipPage3D 2.4s infinite cubic-bezier(0.4, 0, 0.2, 1); animation-delay: 0.6s; z-index: 3; }
        .page-3 { right: 4px; border-radius: 2px 6px 6px 2px; transform-origin: left center; animation: flipPage3D 2.4s infinite cubic-bezier(0.4, 0, 0.2, 1); animation-delay: 1.2s; z-index: 2; }
        .page-4 { right: 4px; border-radius: 2px 6px 6px 2px; transform-origin: left center; animation: flipPage3D 2.4s infinite cubic-bezier(0.4, 0, 0.2, 1); animation-delay: 1.8s; z-index: 1; }

        @keyframes flipPage3D {
            0% { transform: rotateY(0deg); }
            50% { transform: rotateY(-172deg); background-color: #fef08a; }
            100% { transform: rotateY(-172deg); }
        }
        @keyframes floatBook {
            0%, 100% { transform: rotateX(25deg) rotateY(-10deg) translateY(0px); }
            50% { transform: rotateX(22deg) rotateY(-8deg) translateY(-10px); }
        }
        .book-shadow {
            position: absolute;
            bottom: -25px;
            left: 10px;
            right: 10px;
            height: 12px;
            background: rgba(15, 23, 42, 0.08);
            border-radius: 50%;
            filter: blur(4px);
            transform: rotateX(80deg);
            animation: scaleShadow 3s infinite ease-in-out;
        }
        @keyframes scaleShadow {
            0%, 100% { transform: rotateX(80deg) scale(1); opacity: 1; }
            50% { transform: rotateX(80deg) scale(0.85); opacity: 0.5; }
        }
        .loading-dots::after { content: '.'; animation: dots 1.5s infinite steps(4, end); }
        @keyframes dots { 0%, 20% { content: '.'; } 40% { content: '..'; } 60% { content: '...'; } 80%, 100% { content: ''; } }
    </style>

{{-- INTERCEPTOR ENGINE FOR GLOBAL REDIRECTS (FIXED CLICABLE MENU) --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const globalLoader = document.getElementById("global-book-loading");

            // Fungsi pembantu untuk mematikan loading secara total agar layar bisa diklik kembali
            function deactivateLoader() {
                if (globalLoader) {
                    globalLoader.classList.add("opacity-0", "pointer-events-none");
                    globalLoader.classList.remove("opacity-100");
                    
                    // Jeda 500ms menunggu animasi fade-out selesai, baru pasang 'hidden' agar menghilang dari hirarki layar
                    setTimeout(() => {
                        globalLoader.classList.add("hidden");
                    }, 500);
                }
            }

            // 1. Eksekusi pengecekan awal saat halaman mendarat
            @if(session('success') || session('borrow_success'))
                deactivateLoader();
            @else
                deactivateLoader();
            @endif

            // 2. Tangkap semua aksi perpindahan halaman via tag link (a)
            document.addEventListener("click", function (e) {
                const anchor = e.target.closest("a");
                
                if (anchor) {
                    const href = anchor.getAttribute("href");
                    const target = anchor.getAttribute("target");

                    if (
                        href && 
                        !href.startsWith("#") && 
                        !href.startsWith("javascript:") && 
                        target !== "_blank" &&
                        !e.metaKey && !e.ctrlKey
                    ) {
                        e.preventDefault();
                        
                        // Sebelum dinyalakan, buang dulu kelas 'hidden'-nya
                        globalLoader.classList.remove("hidden");
                        
                        // Trigger animasi fade-in smooth
                        setTimeout(() => {
                            globalLoader.classList.remove("opacity-0", "pointer-events-none");
                            globalLoader.classList.add("opacity-100");
                        }, 10);

                        setTimeout(() => {
                            window.location.href = href;
                        }, 500); 
                    }
                }
            });

            // 3. Tangkap aksi submit form manual (selain form login AJAX)
            document.addEventListener("submit", function (e) {
                if (e.target.id !== "login-form") {
                    globalLoader.classList.remove("hidden");
                    setTimeout(() => {
                        globalLoader.classList.remove("opacity-0", "pointer-events-none");
                        globalLoader.classList.add("opacity-100");
                    }, 10);
                }
            });
        });

        // Solusi tombol Back browser agar loading tidak tersangkut
        window.addEventListener("pageshow", function (event) {
            const globalLoader = document.getElementById("global-book-loading");
            if (globalLoader) {
                if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
                    globalLoader.classList.add("opacity-0", "pointer-events-none", "hidden");
                }
            }
        });
    </script>
    </script>
</body>
</html>