<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - PinjamBuku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-md animate__animated animate__fadeInUp">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Buat Akun</h1>
            <p class="text-slate-500 mt-2">Daftar untuk mulai meminjam buku favoritmu.</p>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.04)] border border-slate-100 p-8 md:p-10">
            <form action="{{ route('register.store') }}" method="POST" class="space-y-5">
                @csrf
                
                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 ml-1">Nama Lengkap</label>
                    <input type="text" name="name" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-5 py-3.5 outline-none focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all font-semibold text-slate-700" placeholder="Masukkan nama Anda" required>
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 ml-1">Email</label>
                    <input type="email" name="email" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-5 py-3.5 outline-none focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all font-semibold text-slate-700" placeholder="nama@mail.com" required>
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 ml-1">Password</label>
                    <input type="password" name="password" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-5 py-3.5 outline-none focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all font-semibold text-slate-700" placeholder="••••••••" required>
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 ml-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-5 py-3.5 outline-none focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all font-semibold text-slate-700" placeholder="••••••••" required>
                </div>

                <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-4 rounded-2xl shadow-xl shadow-indigo-100 hover:bg-indigo-700 hover:scale-[1.02] active:scale-[0.98] transition-all mt-4">
                    Daftar Sekarang
                </button>
            </form>

            <div class="mt-8 text-center">
                <p class="text-sm text-slate-500 font-medium">Sudah punya akun? 
                    <a href="{{ route('login') }}" class="text-indigo-600 font-bold hover:underline">Login di sini</a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>