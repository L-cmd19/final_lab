@extends('layouts.app')

@section('content')
<div class="container mx-auto py-12 px-4">
    <h1 class="text-3xl font-bold mb-8 p5-font border-b-4 border-black inline-block pb-2">KERANJANG BELANJA</h1>

    @if($cartItems->isEmpty())
        <div class="text-center py-20 bg-gray-50 border-2 border-dashed border-gray-300">
            <h2 class="text-2xl font-bold text-gray-400 mb-4">Keranjang Kosong</h2>
            <a href="{{ route('home') }}" class="text-red-600 font-bold hover:underline">Kembali Belanja</a>
        </div>
    @else
        <div class="flex flex-col lg:flex-row gap-8">
            {{-- Tabel Item --}}
            <div class="lg:w-2/3">
                <div class="bg-white shadow-md border-t-4 border-red-600">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 border-b border-gray-300 text-sm uppercase text-gray-600">
                                <th class="p-4">Produk</th>
                                <th class="p-4">Harga</th>
                                <th class="p-4">Qty</th>
                                <th class="p-4">Total</th>
                                <th class="p-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="p-4">
                                    <div class="flex items-center">
                                        <img src="{{ asset('storage/products/' . $item->product->gambar) }}" class="w-16 h-16 object-cover mr-4 border">
                                        <span class="font-bold">{{ $item->product->nama_produk }}</span>
                                    </div>
                                </td>
                                <td class="p-4">Rp {{ number_format($item->product->harga, 0, ',', '.') }}</td>
                                <td class="p-4">
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" name="jumlah" value="{{ $item->jumlah }}" min="1" class="w-16 border px-2 py-1 text-center text-sm">
                                        <button type="submit" class="text-blue-600 text-xs ml-2 hover:underline">Update</button>
                                    </form>
                                </td>
                                <td class="p-4 font-bold">Rp {{ number_format($item->product->harga * $item->jumlah, 0, ',', '.') }}</td>
                                <td class="p-4">
                                    <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 font-bold text-sm hover:underline" onclick="return confirm('Hapus item?')">HAPUS</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Summary & Checkout --}}
            <div class="lg:w-1/3">
                <div class="bg-black text-white p-6 shadow-xl p5-skew">
                    <h2 class="text-xl font-bold mb-4 border-b border-gray-700 pb-2">RINGKASAN PESANAN</h2>
                    <div class="flex justify-between mb-2">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between mb-6 text-sm text-gray-400">
                        <span>Pajak & Biaya</span>
                        <span>-</span>
                    </div>
                    <div class="flex justify-between text-2xl font-bold text-red-500 mb-8 pt-4 border-t border-gray-700">
                        <span>TOTAL</span>
                        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    
                    <a href="{{ route('checkout.index') }}" class="block w-full bg-red-600 text-center text-white font-bold py-4 hover:bg-white hover:text-black transition duration-300 shadow-lg">
                        LANJUT KE CHECKOUT
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection