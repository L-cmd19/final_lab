@extends('layouts.app')

@section('content')
<div class="container mx-auto py-12 px-4">
    <div class="max-w-2xl mx-auto bg-white shadow-xl border-t-8 border-red-600 p-8">
        <h1 class="text-2xl font-bold mb-6 p5-font text-gray-800">BUAT KATEGORI BARU</h1>

        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf

            {{-- Nama Kategori --}}
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2 uppercase">Nama Kategori</label>
                <input type="text" name="nama_kategori" value="{{ old('nama_kategori') }}" class="w-full border-2 border-gray-300 p-3 focus:border-red-600 focus:outline-none transition" placeholder="Contoh: Elektronik, Fashion, Pakaian" required>
                @error('nama_kategori')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div class="mb-8">
                <label class="block text-gray-700 text-sm font-bold mb-2 uppercase">Deskripsi (Opsional)</label>
                <textarea name="deskripsi" rows="4" class="w-full border-2 border-gray-300 p-3 focus:border-red-600 focus:outline-none transition" placeholder="Jelaskan singkat tentang kategori ini...">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-between items-center border-t pt-6">
                <a href="{{ route('admin.categories.index') }}" class="text-gray-500 hover:text-black font-bold transition">
                    &larr; BATAL
                </a>
                <button type="submit" class="bg-black text-white font-bold py-3 px-8 hover:bg-red-600 transition p5-skew shadow-lg">
                    SIMPAN DATA
                </button>
            </div>
        </form>
    </div>
</div>
@endsection