

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
    
    <div class="stagger-animate w-full flex flex-col md:flex-row md:items-center justify-between gap-6 pb-6 border-b border-slate-100 text-left" style="--d: 100ms;">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl sm:text-3xl font-black text-slate-800 tracking-tight">Daftar <span class="text-blue-600">Anggota Perpustakaan</span></h2>
            <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">Kelola data pengguna, hak akses sistem, serta status keaktifan keanggotaan perpustakaan.</p>
            
            <div class="mt-4">
                <a href="<?php echo e(route('users.create')); ?>" class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-black tracking-wider uppercase rounded-xl border border-blue-700 shadow-md hover:shadow-xl hover:-translate-y-1 active:scale-95 transition-all duration-300">
                    ➕ Tambah Anggota Baru
                </a>
            </div>
        </div>
        
        <div class="flex-shrink-0 hidden md:block">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-black tracking-wider uppercase rounded-xl border border-blue-700 shadow-md transition-all duration-300">
                🏠 Kembali ke Dashboard
            </a>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="stagger-animate mt-6 flex items-center justify-between p-4 bg-emerald-50/80 border border-emerald-200/60 rounded-2xl shadow-sm shadow-emerald-100/20 text-left" style="--d: 200ms;">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center text-sm shadow-sm shadow-emerald-500/20">
                    ✓
                </div>
                <div>
                    <h5 class="text-sm font-black text-emerald-900 leading-none">Tindakan Sukses</h5>
                    <p class="text-xs text-emerald-600 font-semibold mt-0.5"><?php echo e(session('success')); ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="stagger-animate bg-white shadow-xl shadow-slate-100/40 rounded-[2rem] overflow-hidden border border-slate-100 mt-16" style="--d: 300ms;">
        <div class="px-6 py-5 bg-slate-50/60 border-b border-slate-100 flex items-center justify-between">
            <h4 class="font-black text-slate-800 tracking-tight text-sm uppercase">Database Pengguna</h4>
            <span class="px-2.5 py-1 bg-white text-slate-500 text-[9px] font-black tracking-wider uppercase rounded-lg border border-slate-200 shadow-sm">
                Total: <?php echo e($users->count()); ?> Orang
            </span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead>
                    <tr class="bg-slate-50/20">
                        <th class="py-4 px-6 sm:px-8 text-left text-xs font-black text-slate-400 uppercase tracking-wider w-28">ID User</th>
                        <th class="py-4 px-6 sm:px-8 text-left text-xs font-black text-slate-400 uppercase tracking-wider">Nama Lengkap</th>
                        <th class="py-4 px-6 sm:px-8 text-left text-xs font-black text-slate-400 uppercase tracking-wider">Alamat Email</th>
                        <th class="py-4 px-6 sm:px-8 text-left text-xs font-black text-slate-400 uppercase tracking-wider w-40">Hak Akses / Role</th>
                        <th class="py-4 px-6 sm:px-8 text-center text-xs font-black text-slate-400 uppercase tracking-wider w-56">Aksi Operasional</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="stagger-animate hover:bg-slate-50/40 transition-colors duration-150" style="--d: <?php echo e(400 + ($index * 70)); ?>ms;">
                            <td class="py-4 px-6 sm:px-8 font-black text-slate-400 text-xs whitespace-nowrap text-left">#USR-<?php echo e($u->id); ?></td>
                            <td class="py-4 px-6 sm:px-8 font-bold text-slate-800 text-sm text-left"><?php echo e($u->name); ?></td>
                            <td class="py-4 px-6 sm:px-8 text-slate-600 text-sm text-left font-medium"><?php echo e($u->email); ?></td>
                            <td class="py-4 px-6 sm:px-8 whitespace-nowrap text-left">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black tracking-wide uppercase
                                    <?php echo e($u->role === 'admin' ? 'bg-indigo-100 text-indigo-700' : 'bg-slate-100 text-slate-700'); ?>">
                                    👤 <?php echo e($u->role ?? 'User'); ?>

                                </span>
                            </td>
                            
                            <td class="py-4 px-6 sm:px-8 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center gap-4">
                                    <a href="<?php echo e(route('users.edit', $u->id)); ?>" 
                                       class="inline-flex items-center px-4 py-2 bg-amber-50 hover:bg-amber-500 text-amber-700 hover:text-white text-xs font-black tracking-wider uppercase rounded-xl border border-amber-200 transition-all duration-200 hover:shadow-md hover:-translate-y-0.5">
                                        ✏️ Edit
                                    </a>
                                    
                                    <form action="<?php echo e(route('users.destroy', $u->id)); ?>" method="POST" class="inline form-delete">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="button" data-name="<?php echo e($u->name); ?>"
                                                class="btn-delete inline-flex items-center px-4 py-2 bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white text-xs font-black tracking-wider uppercase rounded-xl border border-rose-200 transition-all duration-200 hover:shadow-md hover:-translate-y-0.5">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr class="stagger-animate" style="--d: 400ms;">
                            <td colspan="5" class="py-12 text-center text-slate-400 font-medium text-sm">Belum ada data anggota perpustakaan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.btn-delete');
        
        deleteButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                const form = this.closest('.form-delete');
                const userName = this.getAttribute('data-name');
                
                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: `Akun anggota bernama "${userName}" akan dihapus permanen dari sistem!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e11d48',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Hapus Data!',
                    cancelButtonText: 'Batal',
                    background: '#ffffff',
                    customClass: {
                        popup: 'rounded-[2rem] border border-slate-100 shadow-2xl',
                        title: 'font-black text-slate-800 tracking-tight',
                        htmlContainer: 'font-medium text-slate-500 text-sm',
                        confirmButton: 'rounded-xl text-xs font-black tracking-wider uppercase px-4 py-2.5',
                        cancelButton: 'rounded-xl text-xs font-black tracking-wider uppercase px-4 py-2.5'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\yere\Herd\pinjam-buku\resources\views/admin/users/index.blade.php ENDPATH**/ ?>