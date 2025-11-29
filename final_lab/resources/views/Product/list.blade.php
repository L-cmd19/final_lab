@extends('layouts.app')

@section('content')
<div class="container mx-auto py-12 px-4">
    
    {{-- BAGIAN 1: DETAIL PRODUK --}}
    <div class="bg-white shadow-xl overflow-hidden flex flex-col md:flex-row mb-12">
        {{-- Gambar --}}
        <div class="md:w-1/2 h-[500px] bg-gray-100 flex items-center justify-center overflow-hidden">
            @if($product->gambar)
                <img src="{{ asset('storage/products/' . $product->gambar) }}" alt="{{ $product->nama_produk }}" class="object-cover h-full w-full">
            @else
                <div class="text-gray-400 font-bold">NO IMAGE</div>
            @endif
        </div>
        
        {{-- Info Produk --}}
        <div class="md:w-1/2 p-8 md:p-12 flex flex-col justify-center bg-zinc-50 relative">
            <div class="absolute top-0 right-0 w-24 h-24 bg-red-600 p5-skew -mr-10 -mt-10 z-0"></div>

            <div class="relative z-10">
                <span class="bg-black text-white px-3 py-1 text-xs font-bold uppercase tracking-widest mb-4 inline-block">
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
                    <span class="text-gray-400 ml-2 text-sm">({{ $product->reviews?->count() ?? 0 }} Reviews)</span>
                </div>

                <div class="border-t border-gray-300 py-6">
                    <div class="mb-2 font-bold text-sm">
                        TOKO: 
                        <a href="{{ route('store.show', $product->store?->id ?? 0) }}" class="text-red-600 hover:underline">
                            {{ $product->store?->nama_toko ?? 'Unknown' }}
                        </a>
                    </div>
                    <div class="mb-6 font-bold text-sm">STOK: {{ $product->stok }} Unit</div>

                    @auth
                        @if(Auth::user()->canShop())
                            <form action="{{ route('cart.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="produk_id" value="{{ $product->id }}">
                                <div class="flex space-x-4">
                                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stok }}" class="border-2 border-gray-300 w-20 text-center py-3 font-bold focus:border-red-600 outline-none">
                                    <button type="submit" class="flex-1 bg-red-600 text-white font-bold py-3 hover:bg-black transition duration-300 p5-skew shadow-lg">
                                        TAMBAH KE KERANJANG
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="bg-gray-200 text-gray-600 p-4 text-center font-bold">
                                Akun Anda tidak dapat melakukan pembelian.
                            </div>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="block w-full bg-black text-white text-center font-bold py-3 hover:bg-red-600 transition">LOGIN UNTUK MEMBELI</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    {{-- BAGIAN 2: DAFTAR ULASAN / REVIEW --}}
    <div class="max-w-4xl mx-auto">
        <h2 class="text-2xl font-bold mb-6 border-l-8 border-black pl-4 p5-font">ULASAN PEMBELI</h2>

        <div class="space-y-6">
            @forelse($product->reviews as $review)
                <div class="bg-white p-6 shadow-sm border border-gray-200 flex gap-4">
                    {{-- Avatar User --}}
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-gray-900 text-white rounded-full flex items-center justify-center font-bold text-lg">
                            {{ substr($review->user->name, 0, 1) }}
                        </div>
                    </div>

                    {{-- Isi Review --}}
                    <div class="flex-grow">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h4 class="font-bold text-gray-900">{{ $review->user->name }}</h4>
                                <div class="text-xs text-gray-500">{{ $review->created_at->format('d F Y') }}</div>
                            </div>
                            <div class="flex text-yellow-500">
                                @for($i=1; $i<=5; $i++)
                                    <span>{{ $i <= $review->rating ? '★' : '☆' }}</span>
                                @endfor
                            </div>
                        </div>
                        
                        <p class="text-gray-700 italic">"{{ $review->komentar }}"</p>
                    </div>
                </div>
            @empty
                <div class="text-center py-10 bg-gray-50 border-2 border-dashed border-gray-300">
                    <p class="text-gray-500 font-bold">Belum ada ulasan untuk produk ini.</p>
                    <p class="text-sm text-gray-400">Jadilah yang pertama membelinya!</p>
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection