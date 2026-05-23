@extends('layouts.app')

@push('styles')
<style>
    /* ==========================================================================
       1. ANIMASI MASUK CINEMATIC FLUID BLUR
       ========================================================================== */
    @keyframes cinematicEntrance {
        0% {
            opacity: 0;
            transform: translateY(30px) scale(0.98);
            filter: blur(10px);
        }
        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
            filter: blur(0);
        }
    }

    .wow-entrance {
        opacity: 0;
        animation: cinematicEntrance 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        animation-delay: var(--delay, 100ms);
    }

    /* ==========================================================================
       2. CSS UNTUK PARTIKEL KURSOR SPARKLE BINTANG
       ========================================================================== */
    .sparkle-particle {
        position: fixed;
        pointer-events: none;
        background: radial-gradient(circle, rgba(255,255,255,1) 0%, rgba(59,130,246,1) 40%, rgba(59,130,246,0) 80%);
        border-radius: 50%;
        mix-blend-mode: screen;
        z-index: 99999;
        transition: transform 0.1s linear, opacity 0.4s ease-out;
        will-change: transform, opacity;
    }
</style>
@endpush

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 py-8">
    
<div class="w-full text-left mb-8">
        <div class="wow-entrance mb-4" style="--delay: 100ms;">
            <a href="{{ route('books.index') }}" class="inline-flex items-center px-4 py-2 bg-white hover:bg-slate-50 text-slate-600 hover:text-blue-600 text-xs font-black tracking-wider uppercase rounded-xl border border-slate-200 shadow-sm transition-all duration-300">
                ⬅️ Kembali ke Katalog Buku
            </a>
        </div>

        <div class="wow-entrance pb-4 border-b border-slate-100" style="--delay: 150ms;">
            <h2 class="text-2xl sm:text-3xl font-black text-slate-800 tracking-tight">Tambah <span class="text-blue-600">Buku Baru</span></h2>
            <p class="text-xs sm:text-sm text-slate-400 font-medium mt-1">Masukkan data arsip, kategori, dan stok buku ke dalam perpustakaan.</p>
        </div>
    </div>

    <div class="wow-entrance bg-white shadow-2xl shadow-slate-200/50 rounded-[2rem] border border-slate-100 p-8 sm:p-10 text-left" style="--delay: 200ms;">
        
        <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 gap-6">
                
                <div>
                    <label for="title" class="block text-xs font-black text-slate-400 uppercase tracking-wider mb-2">Judul Lengkap Buku</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                        class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200/80 rounded-xl text-sm font-semibold text-slate-700 placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 transition-all duration-200"
                        placeholder="Contoh: Atomic Habits...">
                    @error('title')
                        <p class="text-xs text-rose-500 font-semibold mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label filter="author" class="block text-xs font-black text-slate-400 uppercase tracking-wider mb-2">Penulis / Author</label>
                    <input type="text" name="author" id="author" value="{{ old('author') }}" required
                        class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200/80 rounded-xl text-sm font-semibold text-slate-700 placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 transition-all duration-200"
                        placeholder="Nama penulis buku...">
                    @error('author')
                        <p class="text-xs text-rose-500 font-semibold mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="publisher" class="block text-xs font-black text-slate-400 uppercase tracking-wider mb-2">Penerbit / Publisher</label>
                    <input type="text" name="publisher" id="publisher" value="{{ old('publisher') }}" required
                        class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200/80 rounded-xl text-sm font-semibold text-slate-700 placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 transition-all duration-200"
                        placeholder="Nama perusahaan penerbit...">
                    @error('publisher')
                        <p class="text-xs text-rose-500 font-semibold mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="category_id" class="block text-xs font-black text-slate-400 uppercase tracking-wider mb-2">Kategori Buku</label>
                    <div class="relative">
                        <select name="category_id" id="category_id" required
                            class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200/80 rounded-xl text-sm font-semibold text-slate-700 focus:outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 transition-all duration-200 appearance-none">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-slate-400">▼</div>
                    </div>
                </div>

                <div>
                    <label for="stock" class="block text-xs font-black text-slate-400 uppercase tracking-wider mb-2">Jumlah Sisa Stok</label>
                    <input type="number" name="stock" id="stock" value="{{ old('stock', 1) }}" min="0" required
                        class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200/80 rounded-xl text-sm font-semibold text-slate-700 focus:outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 transition-all duration-200"
                        placeholder="0">
                </div>

                <div>
                    <label for="image" class="block text-xs font-black text-slate-400 uppercase tracking-wider mb-2">Upload File Gambar Cover</label>
                    <input type="file" name="image" id="image" accept="image/*"
                        class="w-full px-5 py-3 bg-slate-50 border border-slate-200/80 rounded-xl text-xs font-bold text-slate-500 file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-black file:uppercase file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all duration-200">
                </div>

            </div>

            <div class="flex items-center justify-start gap-4 mt-8 pt-6 border-t border-slate-100">
                <button type="submit" 
                    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white text-xs font-black tracking-wider uppercase rounded-xl border border-blue-700 shadow-md hover:shadow-xl hover:-translate-y-0.5 active:scale-95 transition-all duration-300">
                    💾 Simpan Buku Baru
                </button>
                <a href="{{ route('books.index') }}" 
                    class="px-6 py-3 bg-slate-50 hover:bg-slate-100 text-slate-600 text-xs font-black tracking-wider uppercase rounded-xl border border-slate-200 transition-all duration-200">
                    Batal
                </a>
            </div>

        </form>
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // ------------------------------------------------------------------
        // JAVASCRIPT ANIMASI KURSOR SPARKLE BINTANG BERKILAU
        // ------------------------------------------------------------------
        const createSparkle = (x, y) => {
            const particle = document.createElement('div');
            particle.classList.add('sparkle-particle');
            
            const size = Math.random() * 6 + 4;
            particle.style.width = `${size}px`;
            particle.style.height = `${size}px`;
            
            particle.style.left = `${x}px`;
            particle.style.top = `${y}px`;
            
            document.body.appendChild(particle);
            
            const destinationX = (Math.random() - 0.5) * 60;
            const destinationY = (Math.random() - 0.5) * 60;
            
            setTimeout(() => {
                particle.style.transform = `translate(${destinationX}px, ${destinationY}px) scale(0)`;
                particle.style.opacity = '0';
            }, 10);
            
            setTimeout(() => {
                particle.remove();
            }, 400);
        };

        let lastMove = 0;
        window.addEventListener('mousemove', (e) => {
            const now = Date.now();
            if (now - lastMove > 25) {
                createSparkle(e.clientX, e.clientY);
                lastMove = now;
            }
        });
    });
</script>
@endpush