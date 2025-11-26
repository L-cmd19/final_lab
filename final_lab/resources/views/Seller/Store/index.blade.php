@extends('layouts.app')

@section('content')
<div class="container mx-auto py-12 px-4">
    <div class="max-w-2xl mx-auto bg-white shadow-xl p-8 border-l-8 border-black">
        <h1 class="text-3xl font-bold mb-6 p5-font">INFORMASI TOKO</h1>
        
        <form action="{{ route('seller.store.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Nama Toko --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Nama Toko</label>
                <input type="text" name="nama_toko" value="{{ old('nama_toko', $store->nama_toko ?? '') }}" class="w-full border-2 border-gray-300 p-3 focus:border-red-600 outline-none" required>
            </div>

            {{-- Deskripsi --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Deskripsi Singkat</label>
                <textarea name="deskripsi" rows="3" class="w-full border-2 border-gray-300 p-3 focus:border-red-600 outline-none">{{ old('deskripsi', $store->deskripsi ?? '') }}</textarea>
            </div>

            {{-- Gambar Toko --}}
            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Banner / Logo Toko</label>
                @if(isset($store->gamabar))
                    <div class="mb-2">
                        <img src="{{ asset('storage/stores/' . $store->gamabar) }}" class="h-32 w-full object-cover border">
                    </div>
                @endif
                <input type="file" name="gamabar" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-bold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
            </div>

            <button type="submit" class="bg-red-600 text-white font-bold py-3 px-8 hover:bg-black transition p5-skew shadow-lg">
                SIMPAN PERUBAHAN
            </button>
        </form>
    </div>
</div>
@endsection