@extends('layouts.app')

@section('content')
<div class="container mx-auto py-12 px-4 flex justify-center">
    <div class="w-full max-w-lg bg-white shadow-2xl overflow-hidden border-t-8 border-red-600">
        <div class="p-8">
            <h1 class="text-2xl font-bold mb-2 p5-font">BERI ULASAN</h1>
            <p class="text-gray-500 mb-6">Order #{{ $order->id }}</p>

            <form action="{{ route('review.store', $order->id) }}" method="POST">
                @csrf
                
                {{-- Pilih Produk (Jika order ada banyak produk, pilih salah satu utama) --}}
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Produk yang diulas:</label>
                    <select name="produk_id" class="w-full border border-gray-300 p-2 bg-gray-50">
                        @foreach($order->items as $item)
                            <option value="{{ $item->product->id }}">{{ $item->product->nama_produk }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Rating Bintang --}}
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Rating:</label>
                    <div class="flex flex-row-reverse justify-end gap-1">
                        {{-- Teknik CSS sederhana untuk rating bintang --}}
                        <input type="radio" name="rating" value="5" id="5" class="peer hidden" required><label for="5" class="text-gray-300 text-3xl cursor-pointer peer-checked:text-yellow-500 hover:text-yellow-400">★</label>
                        <input type="radio" name="rating" value="4" id="4" class="peer hidden"><label for="4" class="text-gray-300 text-3xl cursor-pointer peer-checked:text-yellow-500 hover:text-yellow-400">★</label>
                        <input type="radio" name="rating" value="3" id="3" class="peer hidden"><label for="3" class="text-gray-300 text-3xl cursor-pointer peer-checked:text-yellow-500 hover:text-yellow-400">★</label>
                        <input type="radio" name="rating" value="2" id="2" class="peer hidden"><label for="2" class="text-gray-300 text-3xl cursor-pointer peer-checked:text-yellow-500 hover:text-yellow-400">★</label>
                        <input type="radio" name="rating" value="1" id="1" class="peer hidden"><label for="1" class="text-gray-300 text-3xl cursor-pointer peer-checked:text-yellow-500 hover:text-yellow-400">★</label>
                    </div>
                </div>

                {{-- Komentar --}}
                <div class="mb-6">
                    <label class="block text-sm font-bold mb-2">Komentar:</label>
                    <textarea name="komentar" rows="4" class="w-full border-2 border-gray-300 p-3 focus:border-red-600 outline-none" placeholder="Tulis pengalaman Anda tentang produk ini..." required></textarea>
                </div>

                <button type="submit" class="w-full bg-black text-white font-bold py-3 hover:bg-red-600 transition p5-skew">
                    KIRIM ULASAN
                </button>
            </form>
        </div>
    </div>
</div>
@endsection