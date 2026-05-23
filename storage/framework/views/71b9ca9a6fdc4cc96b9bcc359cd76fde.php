

<?php $__env->startPush('styles'); ?>
<style>
    /* ==========================================================================
       1. ANIMASI MASUK CINEMATIC FLUID BLUR (WOW-ENTRANCE)
       ========================================================================== */
    @keyframes cinematicEntrance {
        0% {
            opacity: 0;
            transform: translateY(35px) scale(0.97);
            filter: blur(12px);
        }
        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
            filter: blur(0);
        }
    }

    .wow-entrance {
        opacity: 0;
        animation: cinematicEntrance 0.9s cubic-bezier(0.16, 1, 0.3, 1) forwards;
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    <div class="flex items-center justify-between mb-8 text-left">
        <div class="wow-entrance" style="--delay: 100ms;">
            <h2 class="text-3xl font-black text-slate-800 tracking-tight">Riwayat <span class="text-blue-600">Peminjaman</span></h2>
        </div>
        <div class="wow-entrance" style="--delay: 150ms;">
            <a href="<?php echo e(route('welcome')); ?>" class="text-sm font-bold text-blue-600 hover:text-indigo-700 flex items-center transition-all group">
                <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="wow-entrance mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center shadow-sm font-medium text-sm" style="--delay: 200ms;">
            <svg class="w-5 h-5 mr-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="wow-entrance bg-white shadow-2xl shadow-blue-100/50 rounded-[2.5rem] overflow-hidden border border-slate-50 text-left" style="--delay: 250ms;">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="py-6 px-8 text-left text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Judul Buku</th>
                        <th class="py-6 px-8 text-left text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Tanggal Pinjam</th>
                        <th class="py-6 px-8 text-left text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Tanggal Kembali</th>
                        <th class="py-6 px-8 text-left text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Status</th>
                        <th class="py-6 px-8 text-left text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php $__empty_1 = true; $__currentLoopData = $borrows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $borrow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-blue-50/30 transition-colors group">
                            <td class="py-6 px-8">
                                <div class="flex items-center">
                                    <div class="w-10 h-14 bg-slate-100 rounded-lg mr-4 overflow-hidden flex-shrink-0 shadow-sm border border-slate-100">
                                        <img src="<?php echo e(asset('storage/' . $borrow->book->image)); ?>" class="w-full h-full object-cover" onerror="this.src='https://images.unsplash.com/photo-1543002588-bfa74002ed7e?q=80&w=100'">
                                    </div>
                                    <span class="font-bold text-slate-700 group-hover:text-blue-600 transition-colors data-judul"><?php echo e($borrow->book->title); ?></span>
                                </div>
                            </td>
                            <td class="py-6 px-8 text-slate-500 font-medium">
                                <?php echo e(\Carbon\Carbon::parse($borrow->borrow_date)->format('d M Y')); ?>

                            </td>
                            <td class="py-6 px-8 text-slate-500 font-medium">
                                <?php echo e(\Carbon\Carbon::parse($borrow->return_date)->format('d M Y')); ?>

                            </td>
                            <td class="py-6 px-8">
                                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-black tracking-wide
                                    <?php echo e(Str::lower($borrow->status) === 'dipinjam' ? 'bg-blue-100 text-blue-700' : 'bg-emerald-100 text-emerald-700'); ?>">
                                    <span class="w-2 h-2 rounded-full mr-2 <?php echo e(Str::lower($borrow->status) === 'dipinjam' ? 'bg-blue-500' : 'bg-emerald-500'); ?>"></span>
                                    <?php echo e($borrow->status); ?>

                                </span>
                            </td>
                            <td class="py-6 px-8">
                                <?php if(Str::lower($borrow->status) === 'dipinjam'): ?>
                                    
                                    <form action="<?php echo e(route('borrow.return', $borrow->id)); ?>" method="POST" class="form-kembalikan">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl transition duration-200 shadow-sm hover:shadow shadow-blue-200 hover:-translate-y-0.5 active:scale-95">
                                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.066 11.2a1 1 0 000 1.6l5.334 4A1 1 0 0019 16V8a1 1 0 00-1.6-.8l-5.334 4z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12h8"></path>
                                            </svg>
                                            Kembalikan
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-xs font-bold text-slate-400 italic">
                                        Selesai Dikembalikan
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="py-20 px-8 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"></path>
                                        </svg>
                                    </div>
                                    <p class="text-slate-400 font-medium text-lg">Belum ada riwayat peminjaman.</p>
                                    <a href="<?php echo e(route('welcome')); ?>" class="mt-4 text-blue-600 font-bold hover:underline">Pinjam buku pertamamu sekarang →</a>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // ------------------------------------------------------------------
        // MODERN INTERCEPTOR FOR RETURN CONFIRMATION (SWEETALERT2 PERFECTED)
        // ------------------------------------------------------------------
        const returnForms = document.querySelectorAll('.form-kembalikan');
        
        returnForms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault(); // Kunci submit bawaan agar tidak langsung reload
                
                // Mengambil teks judul buku dari kolom pertama tr induk
                const bookTitle = this.closest('tr').querySelector('.data-judul').innerText || 'buku ini';

                // Set status modal sedang aktif agar kursor sparkle tidak merusak DOM
                window.swalIsOpen = true;

                Swal.fire({
                    title: 'Kembalikan Buku?',
                    html: `
                        <div class="text-sm font-medium text-slate-500 leading-relaxed mt-2 text-center">
                            Apakah kamu yakin ingin mengembalikan buku <br>
                            <strong class="text-slate-800 text-base block mt-1">"${bookTitle}"</strong>
                        </div>
                    `,
                    icon: 'question',
                    iconColor: '#3b82f6',
                    showCancelButton: true,
                    confirmButtonColor: '#3b82f6',
                    cancelButtonColor: '#f1f5f9',
                    confirmButtonText: 'Ya, Kembalikan!',
                    cancelButtonText: 'Batal',
                    background: '#ffffff',
                    reverseButtons: true, 
                    allowOutsideClick: false, // User wajib interaksi dengan tombol modal
                    customClass: {
                        popup: 'rounded-[2.5rem] shadow-[0_25px_60px_rgba(0,0,0,0.15)] border border-slate-100 p-7 max-w-sm mx-auto',
                        title: 'text-xl font-black text-slate-800 tracking-tight mt-3 block text-center',
                        confirmButton: 'px-5 py-3 rounded-xl font-bold text-xs uppercase tracking-wider shadow-md shadow-blue-200/60 focus:ring-0',
                        cancelButton: 'px-5 py-3 rounded-xl font-bold text-xs uppercase tracking-wider text-slate-500 hover:bg-slate-100 focus:ring-0'
                    },
                    willOpen: () => {
                        // Paksa halaman utama tetap ngeblur total selama proses modal/konfirmasi
                        const mainLayout = document.querySelector('.max-w-7xl') || document.body;
                        mainLayout.style.filter = 'blur(15px)';
                        mainLayout.style.transition = 'filter 0.3s ease';
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // JIKA INPUT "YA": Izinkan submit form berjalan & biarkan loading screen bawaan lo muncul
                        form.submit(); 
                    } else {
                        // JIKA INPUT "BATAL" atau "CANCEL":
                        window.swalIsOpen = false; // Matikan flag state modal
                        
                        // Kembalikan efek blur halaman secara smooth tanpa memicu spinner loading bawaan lo
                        const mainLayout = document.querySelector('.max-w-7xl') || document.body;
                        mainLayout.style.filter = 'none';
                        
                        // Pastikan element loader bawaan lo dipaksa sembunyi/hidden (sesuaikan class loader web lo jika beda)
                        const globalLoader = document.querySelector('.loading-wrapper') || document.querySelector('[id*="loading"]');
                        if (globalLoader) {
                            globalLoader.style.display = 'none';
                            globalLoader.style.opacity = '0';
                        }
                    }
                });
            });
        });

        // ------------------------------------------------------------------
        // JAVASCRIPT ANIMASI KURSOR SPARKLE BINTANG (ANTI-LAG & ANTI-INTERRUPT)
        // ------------------------------------------------------------------
        const createSparkle = (x, y) => {
            // Jika modal sedang terbuka, hentikan total manipulasi DOM partikel biar ga bentrok
            if (window.swalIsOpen) return;

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
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\yere\Herd\pinjam-buku\resources\views/riwayat.blade.php ENDPATH**/ ?>