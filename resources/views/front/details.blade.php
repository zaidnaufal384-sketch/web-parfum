@extends('layouts.front')

@section('title', $product->name . ' - LOUIS PARFUM')

@section('content')

    <div class="pt-[88px] min-h-screen flex flex-col lg:flex-row">
        
        {{-- BAGIAN GAMBAR --}}
        <div class="w-full lg:w-1/2 bg-[#F6F5F3] h-[50vh] lg:h-[calc(100vh-88px)] flex items-center justify-center p-12">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                     class="max-h-full max-w-full object-contain mix-blend-multiply drop-shadow-2xl hover:scale-105 transition duration-700">
            @else
                <div class="text-gray-400 uppercase tracking-widest text-center">
                    <p class="text-2xl mb-2">No Image</p>
                </div>
            @endif
        </div>

        {{-- BAGIAN INFO PRODUK --}}
        <div class="w-full lg:w-1/2 px-6 lg:px-24 py-12 lg:py-20 flex flex-col justify-center overflow-y-auto">
            
            <div class="mb-4 text-xs uppercase tracking-[0.2em] text-gray-500">
                {{ $product->gender }} • {{ $product->category->name ?? 'Fragrance' }}
            </div>

            <h1 class="text-4xl lg:text-5xl font-medium tracking-wide mb-2 uppercase">{{ $product->name }}</h1>
            <p class="text-sm text-gray-500 mb-8">{{ $product->brand }}</p>

            <div class="text-2xl font-normal mb-8" id="price-display">
                @if($product->variants->count() > 0)
                    IDR {{ number_format($product->variants->first()->price, 0, ',', '.') }}
                @else
                    IDR 0
                @endif
            </div>

            {{-- INPUT HIDDEN UNTUK MENYIMPAN ID VARIAN YANG DIPILIH --}}
            <input type="hidden" id="selected-variant-id" value="{{ $product->variants->first()->id ?? '' }}">

            @if($product->variants->count() > 0)
                <div class="mb-10">
                    <label class="block text-xs uppercase tracking-widest text-gray-500 mb-4">Select Size</label>
                    <div class="flex flex-wrap gap-3">
                        @foreach($product->variants as $index => $variant)
                            <button onclick="updateVariant(this, '{{ $variant->price }}', '{{ $variant->id }}')"
                                    class="variant-btn border border-gray-300 px-6 py-3 text-sm uppercase tracking-widest hover:border-black transition {{ $index == 0 ? 'active-size' : '' }}">
                                {{ $variant->size }}
                            </button>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="mb-10 p-4 bg-yellow-50 text-yellow-800 text-sm rounded">
                    ⚠️ Produk ini belum memiliki varian ukuran.
                </div>
            @endif


            
            <div class="mb-10 text-gray-600 leading-relaxed text-sm text-justify">
                {!! nl2br(e($product->description)) !!}
            </div>

            @if($product->notes->count() > 0)
                <div class="mb-12 border-t border-gray-100 pt-8">
                    <h3 class="text-xs uppercase tracking-[0.2em] text-gray-900 mb-4 font-medium">Olfactory Notes</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($product->notes as $note)
                            <span class="bg-gray-100 text-gray-600 text-xs px-3 py-1 uppercase tracking-wider rounded-sm">
                                {{ $note->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="mt-4">
    <p class="text-[10px] uppercase tracking-widest text-gray-500 mb-2">Availability</p>
    <p id="variant-stock" class="text-sm font-medium text-gray-900">
        {{-- Default: Tampilkan stok varian pertama --}}
        @if($product->variants->first()->stock <= 5)
            <span class="text-red-500">Only {{ $product->variants->first()->stock }} units left</span>
        @else
            Stock: {{ $product->variants->first()->stock }}
        @endif
    </p>
</div>
            <div class="flex gap-4">
                <button onclick="addToCart()" 
                        class="flex-1 bg-gray-900 text-white py-4 text-sm uppercase tracking-[0.2em] hover:bg-gray-800 transition active:scale-95">
                    Add to Cart
                </button>
        {{-- TOMBOL WISHLIST --}}
<button onclick="toggleWishlist({{ $product->id }})" 
        class="w-14 border border-gray-300 flex items-center justify-center hover:border-black transition group">
    
    {{-- PASTIKAN ID INI SAMA PERSIS DENGAN DI JAVASCRIPT --}}
    <svg id="heart-icon-{{ $product->id }}" 
         xmlns="http://www.w3.org/2000/svg" 
         fill="{{ auth()->check() && auth()->user()->wishlists->contains($product->id) ? '#ef4444' : 'none' }}" 
         viewBox="0 0 24 24" 
         stroke-width="1.5" 
         stroke="currentColor" 
         class="w-6 h-6 {{ auth()->check() && auth()->user()->wishlists->contains($product->id) ? 'text-red-500' : 'text-gray-400' }} transition-all duration-300">
        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
    </svg>
</button>
            </div>

        </div>
    </div>

@endsection

@push('scripts')
<script>
    // --- SCRIPT KHUSUS HALAMAN DETAIL (Update Varian & Add To Cart) ---
    
    function updateVariant(btn, price, variantId) {
        let formattedPrice = new Intl.NumberFormat('id-ID').format(price);
        document.getElementById('price-display').innerText = 'IDR ' + formattedPrice;
        document.getElementById('selected-variant-id').value = variantId;
        document.querySelectorAll('.variant-btn').forEach(b => b.classList.remove('active-size'));
        btn.classList.add('active-size');
    }

    function addToCart() {
        const variantId = document.getElementById('selected-variant-id').value;
        const productId = "{{ $product->id }}";

        if (!variantId) {
            alert("Silakan pilih ukuran terlebih dahulu!");
            return;
        }

        fetch("{{ route('cart.add') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ product_id: productId, variant_id: variantId })
        })
        .then(res => {
            if(res.status === 401) {
                alert("Please login first.");
                window.location.href = "{{ route('login') }}";
                return;
            }
            return res.json();
        })
        .then(data => {
            if(data && data.message) openCart(); // Memanggil fungsi global openCart
        });
    }

    function updateVariant(btn, price, variantId, stock) {
        let formattedPrice = new Intl.NumberFormat('id-ID').format(price);
        document.getElementById('price-display').innerText = 'IDR ' + formattedPrice;
        document.getElementById('selected-variant-id').value = variantId;
        
        // Update Tampilan Stok
        const stockDisplay = document.getElementById('variant-stock');
        if (stock <= 5) {
            stockDisplay.innerHTML = `<span class="text-red-500">Only ${stock} units left</span>`;
        } else {
            stockDisplay.innerText = `Stock: ${stock}`;
        }

        document.querySelectorAll('.variant-btn').forEach(b => b.classList.remove('active-size'));
        btn.classList.add('active-size');
    }

    // --- Fungsi Toggle Wishlist ---
   function toggleWishlist(productId) {
    fetch("{{ route('wishlist.toggle') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ product_id: productId })
    })
    .then(res => {
        if (res.status === 401) {
            // Jika user belum login, arahkan ke halaman login
            window.location.href = "{{ route('login') }}";
            return;
        }
        return res.json();
    })
    .then(data => {
        console.log("Data dari server:", data); // Cek ini di Console

        // MENCARI ELEMEN HATI BERDASARKAN ID YANG UNIK
        const icon = document.getElementById(`heart-icon-${productId}`);

        // Pastikan elemen ditemukan sebelum mencoba mengubahnya
        if (icon) {
            if (data.status === 'added') {
                // EFEK INSTAN: Ubah warna jadi merah
                icon.setAttribute('fill', '#ef4444');
                icon.classList.remove('text-gray-400');
                icon.classList.add('text-red-500');
            } else {
                // EFEK INSTAN: Kosongkan warna
                icon.setAttribute('fill', 'none');
                icon.classList.remove('text-red-500');
                icon.classList.add('text-gray-400');
            }
        } else {
            console.error(`Gawat! Elemen dengan ID heart-icon-${productId} tidak ditemukan.`);
        }
    })
    .catch(err => console.error("Error Fetch:", err));
}


    
</script>

