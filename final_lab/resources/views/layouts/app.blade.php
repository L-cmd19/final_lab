<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'P5X Store') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        .p5-font { font-family: 'Courier New', Courier, monospace; font-weight: 900; letter-spacing: -1px; }
        .p5-skew { transform: skew(-10deg); }
        .bg-p5-red { background-color: #d60017; }
        .text-p5-red { color: #d60017; }
        .border-p5-red { border-color: #d60017; }
        
        /* Animasi Fade In */
        .fade-in { animation: fadeIn 0.5s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-900">
    <div class="min-h-screen flex flex-col">
        
        {{-- NAVIGATION BAR --}}
        {{-- Kita memanggil file navigation.blade.php yang sudah diperbaiki --}}
        @include('layouts.navigation')

        {{-- PAGE HEADER (Optional) --}}
        @if (isset($header))
            <header class="bg-white shadow border-b-4 border-black">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        {{-- MAIN CONTENT --}}
        <main class="flex-grow fade-in">
            {{-- Flash Messages (Notifikasi Sukses/Gagal) --}}
            @if(session('success'))
                <div class="max-w-7xl mx-auto mt-4 px-4">
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 shadow-md" role="alert">
                        <p class="font-bold">Sukses!</p>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="max-w-7xl mx-auto mt-4 px-4">
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 shadow-md" role="alert">
                        <p class="font-bold">Error!</p>
                        <p>{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            {{-- Isi Halaman --}}
            @yield('content')
        </main>

        {{-- FOOTER --}}
        <footer class="bg-black text-white border-t-8 border-p5-red mt-12">
            <div class="max-w-7xl mx-auto py-8 px-4 flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0 text-center md:text-left">
                    <h2 class="text-2xl font-bold p5-font italic text-red-600">PHANTOM THIEVES MARKET</h2>
                    <p class="text-gray-500 text-sm">Take Your Heart, Take Your Goods.</p>
                </div>
                <div class="flex space-x-6 text-sm font-bold text-gray-400">
                    <a href="#" class="hover:text-red-600 transition">Tentang Kami</a>
                    <a href="#" class="hover:text-red-600 transition">Syarat & Ketentuan</a>
                    <a href="#" class="hover:text-red-600 transition">Bantuan</a>
                </div>
            </div>
            <div class="bg-gray-900 text-center py-2 text-xs text-gray-600 border-t border-gray-800">
                &copy; {{ date('Y') }} P5X E-Commerce Project. All rights reserved.
            </div>
        </footer>
    </div>
</body>
</html>