<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

               <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
    {{-- MENU KHUSUS ADMIN --}}
    @if(Auth::user()->role === 'admin')
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            {{ __('Dashboard') }}
        </x-nav-link>

        <x-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
            {{ __('Kategori') }}
        </x-nav-link>

        <x-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">
            {{ __('Produk') }}
        </x-nav-link>

        <x-nav-link :href="route('admin.notes.index')" :active="request()->routeIs('admin.notes.*')">
            {{ __('Notes') }}
        </x-nav-link>

        <x-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">
            {{ __('Orders (Admin)') }}
        </x-nav-link>
    @endif

    {{-- MENU KHUSUS USER / PELANGGAN --}}
    @if(Auth::user()->role === 'user')
        <x-nav-link :href="route('orders.history')" :active="request()->routeIs('orders.history')">
            {{ __('Pesanan Saya') }}
        </x-nav-link>
    @endif
</div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    
                    {{-- TRIGGER: ICON USER --}}
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            {{-- 
                                Disini saya menggunakan SVG Icon User (mirip gambar yang Anda kirim).
                                Jika Anda ingin menggunakan file gambar asli (png/jpg), hapus tag <svg>...</svg> 
                                dan ganti dengan: <img src="{{ asset('path/to/image_18474d.png') }}" class="h-8 w-8" /> 
                            --}}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </button>
                    </x-slot>

                    {{-- ISI DROPDOWN --}}
                    <x-slot name="content">
                        
                        {{-- KONDISI 1: SUDAH LOGIN --}}
                        @auth
                            <div class="px-4 py-3 border-b border-gray-100 bg-gray-50">
                                <div class="font-medium text-base text-gray-800 leading-tight">
                                    {{ Auth::user()->name }}
                                </div>
                                <div class="font-medium text-sm text-gray-500">
                                    {{ Auth::user()->email }}
                                </div>
                            </div>

                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        @endauth

                        {{-- KONDISI 2: BELUM LOGIN (GUEST) --}}
                        @guest
                            <div class="px-4 py-2 text-xs text-gray-400">
                                {{ __('Akun') }}
                            </div>

                            <x-dropdown-link :href="route('login')">
                                {{ __('Login') }}
                            </x-dropdown-link>
                            
                            <x-dropdown-link :href="route('register')">
                                {{ __('Register') }}
                            </x-dropdown-link>
                        @endguest

                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            
            {{-- LOGIKA MOBILE: SUDAH LOGIN --}}
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @endauth

            {{-- LOGIKA MOBILE: BELUM LOGIN --}}
            @guest
                <div class="px-4 pb-2 text-sm text-gray-500">
                    Selamat datang, tamu.
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('Login') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')">
                        {{ __('Register') }}
                    </x-responsive-nav-link>
                </div>
            @endguest

        </div>
    </div>
</nav>