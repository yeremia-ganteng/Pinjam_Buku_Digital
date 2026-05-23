<!DOCTYPE html>
<html lang="id">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Animasi Masuk Menakjubkan */
        .reveal-up {
            opacity: 0;
            transform: translateY(40px) scale(0.95);
            transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal-up.active {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen p-8" x-data="{ showToast: {{ session('status') ? 'true' : 'false' }} }" x-init="setTimeout(() => showToast = false, 4000)">

    <div x-show="showToast" 
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 scale-90 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/20 backdrop-blur-sm" x-cloak>
        <div class="bg-white p-8 rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.15)] text-center w-full max-w-sm">
            <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl animate-bounce">✨</div>
            <h2 class="text-xl font-black text-slate-900">Berhasil!</h2>
            <p class="text-slate-500 font-bold mt-1 text-sm">Profil Anda telah diperbarui dengan sukses.</p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto reveal-up" :class="{'active': true}">
        <a href="{{ route('dashboard') }}" class="text-sm font-bold text-slate-400 hover:text-blue-600 transition-colors">&larr; Kembali</a>
        
        <h1 class="text-5xl font-black text-slate-900 mt-6 mb-12 tracking-tight">Edit Profil</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm text-center">
                <div class="relative inline-block p-1 bg-slate-100 rounded-full">
                    <img src="{{ auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar) : 'https://ui-avatars.com/api/?name='.auth()->user()->name }}" 
                         class="w-32 h-32 rounded-full object-cover shadow-inner">
                </div>
                <h2 class="mt-6 text-2xl font-black text-slate-900">{{ auth()->user()->name }}</h2>
            </div>

            <div class="md:col-span-2 bg-white p-10 rounded-[2rem] border border-slate-100 shadow-sm">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf @method('PATCH')
                    
                    <div>
                        <label class="text-[10px] font-black uppercase text-slate-400">Ganti Foto Profil</label>
                        <input type="file" name="avatar" class="w-full mt-2 p-4 bg-slate-50 rounded-2xl border border-slate-100 font-bold file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-blue-600 file:text-white file:font-bold hover:file:bg-blue-700">
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="text-[10px] font-black uppercase text-slate-400">Nama</label>
                            <input type="text" name="name" value="{{ auth()->user()->name }}" class="w-full mt-2 p-4 bg-slate-50 rounded-2xl border-none font-bold focus:ring-4 ring-blue-50">
                        </div>
                        <div>
                            <label class="text-[10px] font-black uppercase text-slate-400">Email</label>
                            <input type="email" name="email" value="{{ auth()->user()->email }}" class="w-full mt-2 p-4 bg-slate-50 rounded-2xl border-none font-bold focus:ring-4 ring-blue-50">
                        </div>
                    </div>

                    <button type="submit" class="w-full py-5 bg-slate-900 text-white font-black rounded-2xl hover:bg-blue-600 transition-all hover:shadow-2xl hover:shadow-blue-500/30 active:scale-95">
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>