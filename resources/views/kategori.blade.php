@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold mb-4">Kategori: {{ $category->name }}</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($books as $book)
            <div class="bg-white shadow rounded p-4">
                <img src="{{ $book->cover_url ?? 'https://via.placeholder.com/150' }}" 
                     alt="{{ $book->title }}" 
                     class="w-full h-48 object-cover mb-3 rounded">

                <h3 class="text-lg font-semibold">{{ $book->title }}</h3>
                <p class="text-sm text-gray-600">oleh {{ $book->author }}</p>

                <span class="inline-block mt-2 px-2 py-1 text-xs rounded 
                    {{ $book->status === 'Tersedia' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                    {{ $book->status }}
                </span>

                <div class="mt-3">
                    @if($book->status === 'Tersedia')
                        <form action="{{ route('pinjam', $book->id) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                                Pinjam
                            </button>
                        </form>
                    @else
                        <span class="bg-gray-400 text-white px-3 py-1 rounded">Dipinjam</span>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-gray-500">Belum ada buku di kategori ini.</p>
        @endforelse
    </div>
</div>
@endsection
