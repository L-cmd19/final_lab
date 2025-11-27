@extends('layouts.app')

@section('content')
    {{-- HERO SECTION --}}
    <div class="relative bg-gray-900 h-[500px] flex items-center justify-center overflow-hidden">
        {{-- Gambar Background --}}
        <img src="{{ asset('images/hero-bg.jpg') }}" class="absolute inset-0 w-full h-full object-cover opacity-60" alt="Hero">
        <div class="relative z-10 text-center text-white p-6 bg-black bg-opacity-50 p5-skew border-l-8 border-red-600">
            <h1 class="text-5xl md:text-7xl font-bold p5-font mb-2 transform skew-x-12 italic">PHANTOM THIEVES</h1>
            <p class="text-xl mb-6">Bergabunglah dengan revolusi belanja.</p>
            <a href="#katalog" class="inline-block bg-red-600 text-white font-bold py-3 px-8 hover:bg-white hover:text-red-600 transition duration-300 transform hover:-translate-y-1 shadow-lg">
                LIHAT KOLEKSI
            </a>
        </div>
    </div>

    {{-- SEARCH & KATALOG --}}
    <div id="katalog" class="container mx-auto py-12 px-4">
        <div class="flex justify-between items-center mb-8 border-b-2 border-gray-200 pb-4">
            <h2 class="text-3xl font-bold p5-font text-gray-800">KATALOG PRODUK</h2>
            <form action="{{ route('home') }}" method="GET" class="flex">
                <input type="text" name="search" placeholder="Cari item..." class="border-2 border-gray-300 px-4 py-2 focus:border-red-600 outline-none" value="{{ request('search') }}">
                <button type="submit" class="bg-black text-white px-6 py-2 font-bold hover:bg-red-600 transition">CARI</button>
            </form>
        </div>

        {{-- Menggunakan @forelse untuk menangani jika produk kosong --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @forelse($products as $product)
                <div class="bg-white group hover:shadow-2xl transition duration-300 border border-gray-200 relative flex flex-col h-full">
                    
                    {{-- Container Gambar --}}
                    <div class="h-64 overflow-hidden relative bg-gray-100">
                        @if($product->gambar)
                            <img src="{{ asset('storage/products/' . $product->gambar) }}" alt="{{ $product->nama_produk }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        @else
                            <div class="flex items-center justify-center h-full text-gray-400 font-bold">NO IMAGE</div>
                        @endif

                        @if($product->stok < 1)
                            <div class="absolute inset-0 bg-black bg-opacity-70 flex items-center justify-center text-white font-bold text-xl">HABIS</div>
                        @endif
                    </div>

                    {{-- Info Produk --}}
                    <div class="p-4 flex flex-col flex-grow">
                        {{-- PERBAIKAN: Gunakan ?-> untuk kategori --}}
                        <div class="text-xs text-red-600 font-bold uppercase mb-1">
                            {{ $product->category?->nama_kategori ?? 'Umum' }}
                        </div>
                        
                        <h3 class="text-lg font-bold mb-2 truncate">{{ $product->nama_produk }}</h3>
                        
                        <p class="text-gray-500 text-sm mb-4 h-10 overflow-hidden line-clamp-2">
                            {{ Str::limit($product->deskripsi, 50) }}
                        </p>
                        
                        <div class="flex justify-between items-center border-t pt-4 mt-auto">
                            <span class="text-xl font-bold text-gray-900">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                            <a href="{{ route('product.detail', $product->id) }}" class="text-sm bg-gray-900 text-white px-4 py-2 hover:bg-red-600 transition p5-skew shadow-md">
                                DETAIL
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 bg-gray-50 border-2 border-dashed border-gray-300">
                    <h3 class="text-xl text-gray-400 font-bold mb-2">Belum ada produk yang tersedia.</h3>
                    <p class="text-gray-500">Silakan cek kembali nanti.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection