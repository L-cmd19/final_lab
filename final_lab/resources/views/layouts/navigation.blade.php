<nav class="bg-black border-b-4 border-p5-red sticky top-0 z-50 shadow-xl" x-data="{ mobileMenuOpen: false }">
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
                    
                    @if(Auth::check() && Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="text-red-500 font-bold uppercase text-sm border border-red-600 px-2 py-1 hover:bg-red-600 hover:text-white transition">
                            Area Admin
                        </a>
                    @endif

                    @if(Auth::check() && Auth::user()->isApprovedSeller())
                        <a href="{{ route('seller.dashboard') }}" class="text-blue-400 font-bold uppercase text-sm border border-blue-400 px-2 py-1 hover:bg-blue-600 hover:text-white transition">
                            Area Seller
                        </a>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-4">
                
                @auth
                    {{-- CART ICON (Hanya Buyer) --}}
                    @if(Auth::user()->isBuyer())
                        <a href="{{ route('cart.index') }}" class="relative text-white hover:text-red-500 transition group mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            @if(Auth::user()->carts->count() > 0)
                                <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
                                    {{ Auth::user()->carts->sum('jumlah') }}
                                </span>
                            @endif
                        </a>
                    @endif

                    {{-- USER DROPDOWN (FIX: MENGGUNAKAN KLIK ALPINE.JS) --}}
                    <div class="relative ml-3" x-data="{ open: false }">
                        
                        {{-- Tombol Pemicu --}}
                        <button @click="open = !open" class="flex items-center text-sm font-medium text-gray-300 hover:text-white focus:outline-none transition duration-150 ease-in-out py-4">
                            <div class="font-bold mr-1">{{ Auth::user()->name }}</div>
                            {{-- Ikon Panah Berputar --}}
                            <svg class="fill-current h-4 w-4 transform transition-transform duration-200" :class="{'rotate-180': open}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        {{-- Menu Dropdown --}}
                        <div x-show="open" 
                             @click.outside="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 top-full mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 z-50 origin-top-right"
                             style="display: none;">
                            
                            <div class="px-4 py-2 text-xs text-gray-500 border-b border-gray-100">
                                {{ Auth::user()->email }}
                            </div>

                            <a href="{{ route('profile.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-red-600 font-bold transition">
                                Profil Saya
                            </a>

                            @if(Auth::user()->isBuyer())
                                <a href="{{ route('order.history.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-red-600 font-bold transition">
                                    Riwayat Belanja
                                </a>
                            @endif

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 font-bold hover:bg-red-50 transition border-t border-gray-100">
                                    LOGOUT
                                </button>
                            </form>
                        </div>
                    </div>

                @else
                    <a href="{{ route('login') }}" class="text-white font-bold text-sm hover:text-red-500 uppercase transition">Login</a>
                    <a href="{{ route('register') }}" class="ml-4 bg-white text-black px-4 py-2 font-bold text-sm uppercase hover:bg-red-600 hover:text-white transition p5-skew shadow">Register</a>
                @endauth
            </div>

            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="mobileMenuOpen = ! mobileMenuOpen" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': mobileMenuOpen, 'inline-flex': ! mobileMenuOpen }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! mobileMenuOpen, 'inline-flex': mobileMenuOpen }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': mobileMenuOpen, 'hidden': ! mobileMenuOpen}" class="hidden sm:hidden bg-gray-900 border-t border-gray-700">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('home') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-300 hover:text-white hover:bg-gray-800 hover:border-red-500 transition">
                Home
            </a>
            <a href="{{ route('product.list') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-300 hover:text-white hover:bg-gray-800 hover:border-red-500 transition">
                Katalog
            </a>
        </div>

        @auth
            <div class="pt-4 pb-1 border-t border-gray-700">
                <div class="px-4">
                    <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-400">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <a href="{{ route('profile.index') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-400 hover:text-white hover:bg-gray-800 hover:border-red-500 transition">
                        Profil Saya
                    </a>
                    
                    @if(Auth::user()->isBuyer())
                        <a href="{{ route('cart.index') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-400 hover:text-white hover:bg-gray-800 hover:border-red-500 transition">
                            Keranjang Belanja
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-red-500 hover:text-red-400 hover:bg-gray-800 hover:border-red-500 transition">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-1 border-t border-gray-700">
                <a href="{{ route('login') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-300 hover:text-white hover:bg-gray-800 hover:border-red-500 transition">
                    Login
                </a>
                <a href="{{ route('register') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-300 hover:text-white hover:bg-gray-800 hover:border-red-500 transition">
                    Register
                </a>
            </div>
        @endauth
    </div>
</nav>