@extends('layouts.app')

@section('content')
<div class="container mx-auto py-12 px-4">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold p5-font border-l-8 border-red-600 pl-4">KELOLA PRODUK</h1>
        <a href="{{ route('seller.products.create') }}" class="bg-black text-white px-6 py-3 font-bold hover:bg-red-600 transition p5-skew shadow-lg">
            + TAMBAH PRODUK
        </a>
    </div>

    <div class="bg-white shadow-md overflow-hidden border-t-4 border-black">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-100 border-b-2 border-gray-300 uppercase text-sm font-bold text-gray-600">
                <tr>
                    <th class="p-4">Produk</th>
                    <th class="p-4">Kategori</th>
                    <th class="p-4">Harga</th>
                    <th class="p-4 text-center">Stok</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="p-4">
                        <div class="flex items-center">
                            <img src="{{ asset('storage/products/' . $product->gambar) }}" class="w-12 h-12 object-cover mr-4 border border-gray-300">
                            <div>
                                <div class="font-bold">{{ $product->nama_produk }}</div>
                                <div class="text-xs text-gray-500 truncate w-48">{{ Str::limit($product->deskripsi, 30) }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="p-4">
                        <span class="bg-gray-200 text-gray-700 px-2 py-1 text-xs font-bold rounded uppercase">
                            {{ $product->category->nama_kategori ?? '-' }}
                        </span>
                    </td>
                    <td class="p-4 font-bold">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                    <td class="p-4 text-center">
                        <span class="font-bold {{ $product->stok < 5 ? 'text-red-600' : 'text-green-600' }}">
                            {{ $product->stok }}
                        </span>
                    </td>
                    <td class="p-4 text-center">
                        <div class="flex justify-center space-x-2">
                            <a href="{{ route('seller.products.edit', $product->id) }}" class="text-blue-600 hover:text-blue-800 font-bold text-sm border border-blue-600 px-2 py-1 rounded">Edit</a>
                            
                            <form action="{{ route('seller.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin hapus produk ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-bold text-sm border border-red-600 px-2 py-1 rounded">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @if($products->isEmpty())
            <div class="p-8 text-center text-gray-500">Belum ada produk. Silakan tambah produk baru.</div>
        @endif
    </div>
    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection