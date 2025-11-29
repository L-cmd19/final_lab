@extends('layouts.app')

@section('content')
<div class="container mx-auto py-12 px-4">
    <div class="max-w-4xl mx-auto">
        {{-- Tombol Kembali --}}
        <a href="{{ route('order.history.index') }}" class="inline-flex items-center text-gray-500 hover:text-black font-bold mb-6 transition">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            KEMBALI KE RIWAYAT
        </a>

        <div class="bg-white shadow-xl overflow-hidden border-t-8 border-red-600">
            {{-- Header Order --}}
            <div class="p-6 md:p-8 border-b border-gray-200 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-gray-50">
                <div>
                    <h1 class="text-3xl font-black p5-font text-gray-800">ORDER #{{ $order->id }}</h1>
                    <p class="text-sm text-gray-500 mt-1">
                        Dipesan pada: <span class="font-bold text-gray-700">{{ $order->created_at->format('d F Y, H:i') }}</span>
                    </p>
                </div>
                
                <div class="text-right">
                    <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Status Pesanan</span>
                    <span class="inline-block px-4 py-1 text-sm font-bold uppercase rounded border 
                        {{ $order->status == 'completed' ? 'bg-green-100 text-green-700 border-green-200' : '' }}
                        {{ $order->status == 'pending' ? 'bg-yellow-100 text-yellow-700 border-yellow-200' : '' }}
                        {{ $order->status == 'cancelled' ? 'bg-red-100 text-red-700 border-red-200' : '' }}
                        {{ in_array($order->status, ['processed', 'shipped']) ? 'bg-blue-100 text-blue-700 border-blue-200' : '' }}">
                        {{ $order->status }}
                    </span>
                </div>
            </div>

            {{-- Body: Daftar Produk --}}
            <div class="p-6 md:p-8">
                <h2 class="text-lg font-bold mb-4 border-l-4 border-black pl-3 uppercase">Item yang Dibeli</h2>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left mb-8">
                        <thead>
                            <tr class="border-b-2 border-gray-200 text-gray-400 text-xs uppercase">
                                <th class="pb-3 w-1/2">Produk</th>
                                <th class="pb-3 text-center">Harga</th>
                                <th class="pb-3 text-center">Qty</th>
                                <th class="pb-3 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @foreach($order->items as $item)
                            <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50 transition">
                                <td class="py-4">
                                    <div class="flex items-center">
                                        {{-- Gambar Produk --}}
                                        <div class="h-12 w-12 flex-shrink-0 overflow-hidden border border-gray-200 mr-4 bg-gray-100">
                                            @if($item->product->gambar)
                                                <img src="{{ asset('storage/products/' . $item->product->gambar) }}" class="h-full w-full object-cover">
                                            @else
                                                <div class="h-full w-full flex items-center justify-center text-xs text-gray-400">IMG</div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-800">{{ $item->product->nama_produk }}</div>
                                            <div class="text-xs text-gray-500">Toko: <span class="text-red-600">{{ $item->product->store->nama_toko ?? 'Unknown' }}</span></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 text-center">Rp {{ number_format($item->harga_saat_pemesanan, 0, ',', '.') }}</td>
                                <td class="py-4 text-center font-bold">{{ $item->jumlah }}</td>
                                <td class="py-4 text-right font-bold">Rp {{ number_format($item->harga_saat_pemesanan * $item->jumlah, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="pt-6 text-right text-gray-500 text-sm uppercase font-bold">Total Pembayaran</td>
                                <td class="pt-6 text-right text-2xl font-black text-red-600 p5-font">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                {{-- Bagian Review / Ulasan --}}
                @if($order->status == 'completed')
                    <div class="mt-8 border-t-2 border-dashed border-gray-300 pt-8">
                        <div class="bg-gray-50 border border-gray-200 p-6 text-center">
                            <h3 class="text-xl font-bold mb-2">Barang sudah diterima?</h3>
                            
                            {{-- Cek apakah sudah direview semua atau belum --}}
                            @php
                                $reviewedProductIds = $order->reviews->pluck('produk_id')->toArray();
                                $allProductIds = $order->items->pluck('produk_id')->toArray();
                                $hasUnreviewedItems = count(array_diff($allProductIds, $reviewedProductIds)) > 0;
                            @endphp

                            @if($hasUnreviewedItems)
                                <p class="text-gray-500 mb-6">Ceritakan pengalamanmu dan bantu pembeli lain dengan memberikan ulasan.</p>
                                <a href="{{ route('review.create', $order->id) }}" class="inline-block bg-black text-white px-8 py-3 font-bold hover:bg-red-600 transition p5-skew shadow-lg transform hover:-translate-y-1">
                                    BERI ULASAN
                                </a>
                            @else
                                <div class="text-green-600 font-bold flex items-center justify-center gap-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Terima kasih! Anda telah mengulas semua produk.
                                </div>
                            @endif

                            {{-- Tampilkan Review Anda --}}
                            @if($order->reviews->count() > 0)
                                <div class="mt-8 text-left">
                                    <h4 class="font-bold text-sm text-gray-400 uppercase mb-4">Ulasan Anda di pesanan ini:</h4>
                                    <div class="grid gap-4">
                                        @foreach($order->reviews as $review)
                                            <div class="bg-white border p-4 shadow-sm flex gap-4 items-start">
                                                <img src="{{ asset('storage/products/' . $review->product->gambar) }}" class="w-12 h-12 object-cover border bg-gray-100">
                                                <div>
                                                    <div class="text-xs font-bold text-gray-500 uppercase">{{ $review->product->nama_produk }}</div>
                                                    <div class="text-yellow-500 text-lg mb-1">
                                                        @for($i=0; $i<$review->rating; $i++) ★ @endfor
                                                        <span class="text-gray-300 text-xs ml-1">({{ $review->rating }}/5)</span>
                                                    </div>
                                                    <p class="text-gray-800 italic text-sm">"{{ $review->komentar }}"</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection