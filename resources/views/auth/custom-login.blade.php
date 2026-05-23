@extends('layouts.guest')

@section('content')
<div class="w-full min-h-screen bg-white flex overflow-x-hidden select-none">
    
    <div class="w-full min-h-screen flex flex-col md:flex-row relative">
        
        {{-- ================= SISI KIRI: BRANDING & HERO GRAPHIC ================= --}}
        <div id="left-panel" class="hidden md:flex md:w-[45%] lg:w-[50%] bg-slate-950 p-12 lg:p-20 flex-col justify-between relative overflow-hidden group transform transition-all duration-500 ease-out -translate-x-full opacity-0">
            <div class="absolute inset-0 w-full h-full object-cover opacity-30 mix-blend-luminosity grayscale transition-transform duration-1000 group-hover:scale-105 pointer-events-none bg-center bg-cover"
                 style="background-image: url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?q=80&w=1600&auto=format&fit=crop');">
            </div>
            <div class="absolute inset-0 bg-gradient-to-br from-blue-950/90 via-indigo-950/85 to-slate-950/95 z-0"></div>
            <div class="absolute top-[-20%] left-[-20%] w-[80%] h-[80%] bg-blue-500/15 rounded-full blur-[120px] pointer-events-none animate-pulse z-10"></div>

            <div class="flex items-center gap-3 relative z-20 transition-transform duration-500 hover:translate-x-2">
                <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/30">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <span class="text-white font-black text-xl tracking-tight">Pinjam<span class="text-blue-500">Buku.</span></span>
            </div>

            <div class="my-auto relative z-20 space-y-6 max-w-md">
                <h1 class="text-4xl lg:text-6xl font-black text-white leading-[1.1] tracking-tight">
                    Gerbang Menuju <br>
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-400 via-indigo-200 to-white">Ribuan Ilmu.</span>
                </h1>
                <p class="text-slate-300 text-sm lg:text-base font-medium leading-relaxed opacity-90">
                    Kelola koleksi bacaanmu dan pantau riwayat peminjaman dalam satu tempat cerdas yang dirancang untuk kenyamanan membaca Anda.
                </p>
            </div>

            <div class="border-t border-white/10 pt-6 flex items-center justify-between relative z-20 text-[11px] font-bold tracking-widest text-slate-400 uppercase">
                <span class="text-[10px] text-slate-500 font-medium">© 2026 PinjamBuku Library System</span>
            </div>
        </div>

        {{-- ================= SISI KANAN: FORM LOGIN ================= --}}
        <div id="right-panel" class="w-full md:w-[55%] lg:w-[50%] bg-white p-8 sm:p-16 lg:p-24 flex flex-col justify-center relative min-h-screen transform transition-all duration-500 ease-out translate-x-full opacity-0">
            <div class="absolute inset-0 w-full h-full bg-center bg-cover opacity-[0.04] mix-blend-multiply pointer-events-none select-none"
                 style="background-image: url('https://images.unsplash.com/photo-1544947950-fa07a98d237f?q=80&w=1200&auto=format&fit=crop');">
            </div>

            <div class="max-w-md w-full mx-auto space-y-8 relative z-10">
                <div class="space-y-2">
                    <h2 class="text-3xl lg:text-4xl font-black text-slate-900 tracking-tight">Selamat Datang</h2>
                    <p class="text-slate-400 text-sm font-semibold">Masuk untuk mengelola peminjaman buku Anda.</p>
                </div>

                {{-- Wadah Pesan Error Dinamis (Tetap Berada Di Dalam Form Tanpa Mental) --}}
                <div id="error-container" class="hidden">
                    <div class="p-4 bg-rose-50 border border-rose-100 text-rose-700 text-xs font-bold rounded-2xl flex items-center gap-2.5 shadow-sm transition-all duration-300">
                        <span class="text-base">⚠️</span>
                        <div>
                            <p class="font-black uppercase tracking-wider">Gagal Masuk</p>
                            <p id="error-text" class="text-[11px] text-rose-500/90 font-medium mt-0.5"></p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('login') }}" method="POST" id="login-form" onsubmit="return false;" class="space-y-5">
                    @csrf
                    
                    <div class="space-y-1.5 relative group/input">
                        <label class="text-xs font-black text-slate-700 uppercase tracking-wider block">Alamat Email</label>
                        <input type="email" name="email" required placeholder="nama@email.com"
                            class="w-full px-5 py-4 bg-slate-50/80 border border-slate-200/60 rounded-2xl text-sm font-semibold text-slate-800 focus:bg-white focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10 transition-all duration-300 outline-none">
                    </div>

                    <div class="space-y-1.5 relative group/input">
                        <div class="flex justify-between items-center">
                            <label class="text-xs font-black text-slate-700 uppercase tracking-wider block">Password</label>
                            <a href="#" class="text-xs font-bold text-blue-600 hover:text-blue-700 hover:underline">Lupa Password?</a>
                        </div>
                        <input type="password" name="password" required placeholder="••••••••"
                            class="w-full px-5 py-4 bg-slate-50/80 border border-slate-200/60 rounded-2xl text-sm font-semibold text-slate-800 focus:bg-white focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10 transition-all duration-300 outline-none">
                    </div>

                    <button type="submit" id="submit-btn"
                        class="w-full py-4 mt-2 bg-slate-900 hover:bg-blue-600 text-white rounded-2xl font-bold text-sm tracking-wide shadow-lg flex items-center justify-center gap-2 transition-all duration-300 ease-out active:scale-[0.98]">
                        <span id="btn-text">Masuk</span>
                    </button>
                </form>

                <p class="text-center text-sm font-medium text-slate-500 pt-2">
                    Belum memiliki akses perpustakaan? 
                    <a href="{{ route('register') }}" id="register-link" class="text-blue-600 font-extrabold tracking-tight ml-1 hover:text-blue-700">
                        Daftar Keanggotaan Baru
                    </a>
                </p>
            </div>
        </div>

    </div>
</div>

{{-- 🔥 EXCLUSIVE 3D MAGIC BOOK LOADING SCREEN 🔥 --}}
<div id="book-loading" class="fixed inset-0 z-50 flex flex-col items-center justify-center bg-slate-50/95 backdrop-blur-md opacity-0 pointer-events-none transition-opacity duration-500">
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
        
        <h3 class="text-xl lg:text-2xl font-black bg-clip-text text-transparent bg-gradient-to-r from-blue-600 via-indigo-600 to-violet-600 tracking-tight text-center px-4">
            Memperkaya Wawasan Anda...
        </h3>
        <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-widest mt-2 flex items-center gap-0.5">
            Menyiapkan Dashboard<span class="loading-dots"></span>
        </p>
    </div>
</div>

{{-- STYLE ENGINES FOR EXCLUSIVE CSS ANIMATION --}}
<style>
    /* --- THE 3D ENGINE BOOK STANDAR SENIOR DEV --- */
    .book-stage {
        position: relative;
        width: 140px;
        height: 100px;
        perspective: 800px; /* Memberikan efek kedalaman 3D nyata */
    }

    .magic-book {
        width: 100%;
        height: 100%;
        position: absolute;
        transform-style: preserve-3d;
        transform: rotateX(25deg) rotateY(-10deg);
        animation: floatBook 3s infinite ease-in-out; /* Buku melayang naik turun */
    }

    /* Cover Buku Luar (Kulit Cokelat Premium Lucu) */
    .cover-left, .cover-right {
        position: absolute;
        width: 70px;
        height: 100px;
        background: linear-gradient(135deg, #b45309, #78350f);
        border: 2px solid #451a03;
        box-shadow: inset 0 0 8px rgba(0,0,0,0.4);
    }
    .cover-left {
        left: 0;
        border-radius: 8px 2px 2px 8px;
        transform-origin: right center;
        transform: rotateY(-15deg);
    }
    .cover-right {
        right: 0;
        border-radius: 2px 8px 8px 2px;
        transform-origin: left center;
        transform: rotateY(15deg);
    }

    /* Tulang Belakang Buku */
    .spine-3d {
        position: absolute;
        left: 50%;
        width: 8px;
        height: 102px;
        top: -1px;
        background: #451a03;
        transform: translateX(-50%) translateZ(-2px);
        border-radius: 2px;
    }

    /* Lembaran Kertas Berlapis Mekanis */
    .page-layer {
        position: absolute;
        top: 4px;
        width: 64px;
        height: 92px;
        border: 2.5px solid #1e293b;
        transform-style: preserve-3d;
        box-shadow: inset -2px 0 5px rgba(0,0,0,0.05);
    }

    /* Skenario Animasi Halaman Berputar Estetik (Cubic Bezier Anti Patah) */
    .page-1 {
        right: 4px;
        border-radius: 2px 6px 6px 2px;
        transform-origin: left center;
        animation: flipPage3D 2.4s infinite cubic-bezier(0.4, 0, 0.2, 1);
        animation-delay: 0s;
        z-index: 4;
    }
    .page-2 {
        right: 4px;
        border-radius: 2px 6px 6px 2px;
        transform-origin: left center;
        animation: flipPage3D 2.4s infinite cubic-bezier(0.4, 0, 0.2, 1);
        animation-delay: 0.6s;
        z-index: 3;
    }
    .page-3 {
        right: 4px;
        border-radius: 2px 6px 6px 2px;
        transform-origin: left center;
        animation: flipPage3D 2.4s infinite cubic-bezier(0.4, 0, 0.2, 1);
        animation-delay: 1.2s;
        z-index: 2;
    }
    .page-4 {
        right: 4px;
        border-radius: 2px 6px 6px 2px;
        transform-origin: left center;
        animation: flipPage3D 2.4s infinite cubic-bezier(0.4, 0, 0.2, 1);
        animation-delay: 1.8s;
        z-index: 1;
    }

    /* --- KEYFRAMES ENGINE --- */
    @keyframes flipPage3D {
        0% {
            transform: rotateY(0deg);
            background-color: var(--tw-bg-opacity); /* Warna asli kanan */
        }
        50% {
            transform: rotateY(-172deg);
            background-color: #fef08a; /* Berubah sedikit eksotik pas di tengah */
        }
        100% {
            transform: rotateY(-172deg);
        }
    }

    @keyframes floatBook {
        0%, 100% { transform: rotateX(25deg) rotateY(-10deg) translateY(0px); }
        50% { transform: rotateX(22deg) rotateY(-8deg) translateY(-10px); }
    }

    /* Efek Bayangan Realistis di Bawah Buku */
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

    /* Animasi Titik Berjalan (...) */
    .loading-dots::after {
        content: '.';
        animation: dots 1.5s infinite steps(4, end);
    }
    @keyframes dots {
        0%, 20% { content: '.'; }
        40% { content: '..'; }
        60% { content: '...'; }
        80%, 100% { content: ''; }
    }
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
    .animate-shake { animation: shake 0.3s ease-in-out; }
</style>

{{-- SCRIPT SISTEM KONTROL STATE - ARCHITECTURE LEVEL BY PRO DEVELOPER --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const leftPanel = document.getElementById("left-panel");
        const rightPanel = document.getElementById("right-panel");
        const loginForm = document.getElementById("login-form");
        const errorContainer = document.getElementById("error-container");
        const errorText = document.getElementById("error-text");
        const submitBtn = document.getElementById("submit-btn");
        const btnText = document.getElementById("btn-text");

        // 1. ANIMASI MASUK AWAL
        setTimeout(() => {
            if (leftPanel) {
                leftPanel.classList.remove("-translate-x-full", "opacity-0");
                leftPanel.classList.add("translate-x-0", "opacity-100");
            }
            if (rightPanel) {
                rightPanel.classList.remove("translate-x-full", "opacity-0");
                rightPanel.classList.add("translate-x-0", "opacity-100");
            }
        }, 50);

// 2. MANAGEMENT STATE AUTHENTICATION
if (loginForm) {
    loginForm.addEventListener("submit", function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        
        if (!loginForm.checkValidity()) return;

        // Reset & Loading State
        if (errorContainer) errorContainer.classList.add("hidden");
        if (submitBtn && btnText) {
            submitBtn.disabled = true;
            btnText.innerText = "Memverifikasi...";
            submitBtn.style.opacity = "0.7";
        }

        const formData = new FormData(loginForm);
        
        fetch(loginForm.action, {
            method: 'POST',
            body: formData, // FormData otomatis menangani content-type
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(async response => {
            // Ambil data respon (JSON)
            const data = await response.json();
            console.log("Respon Server:", data); // <--- CEK INI DI CONSOLE F12

            // Skenario Sukses
            if (response.ok) {
                executeSuccessRedirect(data.redirect || '/dashboard');
                return;
            }

            // Skenario Gagal
            resetSubmitButton();

            // 1. Tentukan pesan error
            let pesanError = "Email atau password yang Anda masukkan salah.";
            
            // Prioritas: Pesan dari Laravel Validate (errors) atau pesan custom (message)
            if (data.errors) {
                const firstKey = Object.keys(data.errors)[0];
                pesanError = data.errors[firstKey][0];
            } else if (data.message) {
                pesanError = data.message;
            }

            // 2. Tampilkan ke UI
            if (errorText) {
                errorText.innerText = pesanError; // Memasukkan teks
            }
            
            if (errorContainer) {
                errorContainer.classList.remove("hidden"); // Memunculkan box
                
                // Animasi Shake
                const panel = document.getElementById("right-panel");
                if (panel) {
                    panel.classList.add('animate-shake');
                    setTimeout(() => panel.classList.remove('animate-shake'), 500);
                }
            }
        })
        .catch(err => {
            console.error("Fetch Error:", err);
            resetSubmitButton();
        });
    });
}

        // 🔥 FUNGSI HELPERS YANG DI-UPGRADE KE LEVEL INTERAKTIF SENIOR (30 YEARS SKILL) 🔥
        function executeSuccessRedirect(targetUrl) {
            const bookLoading = document.getElementById("book-loading");

            // 1. Eksekusi geser keluar panel kanan dan kiri dengan transisi smooth
            if (leftPanel) leftPanel.style.transitionDuration = '400ms';
            if (rightPanel) rightPanel.style.transitionDuration = '400ms';

            if (leftPanel) {
                leftPanel.classList.remove("translate-x-0", "opacity-100");
                leftPanel.classList.add("-translate-x-full", "opacity-0");
            }
            if (rightPanel) {
                rightPanel.classList.remove("translate-x-0", "opacity-100");
                rightPanel.classList.add("translate-x-full", "opacity-0");
            }

            // 2. Munculkan overlay loading buku tepat di tengah-tengah slide panel (200ms)
            setTimeout(() => {
                if (bookLoading) {
                    bookLoading.classList.remove("opacity-0", "pointer-events-none");
                    bookLoading.classList.add("opacity-100");
                }
            }, 200);

            // 3. Tahan sejenak untuk memberikan visualisasi loading fun (1.5 detik) sebelum land ke dashboard
            setTimeout(() => {
                window.location.href = targetUrl;
            }, 1800);
        }

        function resetSubmitButton() {
            if (submitBtn && btnText) {
                submitBtn.disabled = false;
                btnText.innerText = "Masuk";
                submitBtn.style.opacity = "1";
            }
        }

        // 3. ANIMASI UTK LINK DAFTAR
        const regLink = document.getElementById("register-link");
        if (regLink) {
            regLink.addEventListener("click", function (e) {
                e.preventDefault();
                const target = this.href;

                if (leftPanel) leftPanel.style.transitionDuration = '250ms';
                if (rightPanel) rightPanel.style.transitionDuration = '250ms';

                if (leftPanel) leftPanel.classList.add("-translate-x-full", "opacity-0");
                if (rightPanel) rightPanel.classList.add("translate-x-full", "opacity-0");

                setTimeout(() => { window.location.href = target; }, 250);
            });
        }
    });
</script>
@endsection