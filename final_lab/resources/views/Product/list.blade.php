@extends('layouts.app')

@section('content')
<div class="container mx-auto py-12 px-4">
    
    {{-- Header & Title --}}
    <div class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-black p5-font italic mb-4">
            PHANTOM <span class="text-red-600">CATALOG</span>
        </h1>
        <p class="text-gray-600 text-lg">Temukan item terbaik dari para Seller terpercaya.</p>
    </div>

    {{-- Toolbar: Search & Filter --}}
    <div class="bg-white p-6 shadow-md border-t-4 border-black mb-10">
        <form action="{{ route('product.list') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-center justify-between">
            
            {{-- Search Bar --}}
            <div class="w-full md:w-1/2 relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama produk..." 
                    class="w-full border-2 border-gray-300 px-4 py-3 pl-10 focus:border-red-600 outline-none transition font-bold">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>

            {{-- Sorting Options --}}
            <div class="flex gap-4 w-full md:w-auto">
                <select name="sort_by" class="border-2 border-gray-300 px-4 py-3 bg-white focus:border-red-600 outline-none font-bold text-sm cursor-pointer" onchange="this.form.submit()">
                    <option value="latest" {{ request('sort_by') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="price_asc" {{ request('sort_by') == 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                    <option value="price_desc" {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                </select>
                
                <button type="submit" class="bg-black text-white px-8 py-3 font-bold hover:bg-red-600 transition p5-skew shadow-lg">
                    FILTER
                </button>
            </div>
        </form>
    </div>

    {{-- Product Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        @forelse($products as $product)
            <div class="bg-white border border-gray-200 shadow-sm group hover:shadow-2xl transition duration-300 relative flex flex-col h-full">
                {{-- Image Container --}}
                <div class="h-64 overflow-hidden relative bg-gray-100 border-b border-gray-100">
                    @if($product->gambar)
                        <img src="{{ asset('storage/products/' . $product->gambar) }}" alt="{{ $product->nama_produk }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    @else
                        <div class="flex items-center justify-center h-full text-gray-400 font-bold">NO IMAGE</div>
                    @endif

                    {{-- Badge Stok Habis --}}
                    @if($product->stok < 1)
                        <div class="absolute inset-0 bg-black bg-opacity-80 flex items-center justify-center">
                            <span class="text-white font-black text-xl border-4 border-white p-2 transform -rotate-12">SOLD OUT</span>
                        </div>
                    @endif

                    {{-- Badge Kategori --}}
                    <div class="absolute top-0 left-0 bg-red-600 text-white text-xs font-bold px-3 py-1 uppercase shadow">
                        {{ $product->category->nama_kategori ?? 'Umum' }}
                    </div>
                </div>

                {{-- Content --}}
                <div class="p-5 flex flex-col flex-grow">
                    {{-- Store Name --}}
                    <div class="flex items-center mb-2 text-gray-500 text-xs font-bold uppercase tracking-wide">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        {{ $product->store->nama_toko ?? 'Unknown Store' }}
                    </div>

                    <h3 class="text-lg font-bold mb-2 text-gray-900 line-clamp-2 leading-tight group-hover:text-red-600 transition">
                        {{ $product->nama_produk }}
                    </h3>
                    
                    <p class="text-gray-500 text-sm mb-4 line-clamp-2 flex-grow">
                        {{ $product->deskripsi }}
                    </p>

                    <div class="pt-4 border-t border-gray-100 flex items-center justify-between mt-auto">
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-400 uppercase font-bold">Harga</span>
                            <span class="text-xl font-bold text-gray-900">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                        </div>
                        
                        <a href="{{ route('product.detail', $product->id) }}" class="bg-black text-white text-xs font-bold px-4 py-2 hover:bg-red-600 transition p5-skew shadow-md">
                            DETAIL
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center">
                <div class="text-6xl mb-4">🕵️</div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Produk Tidak Ditemukan</h2>
                <p class="text-gray-500">Coba cari dengan kata kunci lain atau ubah filter.</p>
                <a href="{{ route('product.list') }}" class="text-red-600 font-bold hover:underline mt-4 inline-block">Reset Pencarian</a>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-12">
        {{ $products->appends(request()->query())->links() }}
    </div>
</div>
@endsection