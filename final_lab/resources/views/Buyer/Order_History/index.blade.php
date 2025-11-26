@extends('layouts.app')

@section('content')
<div class="container mx-auto py-12 px-4">
    <h1 class="text-3xl font-bold mb-8 p5-font">RIWAYAT BELANJA</h1>

    @if($orders->isEmpty())
        <div class="bg-white p-12 text-center border shadow-sm">
            <h3 class="text-xl text-gray-500 mb-4">Kamu belum pernah berbelanja.</h3>
            <a href="{{ route('home') }}" class="bg-red-600 text-white px-6 py-2 font-bold hover:bg-black transition">MULAI BELANJA</a>
        </div>
    @else
        <div class="space-y-6">
            @foreach($orders as $order)
                <div class="bg-white border border-gray-200 shadow-sm hover:shadow-md transition">
                    {{-- Header Order --}}
                    <div class="bg-gray-50 px-6 py-4 border-b flex justify-between items-center flex-wrap gap-4">
                        <div class="flex gap-6 text-sm">
                            <div>
                                <div class="text-gray-500 uppercase text-xs">Tanggal Order</div>
                                <div class="font-bold">{{ $order->created_at->format('d M Y') }}</div>
                            </div>
                            <div>
                                <div class="text-gray-500 uppercase text-xs">Total</div>
                                <div class="font-bold">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</div>
                            </div>
                            <div>
                                <div class="text-gray-500 uppercase text-xs">Status</div>
                                <span class="px-2 py-0.5 rounded text-xs font-bold uppercase 
                                    {{ $order->status == 'completed' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $order->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                    {{ $order->status == 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ $order->status }}
                                </span>
                            </div>
                        </div>
                        <a href="{{ route('order.history.show', $order->id) }}" class="text-red-600 font-bold hover:underline text-sm">LIHAT DETAIL PESANAN</a>
                    </div>

                    {{-- Body Order (Preview Item Pertama) --}}
                    <div class="p-6 flex items-center">
                        @php $firstItem = $order->items->first(); @endphp
                        @if($firstItem)
                            <img src="{{ asset('storage/products/' . $firstItem->product->gambar) }}" class="w-16 h-16 object-cover border mr-4">
                            <div>
                                <div class="font-bold text-lg">{{ $firstItem->product->nama_produk }}</div>
                                <div class="text-gray-500 text-sm">
                                    {{ $firstItem->jumlah }} barang x Rp {{ number_format($firstItem->harga_saat_pemesanan, 0, ',', '.') }}
                                </div>
                                @if($order->items->count() > 1)
                                    <div class="text-xs text-gray-400 mt-1">+ {{ $order->items->count() - 1 }} produk lainnya</div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection