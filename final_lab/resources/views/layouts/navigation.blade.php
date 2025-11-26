<nav x-data="{ open: false }" class="bg-black border-b-4 border-p5-red sticky top-0 z-50 shadow-xl">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-white font-black text-2xl tracking-tighter p5-font italic hover:text-red-600 transition duration-300">
                        P5X<span class="text-red-600">STORE</span>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex items-center">
                    <a href="{{ route('home') }}" class="text-white font-bold uppercase text-sm hover:text-red-500 transition">
                        Home
                    </a>
                    <a href="{{ route('product.list') }}" class="text-white font-bold uppercase text-sm hover:text-red-500 transition">
                        Katalog
                    </a>
                    
                    {{-- Menu Khusus Admin --}}
                    @if(Auth::check() && Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="text-red-500 font-bold uppercase text-sm border border-red-600 px-2 py-1 hover:bg-red-600 hover:text-white transition">
                            Area Admin
                        </a>
                    @endif

                    {{-- Menu Khusus Seller --}}
                    @if(Auth::check() && Auth::user()->isApprovedSeller())
                        <a href="{{ route('seller.dashboard') }}" class="text-blue-400 font-bold uppercase text-sm border border-blue-400 px-2 py-1 hover:bg-blue-600 hover:text-white transition">
                            Area Seller
                        </a>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-4">
                
                @auth
                    {{-- Cart Icon (Buyer Only) --}}
                    @if(Auth::user()->isBuyer())
                        <a href="{{ route('cart.index') }}" class="relative text-white hover:text-red-500 transition group">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            {{-- Badge Count (Optional) --}}
                            @if(Auth::user()->carts->count() > 0)
                                <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
                                    {{ Auth::user()->carts->sum('jumlah') }}
                                </span>
                            @endif
                        </a>
                    @endif

                    {{-- User Dropdown --}}
                    <div class="relative ml-3" x-data="{ open: false }">
                        <div>
                            <button @click="open = !open" class="flex items-center text-sm font-medium text-gray-300 hover:text-white focus:outline-none transition duration-150 ease-in-out">
                                <div class="font-bold mr-1">{{ Auth::user()->name }}</div>
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>

                        {{-- Dropdown Menu (Menggunakan AlpineJS logic sederhana atau CSS hover) --}}
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white border-2 border-black shadow-lg py-1 origin-top-right z-50" style="display: none;">
                            <div class="px-4 py-2 text-xs text-gray-500 border-b bg-gray-50">
                                {{ Auth::user()->email }}
                            </div>
                            
                            <a href="{{ route('profile.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil Saya</a>
                            
                            @if(Auth::user()->isBuyer())
                                <a href="{{ route('order.history.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Riwayat Belanja</a>
                            @endif

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 font-bold hover:bg-red-50">
                                    LOGOUT
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-white font-bold text-sm hover:text-red-500 uppercase">Login</a>
                    <a href="{{ route('register') }}" class="ml-4 bg-white text-black px-4 py-2 font-bold text-sm uppercase hover:bg-red-600 hover:text-white transition p5-skew">Register</a>
                @endauth
            </div>
        </div>
    </div>
    
    {{-- Script sederhana untuk toggle dropdown jika tidak pakai Alpine.js --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.querySelector('[x-data] button');
            const menu = document.querySelector('[x-data] [x-show]');
            if(btn && menu) {
                btn.addEventListener('click', () => {
                    menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
                });
                document.addEventListener('click', (e) => {
                    if (!btn.contains(e.target) && !menu.contains(e.target)) {
                        menu.style.display = 'none';
                    }
                });
            }
        });
    </script>
</nav>