@extends('layouts.app')

@section('content')
<div class="container mx-auto py-12 px-4">
    <div class="max-w-2xl mx-auto bg-white shadow-xl border-t-4 border-red-600 p-8">
        <h1 class="text-2xl font-bold mb-6 p5-font">TAMBAH PRODUK BARU</h1>

        <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Produk</label>
                <input type="text" name="nama_produk" value="{{ old('nama_produk') }}" class="w-full border-2 border-gray-300 p-2 focus:border-red-600 focus:outline-none" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Kategori</label>
                <select name="kategori_id" class="w-full border-2 border-gray-300 p-2 focus:border-red-600 focus:outline-none">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Harga (Rp)</label>
                    <input type="number" name="harga" value="{{ old('harga') }}" class="w-full border-2 border-gray-300 p-2 focus:border-red-600 focus:outline-none" required>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Stok</label>
                    <input type="number" name="stok" value="{{ old('stok') }}" class="w-full border-2 border-gray-300 p-2 focus:border-red-600 focus:outline-none" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
                <textarea name="deskripsi" rows="4" class="w-full border-2 border-gray-300 p-2 focus:border-red-600 focus:outline-none" required>{{ old('deskripsi') }}</textarea>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Gambar Produk</label>
                <input type="file" name="gambar" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-bold file:bg-red-50 file:text-red-700 hover:file:bg-red-100" required>
            </div>

            <div class="flex justify-between items-center mt-8">
                <a href="{{ route('seller.products.index') }}" class="text-gray-500 hover:underline">Batal</a>
                <button type="submit" class="bg-black text-white font-bold py-2 px-6 hover:bg-red-600 transition p5-skew shadow-lg">
                    SIMPAN PRODUK
                </button>
            </div>
        </form>
    </div>
</div>
@endsection