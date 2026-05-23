@extends('layouts.app')

@push('styles')
<style>
    /* Racikan Animasi Masuk Smooth Entry */
    @keyframes smoothFadeInUp {
        0% {
            opacity: 0;
            transform: translateY(30px) scale(0.98);
            filter: blur(4px);
        }
        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
            filter: blur(0);
        }
    }

    .form-animate {
        opacity: 0;
        animation: smoothFadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        animation-delay: var(--d);
    }
</style>
@endpush

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <div class="form-animate mb-6 text-left" style="--d: 100ms;">
        <a href="{{ route('users.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-blue-600 transition-colors duration-200">
            ⬅️ Kembali ke Daftar Anggota
        </a>
    </div>

    <div class="form-animate w-full pb-6 border-b border-slate-100 text-left mb-10" style="--d: 150ms;">
        <h2 class="text-2xl sm:text-3xl font-black text-slate-800 tracking-tight">Tambah <span class="text-blue-600">Anggota Baru</span></h2>
        <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">Daftarkan akun pengguna baru ke dalam sistem aplikasi perpustakaan PinjamBuku.</p>
    </div>

    <div class="form-animate bg-white shadow-xl shadow-slate-100/40 rounded-[2rem] border border-slate-100 p-8 sm:p-10 text-left" style="--d: 200ms;">
        
        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <div class="space-y-6">
                <div>
                    <label for="name" class="block text-xs font-black text-slate-400 uppercase tracking-wider mb-2">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200/80 rounded-xl text-sm font-semibold text-slate-700 placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 transition-all duration-200"
                        placeholder="Masukkan nama lengkap anggota...">
                    @error('name')
                        <p class="text-xs text-rose-500 font-semibold mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-xs font-black text-slate-400 uppercase tracking-wider mb-2">Alamat Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200/80 rounded-xl text-sm font-semibold text-slate-700 placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 transition-all duration-200"
                        placeholder="contoh: anggota@gmail.com">
                    @error('email')
                        <p class="text-xs text-rose-500 font-semibold mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-xs font-black text-slate-400 uppercase tracking-wider mb-2">Password Akun</label>
                    <input type="password" name="password" id="password" required
                        class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200/80 rounded-xl text-sm font-semibold text-slate-700 placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 transition-all duration-200"
                        placeholder="Minimal 8 karakter...">
                    @error('password')
                        <p class="text-xs text-rose-500 font-semibold mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="role" class="block text-xs font-black text-slate-400 uppercase tracking-wider mb-2">Hak Akses (Role)</label>
                    <div class="relative">
                        <select name="role" id="role" required
                            class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200/80 rounded-xl text-sm font-semibold text-slate-700 focus:outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10 transition-all duration-200 appearance-none">
                            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User (Anggota Biasa)</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin (Pengelola)</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-slate-400">
                            ▼
                        </div>
                    </div>
                    @error('role')
                        <p class="text-xs text-rose-500 font-semibold mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 mt-10 pt-6 border-t border-slate-100">
                <a href="{{ route('users.index') }}" 
                    class="px-6 py-3 bg-slate-50 hover:bg-slate-100 text-slate-600 text-xs font-black tracking-wider uppercase rounded-xl border border-slate-200 transition-all duration-200">
                    Batal
                </a>
                <button type="submit" 
                    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white text-xs font-black tracking-wider uppercase rounded-xl border border-blue-700 shadow-md hover:shadow-xl hover:-translate-y-0.5 active:scale-95 transition-all duration-300">
                    💾 Simpan Anggota
                </button>
            </div>

        </form>
    </div>

</div>
@endsection