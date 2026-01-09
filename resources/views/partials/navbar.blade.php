<nav id="main-navbar" 
     class="fixed w-full z-50 top-0 transition-all duration-500 
     {{ request()->routeIs('welcome') || request()->is('/') ? 'bg-transparent text-white border-transparent hover:bg-white hover:text-gray-900' : 'bg-white/90 text-gray-900 border-b border-gray-100 backdrop-blur-md' }} 
     group">
    <div class="max-w-[1800px] mx-auto px-6 lg:px-12">
        <div class="h-[88px] flex items-center justify-between">
            
            {{-- KIRI: MENU ONLY --}}
            <div class="flex items-center gap-8 w-1/3">
                <button onclick="openMenu()" class="hover:opacity-60 transition p-1 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
                {{-- Tombol Search sudah dihapus dari sini --}}
            </div>

            {{-- TENGAH: LOGO --}}
            <div class="w-1/3 flex justify-center">
                <a href="/" class="text-2xl md:text-3xl tracking-[0.25em] uppercase font-medium">
                    DJIBRAN PARFUM
                </a>
            </div>

            {{-- KANAN: CART & USER --}}
            <div class="flex items-center justify-end gap-8 w-1/3">
                {{-- Bagian Wishlist dan Counternya sudah dihapus total --}}
                
                {{-- CART ICON (TRIGGER SIDEBAR) --}}
                <a href="#" onclick="openCart(event)" class="flex items-center gap-3 hover:opacity-70 transition">
                    <span class="text-[11px] uppercase tracking-[0.2em] font-medium hidden lg:block mt-0.5">Cart</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 5.408c.63 2.712-.42 5.09-2.58 6.002-1.91.808-4.402.08-5.323-2.072M8.25 19.5a3.75 3.75 0 1 1-7.5 0M15.75 10.5H5.25" />
                    </svg>
                </a>

                {{-- USER DROPDOWN (ALPINE JS) --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center gap-3 hover:opacity-70 transition focus:outline-none">
                        <span class="text-[11px] uppercase tracking-[0.2em] font-medium hidden lg:block mt-0.5">
                            @auth {{ Auth::user()->name }} @else Login @endauth
                        </span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                    </button>

                    <div x-show="open" 
                         @click.outside="open = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="absolute right-0 mt-2 w-56 origin-top-right bg-white divide-y divide-gray-100 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none z-50 py-1"
                         style="display: none;">
                         
                        @auth
                            <div class="px-4 py-3">
                                <p class="text-[10px] uppercase tracking-widest text-gray-500">Signed in as</p>
                                <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            <div class="py-1">
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-xs uppercase tracking-widest text-gray-700 hover:bg-gray-100">Dashboard</a>
                                <a href="{{ route('orders.history') }}" class="block px-4 py-2 text-xs uppercase tracking-widest text-gray-700 hover:bg-gray-100">Order History</a>
                            </div>
                            <div class="py-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2 text-xs uppercase tracking-widest text-red-600 hover:bg-gray-100">Log Out</a>
                                </form>
                            </div>
                        @else
                            <div class="py-1">
                                <a href="{{ route('login') }}" class="block px-4 py-2 text-xs uppercase tracking-widest text-gray-700 hover:bg-gray-100">Login</a>
                                <a href="{{ route('register') }}" class="block px-4 py-2 text-xs uppercase tracking-widest text-gray-700 hover:bg-gray-100">Create Account</a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>