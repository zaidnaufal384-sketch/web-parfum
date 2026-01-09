    <div id="cart-overlay" onclick="closeCart()" 
        class="fixed inset-0 bg-black/50 z-[60] hidden transition-opacity duration-300 opacity-0">
    </div>

    <div id="cart-drawer" 
        class="fixed top-0 right-0 h-full w-[400px] bg-white z-[70] transform translate-x-full transition-transform duration-300 shadow-2xl flex flex-col">
        
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-white">
            <h2 class="text-sm uppercase tracking-[0.2em] font-medium">Shopping Cart</h2>
            <button onclick="closeCart()" class="hover:rotate-90 transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div id="cart-items-container" class="flex-1 overflow-y-auto p-6 space-y-6">
            <div class="text-center text-gray-400 mt-10">Loading...</div>
        </div>

        <div class="p-6 border-t border-gray-100 bg-gray-50">
            <div class="flex justify-between items-center mb-4">
                <span class="text-xs uppercase tracking-widest text-gray-500">Subtotal</span>
                <span id="cart-subtotal" class="font-medium text-lg">IDR 0</span>
            </div>
            <p class="text-[10px] text-gray-400 mb-4 text-center">Shipping & taxes calculated at checkout.</p>
            <a href="{{ route('checkout.index') }}" class="block w-full bg-black text-white text-center py-4 text-xs uppercase tracking-[0.2em] hover:bg-gray-800 transition">
                Checkout Now
            </a>
        </div>
    </div>