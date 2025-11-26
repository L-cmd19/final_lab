@extends('layouts.app')

@section('content')
<div class="container mx-auto py-12 px-4">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-8 p5-font border-l-8 border-red-600 pl-4">KONFIRMASI CHECKOUT</h1>

        <div class="flex flex-col md:flex-row gap-8">
            {{-- Detail Produk --}}
            <div class="md:w-2/3 bg-white shadow-md p-6 border-t-4 border-black">
                <h2 class="text-xl font-bold mb-4 flex items-center">
                    <span class="bg-black text-white px-2 py-1 text-xs mr-2 p5-skew">1</span>
                    DAFTAR ITEM
                </h2>
                
                <div class="space-y-4">
                    @foreach($cartItems as $item)
                        <div class="flex justify-between items-center border-b pb-4">
                            <div class="flex items-center">
                                <div class="w-16 h-16 bg-gray-100 flex-shrink-0">
                                    <img src="{{ asset('storage/products/' . $item->product->gambar) }}" class="w-full h-full object-cover">
                                </div>
                                <div class="ml-4">
                                    <h4 class="font-bold text-gray-800">{{ $item->product->nama_produk }}</h4>
                                    <p class="text-sm text-gray-500">{{ $item->jumlah }} x Rp {{ number_format($item->product->harga, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <div class="font-bold">
                                Rp {{ number_format($item->product->harga * $item->jumlah, 0, ',', '.') }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Ringkasan & Tombol Bayar --}}
            <div class="md:w-1/3">
                <div class="bg-zinc-50 p-6 border border-gray-200 shadow-lg relative overflow-hidden">
                    {{-- Hiasan --}}
                    <div class="absolute -right-6 -top-6 w-16 h-16 bg-red-600 rotate-45 z-0"></div>

                    <h2 class="text-xl font-bold mb-6 relative z-10">RINGKASAN PEMBAYARAN</h2>
                    
                    <div class="flex justify-between mb-2 text-gray-600">
                        <span>Total Item ({{ $cartItems->sum('jumlah') }})</span>
                        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between mb-2 text-gray-600">
                        <span>Biaya Pengiriman</span>
                        <span class="text-green-600 font-bold">GRATIS</span>
                    </div>
                    <div class="flex justify-between mb-6 text-gray-600">
                        <span>Biaya Layanan</span>
                        <span>Rp 0</span>
                    </div>
                    
                    <div class="border-t-2 border-dashed border-gray-300 pt-4 mb-6">
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-lg">TOTAL BAYAR</span>
                            <span class="font-bold text-2xl text-red-600">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <form action="{{ route('checkout.process') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-black text-white font-bold py-4 hover:bg-red-600 transition duration-300 p5-skew shadow-lg" onclick="return confirm('Proses pesanan ini?')">
                            <span class="inline-block transform skew-x-10">BUAT PESANAN</span>
                        </button>
                    </form>
                    
                    <a href="{{ route('cart.index') }}" class="block text-center mt-4 text-sm text-gray-500 hover:text-black hover:underline">
                        Kembali ke Keranjang
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection