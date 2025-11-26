@extends('layouts.app')

@section('content')
<div class="container mx-auto py-12 px-4">
    <h1 class="text-3xl font-bold mb-8 p5-font border-b-4 border-red-600 inline-block pb-2">PESANAN MASUK</h1>

    @if($incomingOrders->isEmpty())
        <div class="bg-white p-12 text-center border shadow-sm">
            <h3 class="text-xl text-gray-500">Belum ada pesanan masuk.</h3>
        </div>
    @else
        <div class="space-y-4">
            @foreach($incomingOrders as $order)
                <div class="bg-white border-l-4 {{ $order->status == 'pending' ? 'border-yellow-500' : ($order->status == 'completed' ? 'border-green-500' : 'border-gray-800') }} shadow-md p-6 flex flex-col md:flex-row justify-between items-center">
                    
                    {{-- Info Dasar --}}
                    <div class="mb-4 md:mb-0 w-full md:w-1/2">
                        <div class="text-xs text-gray-400 font-bold uppercase mb-1">Order #{{ $order->id }} • {{ $order->created_at->diffForHumans() }}</div>
                        <div class="font-bold text-lg">{{ $order->user->name }} (Buyer)</div>
                        <div class="text-sm text-gray-500">
                            {{-- Tampilkan beberapa item --}}
                            @foreach($order->items->take(2) as $item)
                                <div>• {{ $item->product->nama_produk }} (x{{ $item->jumlah }})</div>
                            @endforeach
                            @if($order->items->count() > 2) <span class="text-xs italic">+ lainnya...</span> @endif
                        </div>
                    </div>

                    {{-- Status Badge --}}
                    <div class="mb-4 md:mb-0">
                        <span class="px-3 py-1 text-sm font-bold uppercase rounded 
                            {{ $order->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $order->status == 'processed' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $order->status == 'shipped' ? 'bg-purple-100 text-purple-800' : '' }}
                            {{ $order->status == 'completed' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $order->status == 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ $order->status }}
                        </span>
                    </div>

                    {{-- Aksi --}}
                    <div>
                        <a href="{{ route('seller.orders.show', $order->id) }}" class="inline-block bg-black text-white px-5 py-2 font-bold hover:bg-red-600 transition text-sm">
                            KELOLA PESANAN
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-8">
            {{ $incomingOrders->links() }}
        </div>
    @endif
</div>
@endsection