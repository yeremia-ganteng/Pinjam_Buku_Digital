<!DOCTYPE html>
<html lang="id">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen p-4 md:p-10">
    <div class="max-w-4xl mx-auto" x-data="{ openModal: false }">
        
        <a href="<?php echo e(route('dashboard')); ?>" class="inline-flex items-center text-sm font-bold text-slate-500 hover:text-blue-600 transition-all mb-6">
            &larr; Kembali ke Dashboard
        </a>

        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-slate-900">Profil & Status Pinjaman</h1>
            <p class="text-slate-500 font-medium">Informasi pribadi dan catatan pengembalian buku.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="md:col-span-1 bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex flex-col items-center">
                <div class="w-20 h-20 bg-blue-600 rounded-2xl flex items-center justify-center text-white text-3xl font-black mb-4 shadow-lg shadow-blue-200">
                    <?php echo e(substr(auth()->user()->name, 0, 1)); ?>

                </div>
                <h2 class="text-lg font-black text-slate-900 text-center"><?php echo e(auth()->user()->name); ?></h2>
                <p class="text-sm text-slate-500 text-center mb-6"><?php echo e(auth()->user()->email); ?></p>
                
                <button @click="openModal = true" class="w-full py-2.5 bg-slate-900 text-white font-bold text-sm rounded-xl hover:bg-blue-600 transition-colors">
                    Edit Profil
                </button>
            </div>

            <div class="md:col-span-2 space-y-4">
                <h2 class="font-black text-slate-800 text-lg flex items-center gap-2">
                    <span class="w-2 h-6 bg-blue-600 rounded-full"></span>
                    Status Peminjaman
                </h2>

                <?php $__empty_1 = true; $__currentLoopData = $lateBorrows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="bg-white p-5 rounded-3xl border-l-8 border-rose-500 shadow-sm flex justify-between items-center">
                        <div>
                            <span class="text-[10px] font-black text-rose-500 uppercase tracking-widest">🚨 Telat Dikembalikan</span>
                            <h3 class="font-bold text-slate-900 mt-1"><?php echo e($loan->book->title); ?></h3>
                            <p class="text-xs text-slate-400">Jatuh tempo: <?php echo e(\Carbon\Carbon::parse($loan->due_date)->format('d M Y')); ?></p>
                        </div>
                        <div class="text-right">
                            <span class="block text-2xl font-black text-rose-600">
                                <?php echo e(\Carbon\Carbon::parse($loan->due_date)->diffInDays(now())); ?>

                            </span>
                            <span class="text-[9px] font-bold text-slate-400 uppercase">Hari Telat</span>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="bg-emerald-50 border border-emerald-100 p-8 rounded-3xl text-center">
                        <div class="text-4xl mb-2">✨</div>
                        <h3 class="font-black text-emerald-800">Semua Aman!</h3>
                        <p class="text-sm text-emerald-600">Tidak ada buku yang melewati batas pengembalian.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div x-show="openModal" class="fixed inset-0 z-[999] flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm" x-cloak>
            <div class="bg-white p-8 rounded-3xl w-full max-w-md shadow-2xl" @click.away="openModal = false">
                <h3 class="text-xl font-black mb-6">Edit Profil & Avatar</h3>
                
                <form action="<?php echo e(route('profile.edit')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                    
                    <div class="mb-4">
                        <label class="text-[10px] font-black uppercase text-slate-400">Ganti Foto Profil</label>
                        <input type="file" name="avatar" class="w-full mt-2 p-3 bg-slate-50 rounded-xl text-sm font-bold border border-slate-200">
                    </div>

                    <div class="mb-4">
                        <label class="text-[10px] font-black uppercase text-slate-400">Nama Lengkap</label>
                        <input type="text" name="name" value="<?php echo e(auth()->user()->name); ?>" class="w-full mt-2 p-3 bg-slate-50 rounded-xl font-bold border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    <div class="flex gap-3 mt-8">
                        <button type="button" @click="openModal = false" class="flex-1 py-3 bg-slate-100 rounded-xl font-bold hover:bg-slate-200 transition-colors">Batal</button>
                        <button type="submit" class="flex-1 py-3 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition-colors">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</body>
</html><?php /**PATH C:\yere\Herd\pinjam-buku\resources\views/profile/show.blade.php ENDPATH**/ ?>