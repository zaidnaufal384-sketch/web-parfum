@extends('layouts.front')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Collections - LOUIS PARFUM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style> 
        body { font-family: 'Jost', sans-serif; } 
        .scrollbar-hide::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="bg-white text-gray-900">

    {{-- 1. NAVBAR (Clean Style) --}}
   

    {{-- 2. DYNAMIC HERO BANNER --}}
    {{-- Logika: Cek URL gender, pilih gambar yang sesuai --}}
    @php
        $gender = request('gender');
        $note = request('note');
        
        // Default Banner (Unisex/General)
        $bannerImage = asset('images/banners/banner-unisex.jpg');
        $title = "All Collections";
        $subtitle = "Discover our timeless fragrances.";

        if($gender == 'Men') {
            $bannerImage = asset('images/banners/banner-men.jpg');
            $title = "Men's Collection";
            $subtitle = "Bold, charismatic, and unforgettable scents.";
        } elseif($gender == 'Women') {
            $bannerImage = asset('images/banners/banner-women.jpg');
            $title = "Women's Collection";
            $subtitle = "Elegant, floral, and sophisticated essences.";
        } elseif($note) {
            // Jika filter berdasarkan Note
            $title = $note . " Selection";
            $subtitle = "Explore fragrances with " . strtolower($note) . " notes.";
        }
    @endphp

    <div class="relative"> 
    <div class="h-[50vh] md:h-[65vh] w-full relative overflow-hidden bg-gray-900">
        {{-- Gambar Banner --}}
        <img src="{{ $bannerImage }}" class="absolute inset-0 w-full h-full object-cover">
        
        {{-- Overlay Gelap: Dibuat sedikit lebih gelap agar teks putih lebih terbaca di bawah navbar --}}
        <div class="absolute inset-0 bg-black/40"></div>
        
        {{-- Teks Tengah: Ditambahkan pt-[88px] di dalam agar teks tidak tertutup navbar --}}
        <div class="absolute inset-0 flex flex-col items-center justify-center text-white text-center px-4 pt-[88px]">
            <h2 class="text-xs md:text-sm uppercase tracking-[0.4em] mb-4 font-light opacity-80">Louis Parfum</h2>
            <h1 class="text-4xl md:text-7xl uppercase tracking-[0.15em] font-medium mb-6">{{ $title }}</h1>
            <div class="w-20 h-[1px] bg-white/50 mb-6"></div> {{-- Garis dekoratif mewah --}}
            <p class="text-sm md:text-base font-light tracking-widest max-w-lg italic opacity-90">{{ $subtitle }}</p>
        </div>
    </div>
</div>

    {{-- 3. MAIN CONTENT (Sidebar + Grid) --}}
    <div class="max-w-[1800px] mx-auto px-6 py-16 flex flex-col md:flex-row gap-12">
        
        {{-- SIDEBAR FILTER (Sticky) --}}
        <div class="w-full md:w-1/5 shrink-0">
            <div class="sticky top-28 space-y-10">
                
                {{-- Filter Gender --}}
                <div>
                    <h3 class="font-medium text-xs uppercase tracking-[0.2em] mb-6 border-b border-gray-200 pb-2">Gender</h3>
                    <ul class="space-y-3 text-sm font-light text-gray-600">
                        <li>
                            <a href="{{ route('front.catalog') }}" 
                               class="hover:text-black transition flex items-center gap-2 {{ !request('gender') && !request('note') ? 'font-medium text-black' : '' }}">
                                <span class="w-2 h-2 rounded-full {{ !request('gender') && !request('note') ? 'bg-black' : 'bg-transparent border border-gray-300' }}"></span>
                                View All
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('front.catalog', ['gender' => 'Men']) }}" 
                               class="hover:text-black transition flex items-center gap-2 {{ request('gender') == 'Men' ? 'font-medium text-black' : '' }}">
                                <span class="w-2 h-2 rounded-full {{ request('gender') == 'Men' ? 'bg-black' : 'bg-transparent border border-gray-300' }}"></span>
                                Men
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('front.catalog', ['gender' => 'Women']) }}" 
                               class="hover:text-black transition flex items-center gap-2 {{ request('gender') == 'Women' ? 'font-medium text-black' : '' }}">
                                <span class="w-2 h-2 rounded-full {{ request('gender') == 'Women' ? 'bg-black' : 'bg-transparent border border-gray-300' }}"></span>
                                Women
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('front.catalog', ['gender' => 'Unisex']) }}" 
                               class="hover:text-black transition flex items-center gap-2 {{ request('gender') == 'Unisex' ? 'font-medium text-black' : '' }}">
                                <span class="w-2 h-2 rounded-full {{ request('gender') == 'Unisex' ? 'bg-black' : 'bg-transparent border border-gray-300' }}"></span>
                                Unisex
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Filter Notes --}}
                <div>
                    <h3 class="font-medium text-xs uppercase tracking-[0.2em] mb-6 border-b border-gray-200 pb-2">Olfactory Notes</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($notes as $noteItem)
                            <a href="{{ route('front.catalog', array_merge(request()->except('note'), ['note' => $noteItem->name])) }}" 
                               class="text-[10px] border px-3 py-1.5 uppercase tracking-wider transition duration-300
                               {{ request('note') == $noteItem->name ? 'bg-black text-white border-black' : 'text-gray-500 border-gray-200 hover:border-black hover:text-black' }}">
                                {{ $noteItem->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Tombol Clear --}}
                @if(request()->has('gender') || request()->has('note'))
                    <div class="pt-4">
                        <a href="{{ route('front.catalog') }}" class="text-xs uppercase tracking-widest text-red-500 hover:text-red-700 border-b border-red-200 pb-0.5">
                            ✕ Clear Filters
                        </a>
                    </div>
                @endif
            </div>
        </div>

        {{-- PRODUCT GRID --}}
        <div class="w-full md:w-4/5">
            {{-- Info Jumlah Produk --}}
            <div class="mb-8 flex justify-between items-end">
                <span class="text-xs text-gray-400 uppercase tracking-widest">{{ $products->count() }} Products Found</span>
                
              {{-- Sortir (Sudah Aktif) --}}
