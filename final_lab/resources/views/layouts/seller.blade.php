<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Seller Dashboard - P5X Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .p5-font { font-family: 'Courier New', Courier, monospace; font-weight: 900; letter-spacing: -1px; }
        .p5-skew { transform: skew(-10deg); }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased flex h-screen overflow-hidden">

    <aside class="w-64 bg-white text-gray-800 flex-shrink-0 border-r border-gray-200 flex flex-col relative z-20 shadow-xl">
        <div class="h-16 flex items-center justify-center border-b-4 border-black bg-black">
            <a href="{{ route('home') }}" class="text-xl p5-font italic text-white">
                SELLER <span class="text-red-600">ZONE</span>
            </a>
        </div>

        <nav class="flex-1 overflow-y-auto py-4">
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('seller.dashboard') }}" class="block py-3 px-6 hover:bg-gray-100 transition {{ request()->routeIs('seller.dashboard') ? 'border-r-4 border-red-600 bg-gray-50 font-bold text-red-600' : '' }}">
                        Dashboard
                    </a>
                </li>

                <li class="px-6 py-2 text-xs font-bold text-gray-400 uppercase mt-4">Manajemen Toko</li>
                
                <li>
                    <a href="{{ route('seller.store.index') }}" class="block py-2 px-6 hover:text-red-600 transition {{ request()->routeIs('seller.store.*') ? 'text-red-600 font-bold' : '' }}">
                        Informasi Toko
                    </a>
                </li>
                
                <li>
                    <a href="{{ route('seller.products.index') }}" class="block py-2 px-6 hover:text-red-600 transition {{ request()->routeIs('seller.products.*') ? 'text-red-600 font-bold' : '' }}">
                        Produk Saya
                    </a>
                </li>

                <li class="px-6 py-2 text-xs font-bold text-gray-400 uppercase mt-4">Transaksi</li>

                <li>
                    <a href="{{ route('seller.orders.index') }}" class="block py-2 px-6 hover:text-red-600 transition {{ request()->routeIs('seller.orders.*') ? 'text-red-600 font-bold' : '' }}">
                        Pesanan Masuk
                        {{-- Badge count (Optional logic) --}}
                        {{-- <span class="bg-red-600 text-white text-xs px-2 py-0.5 rounded-full ml-2">New</span> --}}
                    </a>
                </li>
            </ul>
        </nav>

        <div class="p-4 border-t border-gray-200 bg-gray-50">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-black text-white rounded-full flex items-center justify-center font-bold">S</div>
                <div class="text-sm overflow-hidden">
                    <div class="font-bold truncate">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-gray-500 truncate">{{ Auth::user()->store->nama_toko ?? 'Toko Baru' }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <button type="submit" class="w-full text-xs border border-black text-black hover:bg-black hover:text-white py-2 transition uppercase font-bold p5-skew">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="h-16 bg-white shadow-sm flex items-center justify-between px-6 border-b border-gray-200">
            <h2 class="font-bold text-xl text-gray-800 p5-font uppercase text-red-600">
                @yield('title', 'Seller Panel')
            </h2>
            <a href="{{ route('home') }}" class="text-sm font-bold hover:text-red-600">Ke Halaman Utama &rarr;</a>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-zinc-50 p-6">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</body>
</html>