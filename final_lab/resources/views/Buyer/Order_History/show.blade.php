@extends('layouts.app')

@section('content')
<div class="container mx-auto py-12 px-4">
    <a href="{{ route('order.history.index') }}" class="text-gray-500 hover:text-black mb-6 inline-block font-bold">&larr; KEMBALI KE RIWAYAT</a>

    <div class="bg-white shadow-lg overflow-hidden border-t-4 border-red-600">
        <div class="p-6 md:p-8 flex flex-col md:flex-row justify-between items-start border-b">
            <div>
                <h1 class="text-2xl font-bold mb-2">DETAIL PESANAN #{{ $order->id }}</h1>
                <p class="text-gray-500">Dipesan pada {{ $order->created_at->format('d F Y, H:i') }}</p>
            </div>
            
            <div class="mt-4 md:mt-0 text-right">
                <div class="uppercase text-xs text-gray-500 font-bold mb-1">Status Pesanan</div>
                <span class="text-xl font-bold uppercase tracking-wide 
                    {{ $order->status == 'completed' ? 'text-green-600' : '' }}
                    {{ $order->status == 'pending' ? 'text-yellow-600' : '' }}
                    {{ $order->status == 'cancelled' ? 'text-red-600' : 'text-blue-600' }}">
                    {{ $order->status }}
                </span>
            </div>
        </div>

        <div class="p-6 md:p-8">
            <h3 class="font-bold text-lg mb-4">Produk yang Dibeli</h3>
            <table class="w-full text-left mb-8">
                <thead>
                    <tr class="border-b-2 border-gray-200 text-gray-500 text-sm uppercase">
                        <th class="pb-2">Produk</th>
                        <th class="pb-2">Toko</th>
                        <th class="pb-2 text-right">Harga</th>
                        <th class="pb-2 text-center">Qty</th>
                        <th class="pb-2 text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr class="border-b border-gray-100 last:border-0">
                        <td class="py-4">
                            <div class="font-bold">{{ $item->product->nama_produk }}</div>
                        </td>
                        <td class="py-4 text-sm text-gray-500">
                            {{ $item->product->store->nama_toko ?? '-' }}
                        </td>
                        <td class="py-4 text-right">Rp {{ number_format($item->harga_saat_pemesanan, 0, ',', '.') }}</td>
                        <td class="py-4 text-center">{{ $item->jumlah }}</td>
                        <td class="py-4 text-right font-bold">Rp {{ number_format($item->harga_saat_pemesanan * $item->jumlah, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="pt-6 text-right font-bold text-gray-600">TOTAL PEMBAYARAN</td>
                        <td class="pt-6 text-right font-bold text-2xl text-red-600">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>

            {{-- Tombol Review (Hanya jika Completed dan belum ada review) --}}
            @if($order->status == 'completed')
                <div class="bg-gray-50 p-6 border-2 border-dashed border-gray-300 rounded text-center">
                    @if($order->review)
                        <div class="text-green-600 font-bold mb-2">✓ Anda sudah memberikan review</div>
                        <div class="text-yellow-500 text-xl">
                            @for($i=0; $i<$order->review->rating; $i++) ★ @endfor
                        </div>
                        <p class="italic text-gray-600 mt-2">"{{ $order->review->komentar }}"</p>
                    @else
                        <h4 class="font-bold text-lg mb-2">Bagaimana pesanan Anda?</h4>
                        <p class="text-gray-500 mb-4">Bantu pengguna lain dengan memberikan ulasan produk ini.</p>
                        <a href="{{ route('review.create', $order->id) }}" class="inline-block bg-black text-white px-6 py-2 font-bold hover:bg-red-600 transition p5-skew">
                            BERI ULASAN
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection