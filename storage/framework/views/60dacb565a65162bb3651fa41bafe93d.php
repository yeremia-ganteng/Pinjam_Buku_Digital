

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<style>
    /* Staggered Delay System biar menu muncul satu per satu bergantian */
        .delay-card-1 { animation-delay: 0.1s; }
        .delay-card-2 { animation-delay: 0.2s; }
        .delay-card-3 { animation-delay: 0.3s; }
        .delay-card-4 { animation-delay: 0.4s; }
        .delay-content-1 { animation-delay: 0.5s; }
        .delay-content-2 { animation-delay: 0.6s; }
    /* Racikan Animasi Masuk Smooth Entry Tanpa Blunder */
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

    /* Base class wajib menggunakan forward agar tidak balik transparan */
    .stagger-animate {
        opacity: 0;
        animation: smoothFadeInUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        animation-delay: var(--d);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <div class="stagger-animate w-full flex flex-row items-center justify-between gap-6 pb-6 border-b border-slate-100 text-left" style="--d: 100ms;">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl sm:text-3xl font-black text-slate-800 tracking-tight">Admin <span class="text-blue-600">Control Panel</span></h2>
            <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">Sistem Pemantauan Sirkulasi dan Data Perpustakaan PinjamBuku.</p>
        </div>
        <div class="flex-shrink-0">
            <span class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 text-xs font-black tracking-wider uppercase rounded-xl border border-blue-100 shadow-sm">
                🛡️ Administrator Mode
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-16">
        <div class="stagger-animate bg-white p-6 rounded-[2rem] border border-slate-100 shadow-lg shadow-slate-100/40 flex items-center hover:shadow-2xl hover:-translate-y-2 hover:border-blue-200 active:scale-95 transition-all duration-300 cursor-pointer text-left" style="--d: 200ms;">
            <div class="p-4 bg-blue-50 text-blue-600 rounded-2xl mr-4 flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"></path></svg>
            </div>
            <div>
                <p class="text-[11px] font-black text-slate-400 uppercase tracking-wider">Total Buku</p>
                <h3 class="text-2xl font-black text-slate-800 mt-0.5"><?php echo e($totalBuku); ?></h3>
            </div>
        </div>

        <div class="stagger-animate bg-white p-6 rounded-[2rem] border border-slate-100 shadow-lg shadow-slate-100/40 flex items-center hover:shadow-2xl hover:-translate-y-2 hover:border-amber-200 active:scale-95 transition-all duration-300 cursor-pointer text-left" style="--d: 300ms;">
            <div class="p-4 bg-amber-50 text-amber-600 rounded-2xl mr-4 flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008z"></path></svg>
            </div>
            <div>
                <p class="text-[11px] font-black text-slate-400 uppercase tracking-wider">Sedang Dipinjam</p>
                <h3 class="text-2xl font-black text-slate-800 mt-0.5"><?php echo e($peminjamanAktif); ?></h3>
            </div>
        </div>

        <div class="stagger-animate bg-white p-6 rounded-[2rem] border border-slate-100 shadow-lg shadow-slate-100/40 flex items-center hover:shadow-2xl hover:-translate-y-2 hover:border-purple-200 active:scale-95 transition-all duration-300 cursor-pointer text-left" style="--d: 400ms;">
            <div class="p-4 bg-purple-50 text-purple-600 rounded-2xl mr-4 flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"></path></svg>
            </div>
            <div>
                <p class="text-[11px] font-black text-slate-400 uppercase tracking-wider">Total Anggota</p>
                <h3 class="text-2xl font-black text-slate-800 mt-0.5"><?php echo e($totalUser); ?></h3>
            </div>
        </div>

        <div class="stagger-animate bg-white p-6 rounded-[2rem] border border-slate-100 shadow-lg shadow-slate-100/40 flex items-center hover:shadow-2xl hover:-translate-y-2 hover:border-rose-200 active:scale-95 transition-all duration-300 cursor-pointer text-left" style="--d: 500ms;">
            <div class="p-4 bg-rose-50 text-rose-600 rounded-2xl mr-4 flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.214.123a3.424 3.424 0 005.071-2.926c0-1.229-.912-2.308-2.124-2.52l-2.322-.404a2.766 2.766 0 01-2.124-2.52c0-1.514 1.161-2.84 2.675-2.926L12 3m0 3v1c0 1.23.912 2.308 2.124 2.52l2.322.404a2.766 2.766 0 012.124 2.52c0 1.514-1.161 2.84-2.675 2.926L12 18"></path></svg>
            </div>
            <div>
                <p class="text-[11px] font-black text-slate-400 uppercase tracking-wider">Kas Denda</p>
                <h3 class="text-2xl font-black text-slate-800 mt-0.5">Rp <?php echo e(number_format($totalDendaMasuk, 0, ',', '.')); ?></h3>
            </div>
        </div>
    </div>

    <div class="stagger-animate bg-white p-8 rounded-[2rem] border border-slate-100 shadow-xl shadow-slate-100/30 mt-16" style="--d: 600ms;">
        <div class="mb-6 text-left">
            <h4 class="font-black text-slate-800 tracking-tight text-sm uppercase">Akses Kontrol CRUD Data Perpustakaan</h4>
            <p class="text-[11px] text-slate-400 font-semibold mt-0.5">Pilih modul di bawah untuk mengelola database perpustakaan secara real-time.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <a href="<?php echo e(route('books.index')); ?>" class="stagger-animate group flex items-center justify-between p-5 bg-slate-50 hover:bg-blue-600 text-slate-700 hover:text-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-2 active:scale-95 transition-all duration-300" style="--d: 700ms;">
                <div class="flex items-center gap-4">
                    <span class="text-2xl group-hover:scale-110 transition-transform duration-300">📚</span>
                    <div class="flex flex-col text-left">
                        <span class="text-xs font-black tracking-wider uppercase">Katalog Buku</span>
                        <span class="text-[10px] opacity-70 font-medium group-hover:text-blue-100 mt-0.5">Kelola data & stok buku</span>
                    </div>
                </div>
                <svg class="w-4 h-4 opacity-50 group-hover:opacity-100 group-hover:translate-x-1.5 transition-all duration-300" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"></path></svg>
            </a>

            <a href="<?php echo e(route('users.index')); ?>" class="stagger-animate group flex items-center justify-between p-5 bg-slate-50 hover:bg-blue-600 text-slate-700 hover:text-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-2 active:scale-95 transition-all duration-300" style="--d: 800ms;">
                <div class="flex items-center gap-4">
                    <span class="text-2xl group-hover:scale-110 transition-transform duration-300">👥</span>
                    <div class="flex flex-col text-left">
                        <span class="text-xs font-black tracking-wider uppercase">Data Anggota</span>
                        <span class="text-[10px] opacity-70 font-medium group-hover:text-blue-100 mt-0.5">Kelola akun & role user</span>
                    </div>
                </div>
                <svg class="w-4 h-4 opacity-50 group-hover:opacity-100 group-hover:translate-x-1.5 transition-all duration-300" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"></path></svg>
            </a>

            <a href="<?php echo e(route('borrows.index')); ?>" class="stagger-animate group flex items-center justify-between p-5 bg-slate-50 hover:bg-blue-600 text-slate-700 hover:text-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-2 active:scale-95 transition-all duration-300" style="--d: 900ms;">
                <div class="flex items-center gap-4">
                    <span class="text-2xl group-hover:scale-110 transition-transform duration-300">🔄</span>
                    <div class="flex flex-col text-left">
                        <span class="text-xs font-black tracking-wider uppercase">Sirkulasi Pinjaman</span>
                        <span class="text-[10px] opacity-70 font-medium group-hover:text-blue-100 mt-0.5">Proses pinjam, kembali & denda</span>
                    </div>
                </div>
                <svg class="w-4 h-4 opacity-50 group-hover:opacity-100 group-hover:translate-x-1.5 transition-all duration-300" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"></path></svg>
            </a>
        </div>
    </div>

    <div class="stagger-animate bg-white shadow-xl shadow-slate-100/40 rounded-[2rem] overflow-hidden border border-slate-100 mt-16" style="--d: 1050ms;">
        <div class="px-6 py-5 bg-slate-50/60 border-b border-slate-100 flex items-center justify-between">
            <h4 class="font-black text-slate-800 tracking-tight text-sm uppercase">Log Transaksi Peminjaman Global</h4>
            <span class="px-2.5 py-1 bg-white text-slate-500 text-[9px] font-black tracking-wider uppercase rounded-lg border border-slate-200 shadow-sm">
                Live Data
            </span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead>
                    <tr class="bg-slate-50/20">
                        <th class="py-4 px-6 sm:px-8 text-left text-xs font-black text-slate-400 uppercase tracking-wider">Nama Anggota</th>
                        <th class="py-4 px-6 sm:px-8 text-left text-xs font-black text-slate-400 uppercase tracking-wider">Buku Yang Dipinjam</th>
                        <th class="py-4 px-6 sm:px-8 text-left text-xs font-black text-slate-400 uppercase tracking-wider">Tgl Pinjam</th>
                        <th class="py-4 px-6 sm:px-8 text-left text-xs font-black text-slate-400 uppercase tracking-wider">Status</th>
                        <th class="py-4 px-6 sm:px-8 text-left text-xs font-black text-slate-400 uppercase tracking-wider">Denda Record</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    <?php $__empty_1 = true; $__currentLoopData = $allBorrows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-slate-50/40 transition-colors duration-150">
                            <td class="py-4 px-6 sm:px-8 font-bold text-slate-700 text-sm whitespace-nowrap text-left"><?php echo e($b->user->name ?? 'User Terhapus'); ?></td>
                            <td class="py-4 px-6 sm:px-8 font-semibold text-slate-600 text-sm text-left"><?php echo e($b->book->title ?? 'Buku Terhapus'); ?></td>
                            <td class="py-4 px-6 sm:px-8 text-slate-500 text-xs font-medium whitespace-nowrap text-left"><?php echo e(\Carbon\Carbon::parse($b->borrow_date)->format('d M Y')); ?></td>
                            <td class="py-4 px-6 sm:px-8 whitespace-nowrap text-left">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black tracking-wide uppercase
                                    <?php echo e(Str::lower($b->status) === 'dipinjam' ? 'bg-blue-100 text-blue-700' : 'bg-slate-100 text-slate-600'); ?>">
                                    <?php echo e($b->status); ?>

                                </span>
                            </td>
                            <td class="py-4 px-6 sm:px-8 font-black text-xs whitespace-nowrap text-left <?php echo e($b->denda > 0 ? 'text-rose-600' : 'text-slate-400'); ?>">
                                <?php echo e($b->denda > 0 ? 'Rp ' . number_format($b->denda, 0, ',', '.') : '-'); ?>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-400 font-medium text-sm">Belum ada data sirkulasi peminjaman.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-16"> 
            
            <?php if($allBorrows->hasPages()): ?>
                <div class="px-6 sm:px-8 py-4 border-t border-slate-100 bg-slate-50/30">
                    <?php echo e($allBorrows->links('vendor.pagination.tailwind')); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\yere\Herd\pinjam-buku\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>