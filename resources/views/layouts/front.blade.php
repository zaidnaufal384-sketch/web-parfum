<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'DJIBRAN PARFUM - Luxury Fragrances')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Jost', sans-serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        /* Style Button Custom */
        .btn-lv-sharp {
            border-radius: 0px !important; text-transform: uppercase; letter-spacing: 0.15em;
            font-size: 0.75rem; font-weight: 500; padding: 1rem 2.5rem; transition: all 0.3s ease; display: inline-block;
        }
        .btn-lv-white { background-color: white; color: black; border: 1px solid white; }
        .btn-lv-white:hover { background-color: transparent; color: white; }
        .btn-lv-outline-black { background-color: transparent; color: black; border: 1px solid black; }
        .btn-lv-outline-black:hover { background-color: black; color: white; }
        .btn-lv-pill {
            border: 1px solid #e5e7eb; border-radius: 9999px; padding: 0.75rem 2rem;
            font-size: 0.875rem; color: #1f2937; background-color: white; transition: all 0.3s ease;
        }
        .btn-lv-pill:hover { border-color: black; }
        .active-size { background-color: #111827 !important; color: white !important; border-color: #111827 !important; }
    </style>
    @stack('styles')
</head>
<body class="antialiased bg-white text-gray-900">
    {{-- ================= 2. MENU DRAWER (SIDEBAR KIRI) ================= --}}
<div class="relative z-[1000]">
    {{-- Backdrop Gelap --}}
    <div id="menu-backdrop" onclick="closeMenu()" class="fixed inset-0 bg-black/40 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300"></div>

    {{-- Panel Menu --}}
    <div id="menu-drawer" class="fixed top-0 left-0 h-full w-[350px] max-w-[85vw] bg-white shadow-2xl flex flex-col transform -translate-x-full transition-transform duration-500 cubic-bezier(0.19, 1, 0.22, 1)">
        
        {{-- Header Menu --}}
        <div class="px-8 h-[88px] flex items-center justify-between">
            <span class="text-xs font-bold uppercase tracking-widest text-gray-400">Menu</span>
            <button onclick="closeMenu()" class="text-gray-900 hover:text-gray-500 transition flex items-center gap-2">
                <span class="text-xs uppercase tracking-widest">Close</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Isi Menu --}}
        <div class="flex-1 overflow-y-auto px-8 py-4">
            <ul class="space-y-6">
                
                {{-- ITEM 1: Dashboard / Login (Tanpa Info Akun) --}}
                <li class="border-b border-gray-100 pb-6">
                    @auth
                        {{-- Jika Sudah Login: Link ke Dashboard saja --}}
                        <a href="{{ route('dashboard') }}" class="text-lg font-medium uppercase tracking-widest text-red-600 hover:text-red-800 flex items-center justify-between group">
                            Dashboard
                            <span class="text-gray-300 group-hover:text-red-600 transition">→</span>
                        </a>
                    @else
                        {{-- Jika Belum Login: Link Login --}}
                        <a href="{{ route('login') }}" class="text-lg font-medium uppercase tracking-widest text-gray-900 hover:text-gray-500 flex items-center justify-between group">
                            Login / Register
                            <span class="text-gray-300 group-hover:text-black transition">→</span>
                        </a>
                    @endauth
                </li>

                {{-- ITEM 2: Kategori Utama --}}
                
                <li>
                    <a href="{{ route('front.catalog', ['gender' => 'Men']) }}" class="text-2xl font-light uppercase tracking-widest hover:pl-2 transition-all duration-300 block">Men</a>
                </li>
                <li>
                    <a href="{{ route('front.catalog', ['gender' => 'Women']) }}" class="text-2xl font-light uppercase tracking-widest hover:pl-2 transition-all duration-300 block">Women</a>
                </li>
                <li>
                    <a href="{{ route('front.catalog', ['gender' => 'Unisex']) }}" class="text-2xl font-light uppercase tracking-widest hover:pl-2 transition-all duration-300 block">Unisex</a>
                </li>

                {{-- ITEM 3: Link Tambahan --}}
                <li class="pt-8 space-y-3">
                   
                </li>
            </ul>
        </div>

        {{-- Footer Menu --}}
        <div class="p-8 bg-gray-50 border-t border-gray-100">
            
        </div>
    </div>
