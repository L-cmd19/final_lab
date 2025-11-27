@extends('layouts.seller')

@section('title', 'Edit Produk')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-8 shadow-md border-l-4 border-blue-600">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold">Edit Produk</h2>
        <a href="{{ route('seller.products.index') }}" class="text-sm text-gray-500 hover:text-black">&larr; Kembali</a>
    </div>

    <form action="{{ route('seller.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
            <div>
                <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Nama Produk</label>
                <input type="text" name="nama_produk" value="{{ old('nama_produk', $product->nama_produk) }}" class="w-full border border-gray-300 p-2 focus:border-blue-600 outline-none" required>
            </div>
            <div>
                <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Kategori</label>
                <select name="kategori_id" class="w-full border border-gray-300 p-2 bg-white focus:border-blue-600 outline-none">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->kategori_id == $category->id ? 'selected' : '' }}>
                            {{ $category->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
            <div>
                <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Harga (Rp)</label>
                <input type="number" name="harga" value="{{ old('harga', $product->harga) }}" class="w-full border border-gray-300 p-2 focus:border-blue-600 outline-none" required>
            </div>
            <div>
                <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Stok</label>
                <input type="number" name="stok" value="{{ old('stok', $product->stok) }}" class="w-full border border-gray-300 p-2 focus:border-blue-600 outline-none" required>
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Deskripsi Produk</label>
            <textarea name="deskripsi" rows="5" class="w-full border border-gray-300 p-2 focus:border-blue-600 outline-none" required>{{ old('deskripsi', $product->deskripsi) }}</textarea>
        </div>

        <div class="mb-6">
            <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Foto Produk (Opsional)</label>
            
            @if($product->gambar)
                <div class="mb-2">
                    <img src="{{ asset('storage/products/' . $product->gambar) }}" class="h-20 object-cover border">
                </div>
            @endif
            
            <input type="file" name="gambar" class="w-full text-sm border border-gray-300 p-2 bg-gray-50">
            <p class="text-xs text-gray-400 mt-1">Biarkan kosong jika tidak ingin mengubah gambar.</p>
        </div>

        <button type="submit" class="w-full bg-black text-white font-bold py-3 hover:bg-blue-600 transition">UPDATE PRODUK</button>
    </form>
</div>
@endsection