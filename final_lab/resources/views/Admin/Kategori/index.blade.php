@extends('layouts.app')

@section('content')
<div class="container mx-auto py-12 px-4">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold p5-font">KATEGORI PRODUK</h1>
        <a href="{{ route('admin.categories.create') }}" class="bg-red-600 text-white px-4 py-2 font-bold hover:bg-black transition p5-skew shadow">
            + TAMBAH KATEGORI
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($categories as $category)
            <div class="bg-white border border-gray-200 p-6 shadow hover:shadow-lg transition group relative">
                <h3 class="text-xl font-bold mb-2 group-hover:text-red-600">{{ $category->nama_kategori }}</h3>
                <p class="text-gray-500 text-sm mb-4">{{ $category->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                <div class="text-xs font-bold text-gray-400 mb-4">{{ $category->products()->count() }} Produk Terkait</div>
                
                <div class="flex items-center space-x-3 border-t pt-4">
                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="text-blue-600 font-bold text-sm hover:underline">Edit</a>
                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 font-bold text-sm hover:underline">Hapus</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $categories->links() }}
    </div>
</div>
@endsection