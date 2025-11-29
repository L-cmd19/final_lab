@extends('layouts.app')

@section('content')
<div class="container mx-auto py-12 px-4 flex justify-center">
    <div class="w-full max-w-lg bg-white shadow-2xl overflow-hidden border-t-8 border-red-600">
        <div class="p-8">
            <h1 class="text-2xl font-bold mb-2 p5-font">BERI ULASAN</h1>
            <p class="text-gray-500 mb-6">Order #{{ $order->id }}</p>

            <form action="{{ route('review.store', $order->id) }}" method="POST">
                @csrf
                
                {{-- PILIH PRODUK --}}
                <div class="mb-6">
                    <label class="block text-sm font-bold mb-3 text-gray-700">Pilih Produk yang ingin dinilai:</label>
                    <div class="space-y-3">
                        @foreach($itemsToReview as $item)
                            <div class="relative flex items-center border-2 border-gray-200 p-3 rounded hover:border-red-600 transition cursor-pointer">
                                <input type="radio" name="produk_id" value="{{ $item->product->id }}" id="prod_{{ $item->product->id }}" class="peer w-4 h-4 text-red-600 focus:ring-red-500" required>
                                <label for="prod_{{ $item->product->id }}" class="flex items-center w-full ml-3 cursor-pointer">
                                    <img src="{{ asset('storage/products/' . $item->product->gambar) }}" class="w-12 h-12 object-cover border border-gray-300 mr-3">
                                    <div>
                                        <div class="font-bold text-sm">{{ $item->product->nama_produk }}</div>
                                        <div class="text-xs text-gray-500">Toko: {{ $item->product->store->nama_toko ?? '-' }}</div>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- RATING BINTANG --}}
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2 text-gray-700">Rating:</label>
                    <div class="flex flex-row-reverse justify-end gap-2">
                        <input type="radio" name="rating" value="5" id="5" class="peer hidden" required><label for="5" class="text-gray-300 text-3xl cursor-pointer peer-checked:text-yellow-500 hover:text-yellow-400 transition">★</label>
                        <input type="radio" name="rating" value="4" id="4" class="peer hidden"><label for="4" class="text-gray-300 text-3xl cursor-pointer peer-checked:text-yellow-500 hover:text-yellow-400 transition">★</label>
                        <input type="radio" name="rating" value="3" id="3" class="peer hidden"><label for="3" class="text-gray-300 text-3xl cursor-pointer peer-checked:text-yellow-500 hover:text-yellow-400 transition">★</label>
                        <input type="radio" name="rating" value="2" id="2" class="peer hidden"><label for="2" class="text-gray-300 text-3xl cursor-pointer peer-checked:text-yellow-500 hover:text-yellow-400 transition">★</label>
                        <input type="radio" name="rating" value="1" id="1" class="peer hidden"><label for="1" class="text-gray-300 text-3xl cursor-pointer peer-checked:text-yellow-500 hover:text-yellow-400 transition">★</label>
                    </div>
                </div>

                {{-- KOMENTAR --}}
                <div class="mb-6">
                    <label class="block text-sm font-bold mb-2 text-gray-700">Komentar:</label>
                    <textarea name="komentar" rows="4" class="w-full border-2 border-gray-300 p-3 focus:border-red-600 outline-none transition" placeholder="Bagaimana kualitas barang ini?" required></textarea>
                </div>

                <button type="submit" class="w-full bg-black text-white font-bold py-3 hover:bg-red-600 transition p5-skew shadow-lg">
                    KIRIM ULASAN
                </button>
            </form>
        </div>
    </div>
</div>
@endsection