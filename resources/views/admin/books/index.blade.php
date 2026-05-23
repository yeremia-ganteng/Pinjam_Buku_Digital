@extends('layouts.app')

@push('styles')
<style>
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

    .stagger-animate {
        opacity: 0;
        animation: smoothFadeInUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        animation-delay: var(--d);
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <div class="stagger-animate w-full flex flex-row items-center justify-between gap-6 pb-6 border-b border-slate-100 text-left" style="--d: 100ms;">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl sm:text-3xl font-black text-slate-800 tracking-tight">Katalog <span class="text-blue-600">Buku Perpustakaan</span></h2>
            <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">Kelola arsip judul, kategori, data penerbit, serta ketersediaan stok buku secara real-time.</p>
            
            <div class="mt-4 flex flex-wrap gap-3">
                <a href="{{ route('books.create') }}" class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-black tracking-wider uppercase rounded-xl border border-blue-700 shadow-md hover:shadow-xl hover:-translate-y-1 active:scale-95 transition-all duration-300">
                    ➕ Tambah Buku Baru
                </a>
            </div>
        </div>
        <div class="flex-shrink-0 hidden sm:block">
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center px-5 py-2 bg-white hover:bg-slate-50 text-slate-600 text-xs font-black tracking-wider uppercase rounded-xl border border-slate-200 shadow-sm transition-all duration-300">
                🏠 Dashboard
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="stagger-animate mt-6 flex items-center justify-between p-4 bg-emerald-50/80 border border-emerald-200/60 rounded-2xl shadow-sm shadow-emerald-100/20 text-left" style="--d: 200ms;">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center text-sm shadow-sm shadow-emerald-500/20">
                    ✓
                </div>
                <div>
                    <h5 class="text-sm font-black text-emerald-900 leading-none">Tindakan Sukses</h5>
                    <p class="text-xs text-emerald-600 font-semibold mt-0.5">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="stagger-animate bg-white shadow-xl shadow-slate-100/40 rounded-[2rem] overflow-hidden border border-slate-100 mt-16" style="--d: 300ms;">
        <div class="px-6 py-5 bg-slate-50/60 border-b border-slate-100 flex items-center justify-between">
            <h4 class="font-black text-slate-800 tracking-tight text-sm uppercase">Daftar Koleksi Buku</h4>
            <span class="px-2.5 py-1 bg-white text-slate-500 text-[9px] font-black tracking-wider uppercase rounded-lg border border-slate-200 shadow-sm">
                Total: {{ $books->count() }} Judul
            </span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead>
                    <tr class="bg-slate-50/20">
                        <th class="py-4 px-6 sm:px-8 text-left text-xs font-black text-slate-400 uppercase tracking-wider w-28">Cover</th>
                        <th class="py-4 px-6 sm:px-8 text-left text-xs font-black text-slate-400 uppercase tracking-wider w-32">Kode / ISBN</th>
                        <th class="py-4 px-6 sm:px-8 text-left text-xs font-black text-slate-400 uppercase tracking-wider">Judul Buku</th>
                        <th class="py-4 px-6 sm:px-8 text-left text-xs font-black text-slate-400 uppercase tracking-wider">Penulis / Penerbit</th>
                        <th class="py-4 px-6 sm:px-8 text-left text-xs font-black text-slate-400 uppercase tracking-wider w-32">Sisa Stok</th>
                        <th class="py-4 px-6 sm:px-8 text-center text-xs font-black text-slate-400 uppercase tracking-wider w-48">Aksi Operasional</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($books as $index => $b)
                        <tr class="stagger-animate hover:bg-slate-50/40 transition-colors duration-150 group" style="--d: {{ 400 + ($index * 70) }}ms;">
                            
                            <td class="py-4 px-6 sm:px-8 whitespace-nowrap text-left vertical-middle">
                                <div class="w-20 h-24 rounded-xl bg-slate-50 overflow-hidden border border-slate-200/60 p-1 flex items-center justify-center group-hover:scale-105 transition-all duration-300">
                                    @if($b->image)
                                        <img src="{{ asset('storage/' . $b->image) }}" alt="Cover {{ $b->title }}" class="w-full h-full object-contain">
                                    @else
                                        <div class="w-full h-full flex flex-col items-center justify-center bg-slate-100 text-slate-400">
                                            <span class="text-lg">📖</span>
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <td class="py-4 px-6 sm:px-8 font-black text-slate-400 text-xs whitespace-nowrap text-left">#BK-{{ $b->id }}</td>
                            <td class="py-4 px-6 sm:px-8 font-bold text-slate-700 text-sm text-left">
                                <div class="font-bold text-slate-800">{{ $b->title }}</div>
                                <div class="text-[10px] text-slate-400 font-semibold tracking-wide uppercase mt-0.5">{{ $b->category->name ?? 'Umum' }}</div>
                            </td>
                            <td class="py-4 px-6 sm:px-8 text-left">
                                <div class="text-sm font-semibold text-slate-600">{{ $b->author }}</div>
                                <div class="text-xs text-slate-400 mt-0.5">{{ $b->publisher ?? '-' }}</div>
                            </td>
                            <td class="py-4 px-6 sm:px-8 whitespace-nowrap text-left">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black tracking-wide uppercase
                                    {{ $b->stock > 0 ? 'bg-blue-100 text-blue-700' : 'bg-rose-100 text-rose-700' }}">
                                    📦 {{ $b->stock }} Buku
                                </span>
                            </td>
                            
                            <td class="py-4 px-6 sm:px-8 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center gap-4">
                                    <a href="{{ route('books.edit', $b->id) }}" class="inline-flex items-center px-4 py-2 bg-amber-50 hover:bg-amber-500 text-amber-700 hover:text-white text-xs font-black tracking-wider uppercase rounded-xl border border-amber-200 transition-all duration-200 hover:shadow-md hover:-translate-y-0.5">
                                        ✏️ Edit
                                    </a>
                                    
                                    <form action="{{ route('books.destroy', $b->id) }}" method="POST" class="inline form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" data-title="{{ $b->title }}"
                                                class="btn-delete inline-flex items-center px-4 py-2 bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white text-xs font-black tracking-wider uppercase rounded-xl border border-rose-200 transition-all duration-200 hover:shadow-md hover:-translate-y-0.5">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="stagger-animate" style="--d: 400ms;">
                            <td colspan="6" class="py-12 text-center text-slate-400 font-medium text-sm">Belum ada data katalog buku di database.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        // ==========================================================
        // 1. ALERT DEDIKASI UNTUK SUKSES CRUD ADMIN (TAMBAH/EDIT/HAPUS)
        // ==========================================================
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Tindakan Sukses!',
                text: "{{ session('success') }}", // Mengambil teks murni dari Controller (misal: "Informasi buku berhasil diperbarui!")
                background: '#ffffff',
                customClass: {
                    popup: 'rounded-[2rem] border border-slate-100 shadow-2xl p-6',
                    title: 'text-xl font-black text-slate-800 tracking-tight mt-3',
                    confirmButton: 'bg-slate-900 text-white rounded-xl text-xs font-black tracking-wider uppercase px-6 py-3.5 transition-all hover:bg-slate-800 focus:ring-0'
                },
                buttonsStyling: false
            });
        @endif

        // ==========================================================
        // 2. LOGIKA KONFIRMASI MODAL DELETE BUKU (YANG SUDAH ADA)
        // ==========================================================
        const deleteButtons = document.querySelectorAll('.btn-delete');
        
        deleteButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                
                const form = this.closest('.form-delete');
                const bookTitle = this.getAttribute('data-title') || 'Buku';
                
                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: `Buku "${bookTitle}" akan dihapus secara permanen dari arsip katalog perpustakaan.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e11d48', // Rose-600
                    cancelButtonColor: '#64748b',  // Slate-500
                    confirmButtonText: 'Ya, Hapus Buku!',
                    cancelButtonText: 'Batal',
                    background: '#ffffff',
                    customClass: {
                        popup: 'rounded-[2rem] border border-slate-100 shadow-2xl p-6',
                        title: 'text-xl font-black text-slate-800 tracking-tight mt-3',
                        htmlContainer: 'text-xs font-semibold text-slate-500 mt-2',
                        confirmButton: 'rounded-xl text-xs font-black tracking-wider uppercase px-5 py-3 mx-2 focus:ring-0',
                        cancelButton: 'rounded-xl text-xs font-black tracking-wider uppercase px-5 py-3 mx-2 focus:ring-0'
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
@endpush