<form action="{{ url()->current() }}" method="GET" id="sortForm" class="flex items-center gap-2">
    {{-- Penting: Hidden input ini agar filter gender/note tidak hilang saat sortir diubah --}}
    @foreach(request()->except('sort') as $key => $value)
        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
    @endforeach

    <label class="text-[10px] uppercase tracking-widest text-gray-400">Sort by:</label>
    <select name="sort" onchange="this.form.submit()" 
            class="text-[10px] uppercase tracking-widest font-medium border-none bg-transparent focus:ring-0 cursor-pointer p-0 pr-6 text-gray-600 hover:text-black transition">
        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name: A-Z</option>
    </select>
</form>
            </div>

           {{-- PERUBAHAN: Menambah jumlah kolom agar card lebih kecil --}}
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-x-6 gap-y-10">
                @forelse($products as $product)
                    <div class="group cursor-pointer text-center">
                        <div class="relative aspect-[3/4] bg-[#F9F9F9] mb-4 overflow-hidden flex items-center justify-center p-8">
                            {{-- Image --}}
                            <a href="{{ route('front.details', $product->slug) }}" class="block w-full h-full">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-contain mix-blend-multiply transition duration-700 group-hover:scale-105">
                                @else
                                    <div class="flex items-center justify-center h-full text-gray-300 text-xs">NO IMAGE</div>
                                @endif
                            </a>

                            {{-- Quick Add (Muncul saat hover) --}}
                            <button class="absolute bottom-4 left-1/2 -translate-x-1/2 translate-y-10 group-hover:translate-y-0 opacity-0 group-hover:opacity-100 transition duration-500 bg-white shadow-lg text-black text-[10px] uppercase tracking-widest py-3 px-6 font-medium hover:bg-black hover:text-white whitespace-nowrap">
                                View Details
                            </button>
                        </div>

                        {{-- Text Info --}}
                        <div class="px-2">
                            <h3 class="text-sm text-gray-900 font-normal mb-1">
                                <a href="{{ route('front.details', $product->slug) }}">{{ $product->name }}</a>
                            </h3>
                            @if($product->variants->isNotEmpty())
                                <p class="text-sm text-gray-500 font-light">
                                    IDR {{ number_format($product->variants->first()->price, 0, ',', '.') }}
                                </p>
                            @else
                                <p class="text-sm text-gray-500 font-light">-</p>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-24 text-center">
                        <p class="text-gray-400 mb-4 text-4xl font-light">☹</p>
                        <p class="text-sm uppercase tracking-widest text-gray-500">No products match your filter.</p>
                        <a href="{{ route('front.catalog') }}" class="inline-block mt-6 text-xs uppercase border-b border-black pb-1">View All Products</a>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

</body>
</html>

@push('scripts')
<script>
    // Script khusus halaman Welcome (untuk efek navbar transparan ke putih)
    document.addEventListener('DOMContentLoaded', function() {
        const navbar = document.getElementById('main-navbar');
        // Pastikan element dengan ID 'main-navbar' ada di layout utama Anda
        if (navbar) {
            function updateNavbar() {
                if (window.scrollY > 50) {
                    navbar.classList.remove('bg-transparent', 'text-white', 'border-transparent');
                    navbar.classList.add('bg-white', 'text-gray-900', 'border-gray-200', 'shadow-sm');
                } else {
                    navbar.classList.remove('bg-white', 'text-gray-900', 'border-gray-200', 'shadow-sm');
                    navbar.classList.add('bg-transparent', 'text-white', 'border-transparent');
                }
            }
            window.addEventListener('scroll', updateNavbar);
            updateNavbar();
        }
    });


    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const navbar = document.getElementById('main-navbar');
        if (navbar) {
            function updateNavbar() {
                if (window.scrollY > 50) {
                    // Saat discroll ke bawah: Jadi Putih
                    navbar.classList.remove('bg-transparent', 'text-white', 'border-transparent');
                    navbar.classList.add('bg-white', 'text-gray-900', 'border-gray-100', 'shadow-sm');
                } else {
                    // Saat di posisi paling atas: Kembali Transparan
                    navbar.classList.add('bg-transparent', 'text-white', 'border-transparent');
                    navbar.classList.remove('bg-white', 'text-gray-900', 'border-gray-100', 'shadow-sm');
                }
            }
            window.addEventListener('scroll', updateNavbar);
            updateNavbar(); // Jalankan sekali saat halaman dimuat
        }
    });
</script>
</script>
@endpush