</div>

    {{-- PANGGIL NAVBAR GLOBAL --}}
    @include('partials.navbar')

    {{-- KONTEN HALAMAN AKAN MUNCUL DI SINI --}}
    <main>
        @yield('content')
    </main>

    {{-- PANGGIL FOOTER GLOBAL --}}
    @include('partials.footer')

    {{-- PANGGIL CART DRAWER GLOBAL --}}
    @include('partials.cart-drawer')

    {{-- SCRIPT GLOBAL (CART LOGIC) --}}
    <script>
        // --- LOGIKA KERANJANG (CART) GLOBAL ---
        function openCart(e) {
            if(e) e.preventDefault();
            const overlay = document.getElementById('cart-overlay');
            const drawer = document.getElementById('cart-drawer');
            if(overlay && drawer) {
                overlay.classList.remove('hidden');
                setTimeout(() => {
                    overlay.classList.remove('opacity-0');
                    drawer.classList.remove('translate-x-full');
                }, 10);
                fetchCart();
            }
        }

        function closeCart() {
            const overlay = document.getElementById('cart-overlay');
            const drawer = document.getElementById('cart-drawer');
            if(overlay && drawer) {
                overlay.classList.add('opacity-0');
                drawer.classList.add('translate-x-full');
                setTimeout(() => {
                    overlay.classList.add('hidden');
                }, 300);
            }
        }

        function fetchCart() {
            fetch("{{ route('cart.index') }}")
            .then(res => res.json())
            .then(data => { renderCart(data); })
            .catch(err => console.error(err));
        }

       function renderCart(data) {
    const container = document.getElementById('cart-items-container');
    const subtotalEl = document.getElementById('cart-subtotal');
    if(!container || !subtotalEl) return;
    
    container.innerHTML = '';

    if(data.items.length === 0) {
        container.innerHTML = '<p class="text-center text-gray-400 text-sm mt-10">Your cart is empty.</p>';
        subtotalEl.innerText = 'IDR 0';
        return;
    }

    data.items.forEach(item => {
        const imgUrl = item.product.image ? `/storage/${item.product.image}` : 'https://via.placeholder.com/100';
        const totalItemPrice = item.variant.price * item.quantity;
        const formattedPrice = new Intl.NumberFormat('id-ID').format(totalItemPrice);
        
        // --- LOGIKA STOK AMAN ---
        // Kita cek dulu apakah item.variant.stock ada harganya atau tidak
        const currentStock = (item.variant && item.variant.stock !== undefined) ? item.variant.stock : 0;
        
        let stockStatusHTML = '';
        if (currentStock <= 5) {
            stockStatusHTML = `<p class="text-[9px] text-red-500 font-bold uppercase tracking-tighter mt-1">Sisa ${currentStock} botol!</p>`;
        } else {
            stockStatusHTML = `<p class="text-[9px] text-gray-400 uppercase tracking-tighter mt-1">Stok: ${currentStock}</p>`;
        }

        const html = `
            <div class="flex gap-4 border-b border-gray-50 pb-4 last:border-0">
                <div class="w-20 h-24 bg-gray-100 flex-shrink-0 overflow-hidden rounded-sm relative">
                    <img src="${imgUrl}" class="w-full h-full object-cover mix-blend-multiply">
                </div>
                <div class="flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-gray-900 line-clamp-1">${item.product.name}</h3>
                        <p class="text-[10px] uppercase tracking-wider text-gray-500 mt-1">${item.variant.size}</p>
                        
                        ${stockStatusHTML}
                    </div>
                    <div class="flex justify-between items-end mt-2">
                        <div class="flex items-center border border-gray-300 rounded-sm">
                            <button onclick="changeQuantity(${item.id}, ${item.quantity}, -1)" class="px-2 py-1 text-gray-600 hover:bg-gray-100 text-xs">-</button>
                            <span class="px-2 text-xs font-medium text-gray-900">${item.quantity}</span>
                            
                            <button onclick="changeQuantity(${item.id}, ${item.quantity}, 1)" 
                                    class="px-2 py-1 text-gray-600 hover:bg-gray-100 text-xs ${item.quantity >= currentStock ? 'opacity-20 pointer-events-none' : ''}">
                                +
                            </button>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium mb-1">IDR ${formattedPrice}</p>
                            <button onclick="removeItem(${item.id})" class="text-[10px] text-red-400 hover:text-red-600 underline decoration-red-200">Remove</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        container.innerHTML += html;
    });

    subtotalEl.innerText = 'IDR ' + new Intl.NumberFormat('id-ID').format(data.subtotal);
}

       


        function changeQuantity(itemId, currentQty, change) {
            const newQty = currentQty + change;
            if (newQty < 1) return; 

            fetch(`/cart/${itemId}`, { 
                method: "PATCH",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ quantity: newQty })
            })
            .then(res => {
                if(res.ok) { fetchCart(); } 
                else { console.error('Gagal update quantity'); }
            })
            .catch(err => console.error(err));
        }

        function removeItem(id) {
            if(!confirm("Remove item?")) return;
            fetch(`/cart/${id}`, {
                method: "DELETE",
                headers: { "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content') }
            })
            .then(() => { fetchCart(); });
        }

        // --- LOGIKA MENU DRAWER (LEFT SIDE) ---
function openMenu() {
    const backdrop = document.getElementById('menu-backdrop');
    const drawer = document.getElementById('menu-drawer');
    
    // Tampilkan Backdrop
    backdrop.classList.remove('opacity-0', 'pointer-events-none');
    
    // Geser Menu Masuk (Hapus translate negatif)
    drawer.classList.remove('-translate-x-full');
    
    // Matikan Scroll Body
    document.body.style.overflow = 'hidden';
}

function closeMenu() {
    const backdrop = document.getElementById('menu-backdrop');
    const drawer = document.getElementById('menu-drawer');
    
    // Sembunyikan Backdrop
    backdrop.classList.add('opacity-0', 'pointer-events-none');
    
    // Geser Menu Keluar (Kembalikan translate negatif)
    drawer.classList.add('-translate-x-full');
    
    // Nyalakan Scroll Body
    document.body.style.overflow = 'auto';
}


function toggleWishlist(productId) {
    fetch("{{ route('wishlist.toggle') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ product_id: productId })
    })
    .then(res => {
        if (res.status === 401) {
            window.location.href = "{{ route('login') }}";
            return;
        }
        return res.json();
    })
    .then(data => {
        const icon = document.getElementById(`icon-wishlist-${productId}`);
        if (data.status === 'added') {
            icon.setAttribute('fill', 'black'); // Ubah jadi hitam saat disukai
        } else {
            icon.setAttribute('fill', 'none'); // Kosongkan saat batal disukai
        }
    });
}
    </script>

    @stack('scripts')

    
</body>
</html>