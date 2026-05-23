<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku - PinjamBuku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; }
        .custom-input:focus { background-color: white; box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.08); }
    </style>
</head>
<body class="p-4 md:p-8 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-xl animate__animated animate__fadeIn">
        
        <a href="{{ route('books.index') }}" class="group inline-flex items-center text-indigo-600 text-xs font-bold mb-4 transition-all">
            <span class="mr-1 group-hover:-translate-x-1 transition-transform">←</span> Batal
        </a>
        
        <div class="bg-white rounded-[2rem] shadow-[0_15px_40px_rgba(0,0,0,0.04)] border border-slate-100 p-6 md:p-10">
            <div class="mb-8">
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">Edit Buku</h2>
                <p class="text-xs text-slate-400 font-medium mt-1 uppercase tracking-widest">ID Koleksi: #{{ $book->id }}</p>
            </div>

            <form id="editForm" action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 mb-1.5 ml-1">ISBN</label>
                        <input type="text" name="isbn" value="{{ $book->isbn }}" 
                               class="custom-input w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500/10 focus:border-indigo-500 text-sm font-semibold text-slate-700" required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 mb-1.5 ml-1">Kategori</label>
                        <select name="category_id" class="custom-input w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500/10 focus:border-indigo-500 text-sm font-semibold text-slate-700 appearance-none" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $book->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 mb-1.5 ml-1">Judul Buku</label>
                    <input type="text" name="title" value="{{ $book->title }}" 
                           class="custom-input w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500/10 focus:border-indigo-500 text-sm font-semibold text-slate-700" required>
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 mb-1.5 ml-1">Penulis</label>
                    <input type="text" name="author" value="{{ $book->author }}" 
                           class="custom-input w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500/10 focus:border-indigo-500 text-sm font-semibold text-slate-700" required>
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 mb-1.5 ml-1">Deskripsi</label>
                    <textarea name="description" rows="3" 
                              class="custom-input w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500/10 focus:border-indigo-500 text-sm font-medium resize-none leading-relaxed">{{ old('description', $book->description) }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4 items-end">
                    <div>
                        <label class="block text-[10px] font-black uppercase text-slate-400 mb-1.5 ml-1">Stok</label>
                        <input type="number" name="stock" value="{{ $book->stock }}" 
                               class="custom-input w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500/10 focus:border-indigo-500 text-sm font-semibold text-slate-700" required>
                    </div>
                    <div class="relative group">
                        <label class="block text-[10px] font-black uppercase text-slate-400 mb-1.5 ml-1">Ganti Cover</label>
                        <input type="file" name="image" id="imageInput" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" accept="image/*">
                        <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-2.5 flex items-center justify-between group-hover:border-indigo-300 transition-colors">
                            <span id="fileLabel" class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter truncate">Pilih File...</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100 transition-all" id="previewContainer">
                    <img id="imagePreview" src="{{ asset('storage/' . $book->image) }}" class="w-10 h-14 object-cover rounded shadow-sm border-2 border-white transition-all duration-300">
                    <div>
                        <p id="previewText" class="text-[10px] text-slate-400 font-medium italic">Cover saat ini akan tetap digunakan jika tidak ada file baru.</p>
                    </div>
                </div>

                <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition-all active:scale-[0.98] flex items-center justify-center gap-2 text-sm tracking-wide">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </div>

    <script>
        const imageInput = document.getElementById('imageInput');
        const imagePreview = document.getElementById('imagePreview');
        const fileLabel = document.getElementById('fileLabel');
        const previewText = document.getElementById('previewText');
        const previewContainer = document.getElementById('previewContainer');

        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            
            if (file) {
                // Notifikasi Toast Alert
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                });

                Toast.fire({
                    icon: 'success',
                    title: 'Foto berhasil dipilih!'
                });

                // Update Label & Preview
                fileLabel.textContent = file.name;
                previewText.textContent = "Pratinjau cover baru siap diunggah.";
                previewText.classList.replace('text-slate-400', 'text-indigo-600');
                previewContainer.classList.add('border-indigo-200', 'bg-indigo-50/30');

                // FileReader untuk Live Preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.classList.add('animate__animated', 'animate__pulse');
                    setTimeout(() => {
                        imagePreview.classList.remove('animate__animated', 'animate__pulse');
                    }, 1000);
                }
                reader.readAsDataURL(file);
            }
        });
    </script>

</body>
</html>