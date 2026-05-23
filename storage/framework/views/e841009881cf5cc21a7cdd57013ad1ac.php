

<?php $__env->startPush('styles'); ?>
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

    /* Base class animasi wajib forward */
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
            <h2 class="text-2xl sm:text-3xl font-black text-slate-800 tracking-tight">Sirkulasi <span class="text-blue-600">Peminjaman Buku</span></h2>
            <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">Pantau transaksi peminjaman aktif, batas waktu pengembalian, serta manajemen denda keterlambatan.</p>
        </div>
        <div class="flex-shrink-0">
            <span class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 text-xs font-black tracking-wider uppercase rounded-xl border border-blue-100 shadow-sm">
                🔄 Live Circulation Log
            </span>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="stagger-animate p-4 mb-4 text-sm text-green-800 rounded-2xl bg-green-50 border border-green-100 mt-6 text-left" style="--d: 200ms;">
            <span class="font-bold">Sukses!</span> <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="stagger-animate bg-white shadow-xl shadow-slate-100/40 rounded-[2rem] overflow-hidden border border-slate-100 mt-16" style="--d: 300ms;">
        <div class="px-6 py-5 bg-slate-50/60 border-b border-slate-100 flex items-center justify-between">
            <h4 class="font-black text-slate-800 tracking-tight text-sm uppercase">Log Transaksi Peminjaman Global</h4>
            <span class="px-2.5 py-1 bg-white text-slate-500 text-[9px] font-black tracking-wider uppercase rounded-lg border border-slate-200 shadow-sm">
                Total: <?php echo e($borrows->count()); ?> Transaksi
            </span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead>
                    <tr class="bg-slate-50/20">
                        <th class="py-4 px-6 sm:px-8 text-left text-xs font-black text-slate-400 uppercase tracking-wider">Nama Anggota</th>
                        <th class="py-4 px-6 sm:px-8 text-left text-xs font-black text-slate-400 uppercase tracking-wider">Buku yang Dipinjam</th>
                        <th class="py-4 px-6 sm:px-8 text-left text-xs font-black text-slate-400 uppercase tracking-wider">Tgl Pinjam / Batas</th>
                        <th class="py-4 px-6 sm:px-8 text-left text-xs font-black text-slate-400 uppercase tracking-wider">Status</th>
                        <th class="py-4 px-6 sm:px-8 text-left text-xs font-black text-slate-400 uppercase tracking-wider">Denda Record</th>
                        <th class="py-4 px-6 sm:px-8 text-center text-xs font-black text-slate-400 uppercase tracking-wider">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    <?php $__empty_1 = true; $__currentLoopData = $borrows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        
                        <tr class="stagger-animate hover:bg-slate-50/40 transition-colors duration-150" style="--d: <?php echo e(400 + ($index * 70)); ?>ms;">
                            
                            <td class="py-4 px-6 sm:px-8 font-bold text-slate-700 text-sm whitespace-nowrap text-left">
                                <div class="font-bold text-slate-800"><?php echo e($b->user->name ?? 'User Terhapus'); ?></div>
                                <div class="text-[10px] text-slate-400 font-semibold mt-0.5"><?php echo e($b->user->email ?? '-'); ?></div>
                            </td>
                            
                            <td class="py-4 px-6 sm:px-8 font-semibold text-slate-600 text-sm text-left">
                                <div class="truncate max-w-xs font-bold text-slate-700">
                                    <?php echo e($b->book ? $b->book->title : 'Buku Tidak Ditemukan'); ?>

                                </div>
                                <div class="text-[10px] text-slate-400 mt-0.5">ID: #BK-<?php echo e($b->book_id ?? '-'); ?></div>
                            </td>
                            
                            <td class="py-4 px-6 sm:px-8 text-left whitespace-nowrap">
                                <div class="text-xs font-bold text-slate-600">📅 <?php echo e(\Carbon\Carbon::parse($b->borrow_date)->format('d M Y')); ?></div>
                                <div class="text-[10px] text-rose-500 font-medium mt-0.5">⏳ s/d <?php echo e($b->return_date ? \Carbon\Carbon::parse($b->return_date)->format('d M Y') : 'Belum Kembali'); ?></div>
                            </td>
                            
                            <td class="py-4 px-6 sm:px-8 whitespace-nowrap text-left">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black tracking-wide uppercase
                                    <?php echo e(Str::lower($b->status) === 'dipinjam' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700'); ?>">
                                    ● <?php echo e($b->status); ?>

                                </span>
                            </td>
                            
                            <td class="py-4 px-6 sm:px-8 font-black text-xs whitespace-nowrap text-left <?php echo e($b->denda > 0 ? 'text-rose-600' : 'text-slate-400'); ?>">
                                <?php echo e($b->denda > 0 ? 'Rp ' . number_format($b->denda, 0, ',', '.') : '-'); ?>

                            </td>
                            
                            <td class="py-4 px-6 sm:px-8 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center gap-4">
                                    <?php if(Str::lower($b->status) === 'dipinjam'): ?>
                                        <form action="<?php echo e(route('borrow.return', $b->id)); ?>" method="POST" class="inline">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-green-50 hover:bg-green-600 text-green-600 hover:text-white text-xs font-black tracking-wider uppercase rounded-xl border border-green-200 transition-all duration-200 hover:shadow-md hover:-translate-y-0.5">
                                                ↩️ Kembalikan
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <span class="text-xs font-bold text-slate-400">Selesai ✨</span>
                                    <?php endif; ?>
                                </div>
                            </td>

                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr class="stagger-animate" style="--d: 400ms;">
                            <td colspan="6" class="py-12 text-center text-slate-400 font-medium text-sm">Belum ada data riwayat sirkulasi peminjaman.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <?php if(method_exists($borrows, 'hasPages') && $borrows->hasPages()): ?>
            <div class="px-6 sm:px-8 py-4 border-t border-slate-100 bg-slate-50/30">
                <?php echo e($borrows->links()); ?>

            </div>
        <?php endif; ?>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\yere\Herd\pinjam-buku\resources\views/admin/borrows/index.blade.php ENDPATH**/ ?>