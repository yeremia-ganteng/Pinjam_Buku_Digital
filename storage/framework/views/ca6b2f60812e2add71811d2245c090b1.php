

<?php $__env->startSection('content'); ?>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    body { 
        font-family: 'Plus Jakarta Sans', sans-serif; 
        background-color: #f1f5f9; 
        color: #1e293b;
        overflow-x: hidden;
    }

    .dashboard-container { padding: 2.5rem; max-width: 1400px; margin: 0 auto; }

    @keyframes slideIn {
        0% { opacity: 0; transform: translateY(-30px) translateX(-10px); filter: blur(10px); }
        100% { opacity: 1; transform: translateY(0) translateX(0); filter: blur(0); }
    }

    .animate-item {
        opacity: 0;
        animation: slideIn 0.8s cubic-bezier(0.22, 1, 0.36, 1) forwards;
    }

    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }
    .delay-4 { animation-delay: 0.4s; }
    .delay-5 { animation-delay: 0.5s; }

    .welcome-banner {
        background: #ffffff;
        padding: 2.5rem;
        border-radius: 1.5rem;
        border: 1px solid #e2e8f0;
        margin-bottom: 2.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .btn-home {
        background: #0f172a;
        color: #ffffff;
        padding: 0.8rem 1.5rem;
        border-radius: 0.75rem;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }
    .btn-home:hover { background: #334155; transform: scale(1.05); }

    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .nav-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 1.25rem;
        padding: 1.75rem;
        text-decoration: none;
        display: flex;
        flex-direction: column;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .nav-card:hover {
        border-color: #3b82f6;
        transform: translateY(-12px) scale(1.02);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
    }

    .nav-card:hover .card-icon { transform: scale(1.1); }

    .card-icon {
        width: 56px; height: 56px;
        border-radius: 1rem;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 1.5rem;
        transition: transform 0.3s ease;
    }

    .bg-blue { background: #eff6ff; color: #2563eb; }
    .bg-emerald { background: #ecfdf5; color: #059669; }
    .bg-amber { background: #fffbeb; color: #d97706; }
    .bg-slate { background: #f8fafc; color: #475569; }
    
    /* Custom Styling Baru khusus ketika limit penuh (5 Buku) */
    .border-limit-full { border-color: #f43f5e !important; background: #fff1f2; }
    .bg-limit-full-icon { background: #f43f5e !important; color: #ffffff !important; }
    .text-limit-full { color: #e11d48 !important; }
    .bg-limit-progress { background: #f43f5e !important; box-shadow: 0 0 10px rgba(244, 63, 94, 0.5); }
</style>

<div class="dashboard-container">
    
    
    <div class="welcome-banner animate-item delay-1">
        <div class="welcome-text">
            <h1 class="text-3xl font-extrabold text-slate-900">Hi, <?php echo e(Auth::user()->name); ?> 👋</h1>
            <p class="text-slate-500">Akses cepat layanan perpustakaan digital Anda.</p>
        </div>
        <a href="<?php echo e(url('/')); ?>" class="btn-home">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Ke Beranda
        </a>
    </div>

    <div class="menu-grid">
        
        
        <a href="<?php echo e(route('catalog')); ?>" class="nav-card animate-item delay-2">
            <div class="card-icon bg-blue">
                <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
            <h3 class="font-bold text-xl text-slate-900 mb-2">Katalog Buku</h3>
            <p class="text-sm text-slate-500">Cari dan temukan referensi bacaan terbaik dari berbagai kategori.</p>
        </a>

        
        
        <div class="nav-card animate-item delay-3">
            <div class="card-icon bg-emerald text-emerald-600">
                <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="font-bold text-xl mb-2 text-slate-900">
                Status Peminjaman
            </h3>
            <p class="text-sm text-slate-500 mb-4">
                Anda memiliki <strong><?php echo e(str_pad($jumlahPinjam, 2, '0', STR_PAD_LEFT)); ?> Buku</strong> yang sedang dipinjam saat ini.
            </p>
            
            
            <?php if(isset($totalDendaUser) && $totalDendaUser > 0): ?>
                
                <div class="mt-auto py-2 px-3 bg-rose-100 text-rose-700 text-[11px] font-bold rounded-lg w-full flex justify-between items-center border border-rose-200">
                    <span>⚠️ TOTAL DENDA:</span>
                    <span>Rp <?php echo e(number_format($totalDendaUser, 0, ',', '.')); ?></span>
                </div>
            <?php else: ?>
                
                <div class="mt-auto py-2 px-3 bg-emerald-100 text-emerald-700 text-[11px] font-bold rounded-lg w-fit uppercase tracking-wider">
                    Bebas Denda
                </div>
            <?php endif; ?>
        </div>

        
        <a href="<?php echo e(route('riwayat')); ?>" class="nav-card animate-item delay-4">
            <div class="card-icon bg-amber">
                <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h3 class="font-bold text-xl text-slate-900 mb-2">Riwayat Pinjam</h3>
            <p class="text-sm text-slate-500">Lihat log aktivitas peminjaman buku yang telah diselesaikan.</p>
        </a>


<a href="<?php echo e(route('profile.edit')); ?>" class="block nav-card animate-item delay-5 <?php echo e($jumlahPinjam >= 5 ? 'border-limit-full' : ''); ?> hover:scale-[1.02] transition-transform duration-300">
    
    <div class="w-24 h-24 shrink-0 rounded-full overflow-hidden shadow-lg border-2 border-white ring-2 ring-slate-100">
        <img src="<?php echo e(auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name)); ?>" 
            class="w-full h-full object-cover object-center"
            style="aspect-ratio: 1 / 1;">
    </div>
    
    
     <?php if($jumlahPinjam >= 5): ?>
        <div class="absolute -top-1 -right-1 w-6 h-6 bg-rose-600 text-white rounded-full flex items-center justify-center text-[10px] font-bold animate-pulse border border-white">
            !
        </div>
    <?php endif; ?>
    <h3 class="font-bold text-xl mb-4 <?php echo e($jumlahPinjam >= 5 ? 'text-limit-full' : 'text-slate-900'); ?>">Profil Member</h3>
    
    
    <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden shadow-inner">
        <div class="h-full transition-all duration-500 rounded-full <?php echo e($jumlahPinjam >= 5 ? 'bg-limit-progress' : 'bg-blue-600'); ?>" 
             style="width: <?php echo e($persentase); ?>%"></div>
    </div>
    
    <span class="text-[10px] font-black mt-3 uppercase tracking-widest <?php echo e($jumlahPinjam >= 5 ? 'text-rose-600' : 'text-slate-400'); ?>">
        Limit: <?php echo e($jumlahPinjam); ?> / <?php echo e($limitBuku); ?> Buku
    </span>
    
    <?php if($jumlahPinjam >= 5): ?>
        <span class="text-[9px] text-rose-500 font-bold mt-1 animate-pulse">🚨 Kuota Habis! Selesaikan pinjaman.</span>
    <?php endif; ?>
    
    
    <div class="absolute bottom-4 right-4 text-gray-400 group-hover:text-blue-600">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
    </div>
</a>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\yere\Herd\pinjam-buku\resources\views/user/user_dashboard.blade.php ENDPATH**/ ?>