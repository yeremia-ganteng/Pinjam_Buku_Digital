<style>
    /* CSS Profesional untuk Animasi & Performance */
    .nav-item { 
        will-change: transform, opacity; 
        animation: smoothSlide 0.8s cubic-bezier(0.22, 1, 0.36, 1) forwards; 
    }
    @keyframes smoothSlide { 
        from { opacity: 0; transform: translateY(-15px); } 
        to { opacity: 1; transform: translateY(0); } 
    }
    
    .nav-link-active { color: #2563eb !important; }
    .nav-link-active::after { 
        content: ''; position: absolute; bottom: -22px; left: 0; width: 100%; height: 3px; 
        background: #2563eb; border-radius: 2px; animation: popIn 0.4s ease-out; 
    }
    @keyframes popIn { from { transform: scaleX(0); } to { transform: scaleX(1); } }

    .btn-logout {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        will-change: transform, background-color, color;
    }
    .btn-logout:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgb(68, 55, 55);
    }
    
    /* Scrollbar Profesional */
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    [x-cloak] { display: none !important; }
</style>

<nav class="bg-white/90 backdrop-blur-md border-b border-gray-100 sticky top-0 z-[60]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center nav-item">
                    <a href="<?php echo e(route('dashboard')); ?>" class="flex items-center gap-2 group">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center shadow-lg shadow-blue-600/20 group-hover:rotate-12 transition-transform duration-500">
                            <span class="text-white font-bold">P</span>
                        </div>
                        <span class="font-black text-xl tracking-tighter text-slate-800">Pinjam<span class="text-blue-600">Buku</span></span>
                    </a>
                </div>

                <div class="hidden sm:flex sm:ms-10 items-center space-x-8">
                    <?php $__currentLoopData = ['Beranda' => 'welcome', 'Dashboard' => 'dashboard', 'Katalog' => 'catalog']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $route): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route($route)); ?>" 
                           class="nav-item relative text-sm font-bold transition-colors duration-300 <?php echo e(request()->routeIs($route) ? 'nav-link-active text-gray-900' : 'text-gray-500 hover:text-gray-900'); ?>"
                           style="animation-delay: <?php echo e(0.1 + ($loop->index * 0.15)); ?>s;">
                           <?php echo e($label); ?>

                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <div class="hidden sm:flex items-center gap-3 nav-item" style="animation-delay: 0.5s;">
                <button onclick="document.getElementById('logout-form-v2').submit();" 
                        class="btn-logout text-[10px] font-black uppercase tracking-widest px-4 py-2 rounded-xl transition-all duration-300 bg-red-50 text-red-600 hover:bg-gray-600 hover:text-white border border-transparent hover:border-red-700">
                    Log Out
                </button>
                
                
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" 
                            class="flex items-center gap-2 p-1 pr-3 bg-gray-50 rounded-full hover:bg-gray-100 transition-all duration-300 ring-2 ring-transparent hover:ring-blue-100">
                        
                        <img src="<?php echo e(Auth::user()->avatar ? asset('storage/'.Auth::user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=3b82f6&color=fff'); ?>" 
                             class="w-7 h-7 rounded-full object-cover shadow-md">
                        
                        <span class="text-xs font-bold text-gray-700"><?php echo e(Auth::user()->name); ?></span>
                    </button>
                    
                    
                    
                    <div x-show="open" 
                         @click.away="open = false"
                         x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="fixed z-[999999] mt-2 w-48 bg-white border border-gray-100 rounded-3xl shadow-2xl p-2"
                         style="display: none; top: 64px; right: 2rem;">
                        
                        <div class="max-h-40 overflow-y-auto custom-scrollbar pr-1">
                            <div class="px-3 pt-1 pb-2">
                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Akun Saya</p>
                            </div>

                            <a href="<?php echo e(route('dashboard')); ?>" class="block px-4 py-2.5 text-sm font-bold text-gray-700 hover:bg-gray-50 rounded-2xl transition-all">
                                Dashboard Utama
                            </a>

                            <a href="<?php echo e(route('profile.edit')); ?>" class="block px-4 py-2.5 text-sm font-bold text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-2xl transition-all">
                                My Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<form id="logout-form-v2" method="POST" action="<?php echo e(route('logout')); ?>" class="hidden"><?php echo csrf_field(); ?></form><?php /**PATH C:\yere\Herd\pinjam-buku\resources\views/layouts/navigation.blade.php ENDPATH**/ ?>