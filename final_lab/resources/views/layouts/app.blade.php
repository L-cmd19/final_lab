<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>P5X Store - Phantom Thieves Market</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Gaya P5 sederhana */
        .p5-font { font-family: sans-serif; font-style: italic; font-weight: 800; }
        .p5-red { background-color: #d60017; }
        .p5-skew { transform: skew(-10deg); }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-900">
    <div class="min-h-screen flex flex-col">
        
        {{-- NAVBAR --}}
        <nav class="bg-black text-white p-4 border-b-4 border-red-600 sticky top-0 z-50">
            <div class="container mx-auto flex justify-between items-center">
                <a href="{{ url('/') }}" class="text-2xl p5-font tracking-widest text-red-600 hover:text-white transition">
                    P5X STORE
                </a>

                <div class="flex space-x-6 items-center font-bold uppercase">
                    @auth
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.users.index') }}" class="hover:text-red-500">Users</a>
                            <a href="{{ route('admin.categories.index') }}" class="hover:text-red-500">Kategori</a>
                            <a href="{{ route('admin.verification.index') }}" class="hover:text-red-500">Verifikasi Seller</a>
                        @elseif(Auth::user()->isApprovedSeller())
                            <a href="{{ route('seller.store.index') }}" class="hover:text-red-500">Tokoku</a>
                            <a href="{{ route('seller.products.index') }}" class="hover:text-red-500">Produk</a>
                            <a href="{{ route('seller.orders.index') }}" class="hover:text-red-500">Pesanan Masuk</a>
                        @elseif(Auth::user()->isBuyer())
                            <a href="{{ route('order.history.index') }}" class="hover:text-red-500">Riwayat Belanja</a>
                            <a href="{{ route('cart.index') }}" class="bg-red-600 px-4 py-1 p5-skew text-white hover:bg-white hover:text-red-600 transition">
                                <span style="transform: skew(10deg); display:inline-block;">KERANJANG</span>
                            </a>
                        @endif

                        <div class="relative group ml-4">
                            <button class="flex items-center space-x-1 focus:outline-none">
                                <span class="text-red-500">{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white text-black rounded shadow-xl hidden group-hover:block border-2 border-black">
                                <a href="{{ route('profile.index') }}" class="block px-4 py-2 hover:bg-gray-200">Profil</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-red-600 hover:text-white">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="hover:text-red-500">Login</a>
                        <a href="{{ route('register') }}" class="border border-white px-3 py-1 hover:bg-white hover:text-black transition">Register</a>
                    @endauth
                </div>
            </div>
        </nav>

        {{-- CONTENT --}}
        <main class="flex-grow">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>

        {{-- FOOTER --}}
        <footer class="bg-black text-white text-center py-6 mt-10 border-t-4 border-red-600">
            <p>&copy; 2025 P5X E-Commerce Project. Take Your Heart.</p>
        </footer>
    </div>
</body>
</html>