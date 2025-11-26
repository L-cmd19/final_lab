<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel - P5X Store</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        .p5-font { font-family: 'Courier New', Courier, monospace; font-weight: 900; letter-spacing: -1px; }
        .p5-skew { transform: skew(-10deg); }
        /* Scrollbar Custom */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #1a1a1a; }
        ::-webkit-scrollbar-thumb { background: #d60017; }
        ::-webkit-scrollbar-thumb:hover { background: #ff0000; }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased flex h-screen overflow-hidden">

    <aside class="w-64 bg-black text-white flex-shrink-0 border-r-4 border-red-600 flex flex-col relative z-20">
        <div class="h-16 flex items-center justify-center border-b border-gray-800 bg-gray-900">
            <a href="{{ route('home') }}" class="text-2xl p5-font italic text-white">
                P5X <span class="text-red-600">ADMIN</span>
            </a>
        </div>

        <nav class="flex-1 overflow-y-auto py-4">
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="block py-3 px-6 hover:bg-red-600 hover:text-white transition {{ request()->routeIs('admin.dashboard') ? 'bg-red-600 text-white font-bold border-l-4 border-white' : 'text-gray-400' }}">
                        DASHBOARD
                    </a>
                </li>

                <li class="px-6 py-2 text-xs font-bold text-gray-500 uppercase mt-4">Master Data</li>
                
                <li>
                    <a href="{{ route('admin.users.index') }}" class="block py-2 px-6 hover:text-red-500 transition {{ request()->routeIs('admin.users.*') ? 'text-red-500 font-bold' : 'text-gray-300' }}">
                        Users
                    </a>
                </li>
                
                <li>
                    <a href="{{ route('admin.categories.index') }}" class="block py-2 px-6 hover:text-red-500 transition {{ request()->routeIs('admin.categories.*') ? 'text-red-500 font-bold' : 'text-gray-300' }}">
                        Kategori
                    </a>
                </li>

                <li class="px-6 py-2 text-xs font-bold text-gray-500 uppercase mt-4">Validasi & Keamanan</li>

                <li>
                    <a href="{{ route('admin.verification.index') }}" class="block py-2 px-6 hover:text-red-500 transition {{ request()->routeIs('admin.verification.*') ? 'text-red-500 font-bold' : 'text-gray-300' }}">
                        Verifikasi Seller
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.moderation.products.index') }}" class="block py-2 px-6 hover:text-red-500 transition {{ request()->routeIs('admin.moderation.*') ? 'text-red-500 font-bold' : 'text-gray-300' }}">
                        Moderasi Produk
                    </a>
                </li>
            </ul>
        </nav>

        <div class="p-4 border-t border-gray-800 bg-gray-900">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-red-600 rounded-full flex items-center justify-center font-bold">A</div>
                <div class="text-sm">
                    <div class="font-bold">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-gray-500">Administrator</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <button type="submit" class="w-full text-xs bg-gray-800 hover:bg-red-600 py-2 text-white transition uppercase font-bold">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden relative">
        <header class="h-16 bg-white shadow flex items-center justify-between px-6 relative z-10">
            <h2 class="font-bold text-xl text-gray-800 p5-font uppercase">
                @yield('title', 'Admin Area')
            </h2>
            <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-black underline">Lihat Website &rarr;</a>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 shadow" role="alert">
                    <p class="font-bold">Berhasil</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 shadow" role="alert">
                    <p class="font-bold">Error</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</body>
</html>