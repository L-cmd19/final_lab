@extends('layouts.app')

@section('content')
<div class="container mx-auto py-12 px-4">
    <div class="bg-white shadow-xl overflow-hidden flex flex-col md:flex-row">
        {{-- Gambar --}}
        <div class="md:w-1/2 h-[500px] bg-gray-100 flex items-center justify-center overflow-hidden">
            @if($product->gambar)
                <img src="{{ asset('storage/products/' . $product->gambar) }}" alt="{{ $product->nama_produk }}" class="object-cover h-full w-full">
            @else
                <div class="text-gray-400 font-bold">NO IMAGE</div>
            @endif
        </div>
        
        {{-- Info --}}
        <div class="md:w-1/2 p-8 md:p-12 flex flex-col justify-center bg-zinc-50 relative">
            <div class="absolute top-0 right-0 w-24 h-24 bg-red-600 p5-skew -mr-10 -mt-10 z-0"></div>

            <div class="relative z-10">
                <span class="bg-black text-white px-3 py-1 text-xs font-bold uppercase tracking-widest mb-4 inline-block">
                    {{-- PERBAIKAN: Gunakan ?->category --}}
                    {{ $product->category?->nama_kategori ?? 'Umum' }}
                </span>
                <h1 class="text-4xl font-bold mb-4 p5-font">{{ $product->nama_produk }}</h1>
                <div class="text-3xl font-bold text-red-600 mb-6">
                    Rp {{ number_format($product->harga, 0, ',', '.') }}
                </div>
                
                <p class="text-gray-600 mb-8 leading-relaxed">{{ $product->deskripsi }}</p>

                <div class="flex items-center mb-6">
                    <span class="text-yellow-500 text-xl mr-2">★</span>
                    <span class="font-bold text-lg">{{ number_format($averageRating, 1) }}</span>
                    {{-- PERBAIKAN: Gunakan ?->reviews --}}
                    <span class="text-gray-400 ml-2 text-sm">({{ $product->reviews?->count() ?? 0 }} Reviews)</span>
                </div>

                <div class="border-t border-gray-300 py-6">
                    {{-- PERBAIKAN: Gunakan ?->store --}}
                    <div class="mb-2 font-bold text-sm">TOKO: <span class="text-red-600">{{ $product->store?->nama_toko ?? 'Unknown' }}</span></div>
                    <div class="mb-6 font-bold text-sm">STOK: {{ $product->stok }} Unit</div>

                    @auth
                        @if(Auth::user()->isBuyer())
                            <form action="{{ route('cart.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="produk_id" value="{{ $product->id }}">
                                <div class="flex space-x-4">
                                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stok }}" class="border-2 border-gray-300 w-20 text-center py-3 font-bold focus:border-red-600">
                                    <button type="submit" class="flex-1 bg-red-600 text-white font-bold py-3 hover:bg-black transition duration-300 p5-skew shadow-lg">
                                        TAMBAH KE KERANJANG
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="bg-gray-200 text-gray-600 p-4 text-center font-bold">
                                Login sebagai Buyer untuk membeli.
                            </div>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="block w-full bg-black text-white text-center font-bold py-3 hover:bg-red-600 transition">LOGIN UNTUK MEMBELI</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection