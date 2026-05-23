

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-white py-6 md:py-12 px-4 sm:px-6 lg:px-8 overflow-hidden">
    <div class="max-w-6xl mx-auto">
        
        
        <div class="mb-6 md:mb-10 opacity-0 animate-fade-down">
            <a href="<?php echo e(route('catalog')); ?>" class="inline-flex items-center gap-2 text-slate-500 hover:text-blue-600 transition-colors font-semibold text-sm mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Katalog
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-16 items-start">
            
            
            <div class="lg:col-span-5 flex justify-center lg:justify-start opacity-0 animate-fade-left">
                <div class="relative w-full max-w-[240px] md:max-w-none group">
                    <div class="absolute -inset-2 bg-gradient-to-tr from-blue-500 to-indigo-500 rounded-[2.5rem] blur-xl opacity-10 group-hover:opacity-20 transition-opacity duration-500"></div>
                    
                    <div class="relative bg-white p-2 md:p-3 rounded-[2.5rem] shadow-2xl border border-slate-50 transform-gpu transition-all duration-500 group-hover:scale-[1.03] group-hover:-translate-y-2">
                        <img src="<?php echo e(asset('storage/' . $book->image)); ?>" 
                             alt="<?php echo e($book->title); ?>"
                             class="w-full h-auto rounded-[2rem] object-cover shadow-inner"
                             onerror="this.src='https://images.unsplash.com/photo-1543002588-bfa74002ed7e?q=80&w=1000&auto=format&fit=crop'">
                    </div>
                </div>
            </div>

            
            <div class="lg:col-span-7 space-y-6 md:space-y-8 text-center lg:text-left">
                
                
                <div class="opacity-0 animate-fade-right">
                    <span class="inline-block px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-[9px] md:text-[10px] font-black uppercase tracking-widest mb-4">
                        Detail Koleksi
                    </span>
                    <h1 class="text-3xl md:text-7xl font-black text-slate-900 leading-tight mb-2 cursor-pointer hover:text-blue-600 transition-all">
                        <?php echo e($book->title); ?>

                    </h1>
                    <p class="text-lg md:text-2xl text-slate-400 font-semibold uppercase tracking-tight">
                        <?php echo e($book->author); ?>

                    </p>
                </div>

                
                <div class="grid grid-cols-2 gap-3 md:gap-4 opacity-0 animate-fade-up-1">
                    
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Status</span>
                        
                        
                        <?php if(Auth::check() && isset($isBorrowedByUser) && $isBorrowedByUser): ?>
                            <span class="text-sm font-black text-amber-500 flex items-center gap-1.5 animate-pulse">
                                <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                                Sedang Kamu Pinjam
                            </span>
                        <?php elseif(($book->stock ?? 0) <= 0 || strtolower($book->status ?? '') === 'habis'): ?>
                            <span class="text-sm font-black text-rose-500 flex items-center gap-1.5">
                                <span class="h-2 w-2 rounded-full bg-rose-500"></span>
                                Habis
                            </span>
                        <?php else: ?>
                            <span class="text-sm font-black text-emerald-500 flex items-center gap-1.5">
                                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                Tersedia
                            </span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="bg-slate-50 p-4 md:p-6 rounded-[1.5rem] md:rounded-[2rem] border border-slate-100 hover:shadow-md transition-shadow duration-300">
                        <p class="text-[9px] text-slate-400 uppercase font-black tracking-widest mb-1">ISBN</p>
                        <p class="text-sm md:text-lg font-bold text-slate-800"><?php echo e($book->isbn); ?></p>
                    </div>
                </div>

                
                <div class="pt-2 opacity-0 animate-fade-up-2">
                    <h3 class="text-lg md:text-xl font-bold text-slate-900 mb-3 text-left">Sinopsis</h3>
                    <p class="text-slate-500 leading-relaxed text-base md:text-lg font-light text-justify">
                        <?php echo e($book->description); ?>

                    </p>
                </div>

                
                <div class="pt-2 opacity-0 animate-fade-up-3">
                    <?php
                        $currentUserId = auth()->id() ?: (\Auth::check() ? \Auth::user()->id : null);

                        $liveActiveCount = $currentUserId 
                            ? \App\Models\Borrow::where('user_id', $currentUserId)
                                ->where(function($query) {
                                    $query->where('status', 'Dipinjam')
                                          ->orWhere('status', 'dipinjam')
                                          ->orWhere('status', 'DIPINJAM')
                                          ->orWhere('status', 'LIKE', '%pinjam%');
                                })->count()
                            : 0;
                    ?>

                    
                    <div class="mt-6">
                        <?php if(Auth::check() && isset($isBorrowedByUser) && $isBorrowedByUser): ?>
                            
                            <button disabled class="w-full py-4 bg-slate-100 text-slate-400 rounded-2xl font-bold text-sm uppercase cursor-not-allowed border border-slate-200 transition-all flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Sedang Kamu Pinjam</span>
                            </button>

                        <?php elseif(($book->stock ?? 0) <= 0 || strtolower($book->status ?? '') === 'habis'): ?>
                            
                            <button disabled class="w-full py-4 bg-slate-100 text-slate-400 rounded-2xl font-bold text-sm uppercase cursor-not-allowed border border-slate-200 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                </svg>
                                <span>Stok Kosong</span>
                            </button>

                        <?php else: ?>
                            
                            <?php if(!Auth::check()): ?>
                                <a href="<?php echo e(route('login')); ?>" class="w-full py-4 bg-blue-600 text-white rounded-2xl font-bold text-sm shadow-lg shadow-blue-100 hover:bg-blue-700 transition-all active:scale-95 uppercase block text-center tracking-wide">
                                    <span>Pinjam Sekarang</span>
                                </a>
                            
                            <?php elseif($liveActiveCount >= 5): ?>
                                <button type="button" onclick="tampilkanSkripWarningLimit()" class="w-full py-4 text-white rounded-2xl font-bold text-sm shadow-lg shadow-rose-100 transition-all active:scale-95 uppercase block text-center tracking-wide" style="background-color: #e11d48 !important;">
                                    <span>Pinjam Sekarang</span>
                                </button>
                            <?php else: ?>
                                <?php
                                    $isAdmin = Auth::check() && Auth::user()->role === 'admin';
                                ?>

                                <form action="<?php echo e(route('borrow.store', $book->id)); ?>" method="POST" class="borrow-form w-full m-0">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="duration" value="7">
                                    
                                    <button type="<?php echo e($isAdmin ? 'button' : 'submit'); ?>" 
                                            data-is-admin="<?php echo e($isAdmin ? 'true' : 'false'); ?>"
                                            class="borrow-btn w-full py-4 bg-blue-600 text-white rounded-2xl font-bold text-sm shadow-lg shadow-blue-100 hover:bg-blue-700 transition-all active:scale-95 uppercase tracking-wide">
                                        <span>Pinjam Sekarang</span>
                                    </button>
                                </form>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<style>
    .animate-fade-down { animation: fadeDown 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    .animate-fade-left { animation: fadeLeft 1s cubic-bezier(0.16, 1, 0.3, 1) forwards; animation-delay: 100ms; }
    .animate-fade-right { animation: fadeRight 1s cubic-bezier(0.16, 1, 0.3, 1) forwards; animation-delay: 200ms; }
    .animate-fade-up-1 { animation: fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; animation-delay: 350ms; }
    .animate-fade-up-2 { animation: fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; animation-delay: 450ms; }
    .animate-fade-up-3 { animation: fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; animation-delay: 550ms; }

    @keyframes fadeDown { from { opacity: 0; transform: translateY(-30px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeLeft { from { opacity: 0; transform: translateX(-50px); } to { opacity: 1; transform: translateX(0); } }
    @keyframes fadeRight { from { opacity: 0; transform: translateX(50px); } to { opacity: 1; transform: translateX(0); } }
    @keyframes fadeUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }
</style>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function tampilkanSkripWarningLimit() {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Limit Tercapai!',
                html: `
                    <div class="text-sm font-medium text-slate-500 leading-relaxed mt-2 text-center">
                        Kamu sudah meminjam <strong class="text-rose-500">5 buku</strong> sekaligus.<br>
                        <span class="text-xs block mt-2 text-slate-400">Kembalikan buku yang lain terlebih dahulu di halaman riwayat untuk dapat meminjam kembali.</span>
                    </div>
                `,
                icon: 'warning',
                iconColor: '#f43f5e', 
                confirmButtonColor: '#f43f5e', 
                confirmButtonText: 'Mengerti',
                background: '#ffffff',
                allowOutsideClick: true,
                customClass: {
                    popup: 'rounded-[2.5rem] shadow-[0_25px_60px_rgba(0,0,0,0.15)] border border-slate-100 p-7 max-w-sm mx-auto',
                    title: 'text-xl font-black text-slate-800 tracking-tight mt-3 block text-center',
                    confirmButton: 'w-full px-5 py-3 rounded-xl font-bold text-xs uppercase tracking-wider shadow-md shadow-rose-200 focus:ring-0 mt-2'
                }
            });
        } else {
            alert("Limit Tercapai! Kamu sudah meminjam 5 buku sekaligus. Silakan kembalikan buku lainnya di halaman riwayat.");
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        
        // 🛑 1. CEGAT ROLE ADMIN VIA EVENT 'CLICK'
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.borrow-btn');
            if (btn && btn.getAttribute('data-is-admin') === 'true') {
                e.preventDefault();
                e.stopPropagation();
                
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        position: 'center',
                        icon: 'warning',
                        iconColor: '#f59e0b',
                        title: 'Akses Ditolak!',
                        html: `<div class="text-xs font-semibold text-slate-500 leading-relaxed mt-1">Akun dengan role <strong>Admin</strong> hanya diizinkan untuk mengelola katalog, bukan untuk meminjam buku.</div>`,
                        showConfirmButton: false,
                        timer: 2500,
                        timerProgressBar: true,
                        background: '#ffffff',
                        customClass: {
                            popup: 'rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.12)] border border-slate-100 p-7 max-w-sm mx-auto',
                            title: 'text-lg font-black text-slate-800 tracking-tight mt-3 block text-center',
                            timerProgressBar: 'bg-amber-500 h-[3px]'
                        }
                    });
                }
            }
        });

        // 🍏 2. LOGIKA PINJAM UNTUK MAHASISWA VIA EVENT 'SUBMIT'
        document.addEventListener('submit', function(e) {
            if (e.target.closest('.borrow-form')) {
                const form = e.target.closest('.borrow-form');
                
                if (typeof Swal === 'undefined') { return; }

                const btn = form.querySelector('.borrow-btn');
                
                if (btn && btn.getAttribute('data-is-admin') === 'true') {
                    e.preventDefault();
                    return;
                }

                e.preventDefault(); 

                const textSpan = btn.querySelector('span');
                const bookTitle = document.querySelector('h1') ? document.querySelector('h1').innerText.trim() : 'Buku';
                const durationInput = form.querySelector('input[name="duration"]');
                const jumlahHari = durationInput ? parseInt(durationInput.value) : 7;

                btn.style.pointerEvents = 'none';
                btn.classList.add('bg-emerald-500', 'scale-95');
                if (textSpan) textSpan.style.opacity = '0';
                
                setTimeout(() => {
                    if (textSpan) {
                        textSpan.innerHTML = `
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>Memproses...</span>
                        `;
                        textSpan.classList.add('flex', 'items-center', 'justify-center', 'gap-2');
                        textSpan.style.opacity = '1';
                    }

                    const opsiSaja = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                    const hariIni = new Date();
                    const tanggalBatasKoleksi = new Date(hariIni);
                    tanggalBatasKoleksi.setDate(hariIni.getDate() + jumlahHari); 
                    const formatTanggalIndo = tanggalBatasKoleksi.toLocaleDateString('id-ID', opsiSaja);

                    setTimeout(() => {
                        Swal.fire({
                            title: 'Berhasil Dipinjam!',
                            html: `
                                <div class="text-sm text-slate-600 space-y-2">
                                    <p>Buku <strong class="text-blue-600">"${bookTitle}"</strong> berhasil ditambahkan ke koleksi pinjamanmu.</p>
                                    <div class="mt-4 p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-800 text-xs text-left">
                                        <span class="font-bold uppercase block text-emerald-600 mb-1">📅 Batas Waktu Pengembalian (${jumlahHari} Hari):</span>
                                        <strong class="text-sm font-black block mt-0.5">${formatTanggalIndo}</strong>
                                        <span class="text-[10px] block text-emerald-500 mt-1">*Halaman akan dialihkan ke riwayat otomatis.</span>
                                    </div>
                                </div>
                            `,
                            icon: 'success',
                            iconColor: '#10b981',
                            timer: 5000, 
                            timerProgressBar: true, 
                            // 🌟 FORCE EMERALD STYLE & TEKS BARU:
                            confirmButtonText: 'Ke Halaman Riwayat', 
                            buttonsStyling: false, // 🔥 WAJIB FALSE: Mematikan paksa warna hitam bawaan Swal!
                            allowOutsideClick: false,
                            customClass: {
                                popup: 'rounded-[2rem] shadow-2xl p-6',
                                title: 'text-xl font-black text-slate-800',
                                // 🔥 FORCE CLASS EMERALD TAILWIND:
                                confirmButton: 'inline-flex items-center justify-center px-6 py-3 bg-[#10b981] hover:bg-[#059669] text-white font-bold text-sm rounded-xl w-full mt-2 shadow-lg shadow-emerald-100 transition-all focus:outline-none focus:ring-0'
                            }
                        }).then(() => {
                            form.submit();
                        });
                    }, 1000);
                }, 150);
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\yere\Herd\pinjam-buku\resources\views/books/show.blade.php ENDPATH**/ ?>