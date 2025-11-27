@extends('layouts.seller')

@section('title', 'Tambah Produk')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-8 shadow-md border-l-4 border-red-600">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold p5-font">TAMBAH PRODUK BARU</h2>
        <a href="{{ route('seller.products.index') }}" class="text-sm text-gray-500 hover:text-black font-bold">&larr; KEMBALI</a>
    </div>

    {{-- Form Tambah Produk --}}
    {{-- PENTING: enctype="multipart/form-data" wajib ada untuk upload gambar --}}
    <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
            {{-- Nama Produk --}}
            <div>
                <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Nama Produk</label>
                <input type="text" name="nama_produk" value="{{ old('nama_produk') }}" 
                    class="w-full border-2 border-gray-300 p-2 focus:border-red-600 outline-none transition" required>
                @error('nama_produk') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
            </div>

            {{-- Kategori --}}
            <div>
                <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Kategori</label>
                <select name="kategori_id" class="w-full border-2 border-gray-300 p-2 bg-white focus:border-red-600 outline-none transition" required>
                    <option value="" disabled selected>-- Pilih Kategori --</option>
                    {{-- Pastikan variabelnya $categories (jamak) as $category (tunggal) --}}
                    @foreach($categories as $category)
                        {{-- Pastikan 'id' dan 'nama_kategori' sesuai nama kolom di database --}}
                        <option value="{{ $category->id }}">{{ $category->nama_kategori }}</option>
                    @endforeach
                </select>
                @error('kategori_id') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
            {{-- Harga --}}
            <div>
                <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Harga (Rp)</label>
                <input type="number" name="harga" value="{{ old('harga') }}" 
                    class="w-full border-2 border-gray-300 p-2 focus:border-red-600 outline-none transition" required>
            </div>

            {{-- Stok --}}
            <div>
                <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Stok Awal</label>
                <input type="number" name="stok" value="{{ old('stok') }}" 
                    class="w-full border-2 border-gray-300 p-2 focus:border-red-600 outline-none transition" required>
            </div>
        </div>

        {{-- Deskripsi --}}
        <div class="mb-4">
            <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Deskripsi Produk</label>
            <textarea name="deskripsi" rows="5" class="w-full border-2 border-gray-300 p-2 focus:border-red-600 outline-none transition" required>{{ old('deskripsi') }}</textarea>
        </div>

        {{-- Gambar --}}
        <div class="mb-6">
            <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Foto Produk</label>
            <input type="file" name="gambar" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-bold file:bg-black file:text-white hover:file:bg-red-600 cursor-pointer border border-gray-300" required>
            <p class="text-xs text-gray-400 mt-1">*Format: JPG, PNG. Maks: 2MB.</p>
            @error('gambar') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
        </div>

        <div class="text-right">
            <button type="submit" class="bg-black text-white font-bold py-3 px-8 hover:bg-red-600 transition p5-skew shadow-lg transform hover:-translate-y-1">
                SIMPAN PRODUK
            </button>
        </div>
    </form>
</div>
@endsection