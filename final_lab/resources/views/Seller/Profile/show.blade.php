@extends('layouts.seller')

@section('title', 'Detail Profil')

@section('content')
<div class="max-w-4xl mx-auto">

    {{-- HEADER & TOMBOL EDIT --}}
    <div class="flex justify-between items-end mb-6">
        <div>
            <h1 class="text-3xl font-bold p5-font italic text-gray-800">IDENTITAS SELLER</h1>
            <p class="text-gray-500 text-sm">Informasi akun dan status toko Anda.</p>
        </div>
        <a href="{{ route('profile.index') }}" class="bg-black text-white px-6 py-2 font-bold hover:bg-red-600 transition p5-skew shadow-lg text-sm">
            EDIT PROFIL
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        {{-- KOLOM KIRI: KARTU ID (PERSONAL) --}}
        <div class="md:col-span-1">
            <div class="bg-white shadow-xl border-t-8 border-black overflow-hidden relative">
                {{-- Background Pattern --}}
                <div class="absolute top-0 right-0 w-20 h-20 bg-gray-100 rounded-bl-full z-0"></div>
                
                <div class="p-6 text-center relative z-10">
                    {{-- Avatar --}}
                    <div class="w-24 h-24 mx-auto bg-black text-white flex items-center justify-center text-4xl font-bold rounded-full mb-4 border-4 border-red-600 shadow-lg">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    
                    <h2 class="text-xl font-bold text-gray-800 mb-1">{{ $user->name }}</h2>
                    <p class="text-xs text-gray-500 font-mono mb-4">{{ $user->email }}</p>
                    
                    <div class="inline-block bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full border border-green-200 uppercase">
                        {{ $user->role }}
                    </div>
                </div>

                {{-- Footer Card --}}
                <div class="bg-gray-50 p-4 border-t border-gray-200 text-xs text-center text-gray-500">
                    Bergabung: {{ $user->created_at->format('d F Y') }}
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: DETAIL TOKO & KEAMANAN --}}
        <div class="md:col-span-2 space-y-6">
            
            {{-- Info Toko --}}
            <div class="bg-white shadow-md border-l-4 border-red-600 p-6 relative">
                <h3 class="text-lg font-bold mb-4 border-b pb-2 flex justify-between items-center">
                    <span>STATUS TOKO</span>
                    <span class="text-xs bg-black text-white px-2 py-1">LIVE</span>
                </h3>
                
                @if($user->store)
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500 text-xs uppercase font-bold">Nama Toko</p>
                            <p class="font-bold text-lg">{{ $user->store->nama_toko }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs uppercase font-bold">Total Produk</p>
                            <p class="font-bold text-lg">{{ $user->store->products->count() }} Item</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-gray-500 text-xs uppercase font-bold">Deskripsi</p>
                            <p class="text-gray-700 italic">"{{ $user->store->deskripsi ?? 'Tidak ada deskripsi' }}"</p>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100 text-right">
                        <a href="{{ route('seller.store.index') }}" class="text-red-600 text-xs font-bold hover:underline hover:text-black">
                            Kelola Toko &rarr;
                        </a>
                    </div>
                @else
                    <div class="text-center py-4 text-gray-500">
                        <p>Anda belum mengatur informasi toko.</p>
                        <a href="{{ route('seller.store.index') }}" class="text-red-600 font-bold underline">Buat Toko Sekarang</a>
                    </div>
                @endif
            </div>

            {{-- Info Keamanan Ringkas --}}
            <div class="bg-white shadow-md border border-gray-200 p-6">
                <h3 class="text-lg font-bold mb-4 border-b pb-2">KEAMANAN</h3>
                <div class="flex justify-between items-center text-sm">
                    <div>
                        <p class="font-bold">Password</p>
                        <p class="text-gray-500">********</p>
                    </div>
                    <a href="{{ route('profile.index') }}" class="text-blue-600 text-xs font-bold border border-blue-600 px-3 py-1 rounded hover:bg-blue-600 hover:text-white transition">
                        GANTI PASSWORD
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection