@extends('layouts.front')

@section('title', 'DJIBRAN PARFUM - Luxury Fragrances')

@section('content')

    {{-- ================= HERO SECTION ================= --}}
    <div class="relative h-[95vh] bg-gray-900 overflow-hidden">
        {{-- Pastikan path image ini sesuai dengan folder public Anda --}}
        <img src="{{ asset('images/backround.png') }}" class="absolute inset-0 w-full h-full object-cover opacity-80" alt="Hero Image">
        <div class="absolute bottom-20 inset-x-0 text-center text-white z-10 px-6">
            <h2 class="text-sm uppercase tracking-[0.3em] mb-6 font-medium">New Collection</h2>
            <h1 class="text-5xl md:text-7xl uppercase tracking-widest mb-10 font-medium">L'Immensité</h1>
            <div>
                <a href="#katalog-men" class="btn-lv-sharp btn-lv-white px-8 py-3 border border-white uppercase text-xs tracking-widest hover:bg-white hover:text-black transition duration-300">Discover the Campaign</a>
            </div>
        </div>
    </div>

    {{-- ================= NOTES SECTION (Dikembalikan Lengkap) ================= --}}
    <div class="py-24 bg-white">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-2xl font-normal tracking-wide text-gray-900">Explore by Olfactory Notes</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-10">
                <div class="group cursor-pointer text-center">
                    <div class="overflow-hidden mb-4 relative">
                        <img src="{{ asset('images/floral.jpg') }}" class="w-full h-[280px] object-cover hover:scale-105 transition duration-700 ease-in-out">
                    </div>
                    <h3  class="text-xs uppercase tracking-widest font-medium text-gray-900 group-hover:underline underline-offset-4">Floral</h3>
                    <p class="text-[10px] text-gray-500 mt-1">Rose, Jasmine, Lily</p>
                </div>
                <div class="group cursor-pointer text-center">
                    <div class="overflow-hidden mb-4 relative">
                        <img src="https://images.unsplash.com/photo-1542273917363-3b1817f69a2d?q=80&w=800&auto=format&fit=crop" class="w-full h-[280px] object-cover hover:scale-105 transition duration-700 ease-in-out">
                    </div>
                    <h3 class="text-xs uppercase tracking-widest font-medium text-gray-900 group-hover:underline underline-offset-4">Woody</h3>
                    <p class="text-[10px] text-gray-500 mt-1">Sandalwood, Cedar, Oud</p>
                </div>
                <div class="group cursor-pointer text-center">
                    <div class="overflow-hidden mb-4 relative">
                        <img src="https://images.unsplash.com/photo-1518837695005-2083093ee35b?q=80&w=800&auto=format&fit=crop" class="w-full h-[280px] object-cover hover:scale-105 transition duration-700 ease-in-out">
                    </div>
                    <h3 class="text-xs uppercase tracking-widest font-medium text-gray-900 group-hover:underline underline-offset-4">Fresh</h3>
                    <p class="text-[10px] text-gray-500 mt-1">Citrus, Aquatic, Green</p>
                </div>
                <div class="group cursor-pointer text-center">
                    <div class="overflow-hidden mb-4 relative">
                        <img src="https://images.unsplash.com/photo-1615634260167-c8cdede054de?q=80&w=800&auto=format&fit=crop" class="w-full h-[280px] object-cover hover:scale-105 transition duration-700 ease-in-out">
                    </div>
                    <h3 class="text-xs uppercase tracking-widest font-medium text-gray-900 group-hover:underline underline-offset-4">Oriental</h3>
                    <p class="text-[10px] text-gray-500 mt-1">Amber, Vanilla, Spice</p>
                </div>
                <div class="group cursor-pointer text-center">
                    <div class="overflow-hidden mb-4 relative">
                        <img src="https://images.unsplash.com/photo-1619546813926-a78fa6372cd2?q=80&w=800&auto=format&fit=crop" class="w-full h-[280px] object-cover hover:scale-105 transition duration-700 ease-in-out">
                    </div>
                    <h3 class="text-xs uppercase tracking-widest font-medium text-gray-900 group-hover:underline underline-offset-4">Fruity</h3>
                    <p class="text-[10px] text-gray-500 mt-1">Pear, Berries, Fig</p>
                </div>
                <div class="group cursor-pointer text-center">
                    <div class="overflow-hidden mb-4 relative">
                        <img src="https://images.unsplash.com/photo-1596040033229-a9821ebd058d?q=80&w=800&auto=format&fit=crop" class="w-full h-[280px] object-cover hover:scale-105 transition duration-700 ease-in-out">
                    </div>
                    <h3 class="text-xs uppercase tracking-widest font-medium text-gray-900 group-hover:underline underline-offset-4">Spicy</h3>
                    <p class="text-[10px] text-gray-500 mt-1">Pepper, Cinnamon, Cardamom</p>
                </div>
                <div class="group cursor-pointer text-center">
                    <div class="overflow-hidden mb-4 relative">
                        <img src="https://images.unsplash.com/photo-1579372786545-d24232daf58c?q=80&w=800&auto=format&fit=crop" class="w-full h-[280px] object-cover hover:scale-105 transition duration-700 ease-in-out">
                    </div>
                    <h3 class="text-xs uppercase tracking-widest font-medium text-gray-900 group-hover:underline underline-offset-4">Gourmand</h3>
                    <p class="text-[10px] text-gray-500 mt-1">Vanilla, Caramel, Honey</p>
                </div>
                <div class="group cursor-pointer text-center">
                    <div class="overflow-hidden mb-4 relative">
                        <img src="https://images.unsplash.com/photo-1606041008023-472dfb5e530f?q=80&w=800&auto=format&fit=crop" class="w-full h-[280px] object-cover hover:scale-105 transition duration-700 ease-in-out">
                    </div>
                    <h3 class="text-xs uppercase tracking-widest font-medium text-gray-900 group-hover:underline underline-offset-4">Aromatic</h3>
                    <p class="text-[10px] text-gray-500 mt-1">Lavender, Sage, Mint</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= MEN SECTION ================= --}}
    {{-- Banner Men --}}
    <div class="flex flex-col md:flex-row h-auto md:h-[700px]">
        <div class="w-full md:w-1/2 bg-[#F6F5F3] flex items-center justify-center p-12 order-2 md:order-1">
            <div class="text-center max-w-md">
                <h2 class="text-3xl uppercase tracking-widest mb-6 font-medium">Men's Fragrances</h2>
                <p class="text-gray-600 mb-10 leading-relaxed">
                    Bold and charismatic scents designed for the modern man. Experience the depth of oud and the freshness of citrus.
                </p>
                <a href="{{ route('front.catalog', ['gender' => 'Men']) }}" class="px-8 py-3 border border-black uppercase text-xs tracking-widest hover:bg-black hover:text-white transition duration-300">Explore Men's</a>
            </div>
        </div>
        <div class="w-full md:w-1/2 h-[500px] md:h-auto order-1 md:order-2">
            <img src="https://images.unsplash.com/photo-1523293182086-7651a899d37f?q=80&w=1920&auto=format&fit=crop" class="w-full h-full object-cover">
        </div>
    </div>

    {{-- Katalog Grid Men --}}
    <div id="katalog-men" class="py-24 bg-white">
        <div class="text-center mb-16">
            <h2 class="text-[10px] uppercase tracking-[0.2em] mb-2 font-medium text-gray-500">Men</h2>
            <h2 class="text-3xl font-normal tracking-wide text-gray-900">Spring-Summer Collection</h2>
        </div>
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
             @forelse($men_products as $product)
                <div class="group cursor-pointer text-center">
                    <div class="relative aspect-[3/4] bg-[#F5F5F5] mb-6 overflow-hidden flex items-center justify-center p-8">
                        <a href="{{ route('front.details', $product->slug) }}" class="block w-full h-full">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain mix-blend-multiply transition duration-500 group-hover:scale-105">
                            @else
                                <div class="flex items-center justify-center h-full text-gray-300 uppercase tracking-widest text-xs">No Image</div>
                            @endif
                        </a>
                    </div>
                    <div class="px-2">
                        <h3 class="text-sm text-gray-900 font-normal mb-1">
                            <a href="{{ route('front.details', $product->slug) }}">{{ $product->name }}</a>
                        </h3>
                        <p class="text-sm text-gray-500 font-light">
                            IDR {{ number_format($product->variants->first()->price ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
             @empty
                <div class="col-span-full text-center py-12"><p class="text-sm uppercase tracking-widest text-gray-400">Men's products coming soon.</p></div>
             @endforelse
        </div>
         <div class="text-center mt-16">
            <a href="{{ route('front.catalog', ['gender' => 'Men']) }}" class="btn-lv-pill">Discover Men</a>
        </div>
    </div>

    {{-- ================= WOMEN SECTION (Ditambahkan Kembali) ================= --}}
    {{-- Banner Women (Posisi Gambar dan Teks Dibalik untuk Variasi) --}}
    <div class="flex flex-col md:flex-row h-auto md:h-[700px]">
        {{-- Gambar di Kiri --}}
        <div class="w-full md:w-1/2 h-[500px] md:h-auto order-1">
            <img src="{{ asset('images/womenparume.jpg') }}" class="w-full h-full object-cover">
        </div>
        {{-- Teks di Kanan --}}
        <div class="w-full md:w-1/2 bg-[#F6F5F3] flex items-center justify-center p-12 order-2">
            <div class="text-center max-w-md">
                <h2 class="text-3xl uppercase tracking-widest mb-6 font-medium">Women's Fragrances</h2>
                <p class="text-gray-600 mb-10 leading-relaxed">
                    Elegant and timeless scents. From floral bouquets to sensual oriental notes, find your signature essence.
                </p>
                {{-- Pastikan route ini ada di web.php --}}
                <a href="{{ route('front.catalog', ['gender' => 'Women']) }}" class="px-8 py-3 border border-black uppercase text-xs tracking-widest hover:bg-black hover:text-white transition duration-300">Explore Women's</a>
            </div>
        </div>
    </div>

    {{-- Katalog Grid Women --}}
    <div id="katalog-women" class="py-24 bg-white">
        <div class="text-center mb-16">
            <h2 class="text-[10px] uppercase tracking-[0.2em] mb-2 font-medium text-gray-500">Women</h2>
            <h2 class="text-3xl font-normal tracking-wide text-gray-900">Elegant Selections</h2>
        </div>
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
             {{-- Asumsi Anda mengirim variable $women_products dari Controller --}}
             @forelse($women_products as $product)
                <div class="group cursor-pointer text-center">
                    <div class="relative aspect-[3/4] bg-[#F5F5F5] mb-6 overflow-hidden flex items-center justify-center p-8">
                        <a href="{{ route('front.details', $product->slug) }}" class="block w-full h-full">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain mix-blend-multiply transition duration-500 group-hover:scale-105">
                            @else
                                <div class="flex items-center justify-center h-full text-gray-300 uppercase tracking-widest text-xs">No Image</div>
                            @endif
                        </a>
                    </div>
                    <div class="px-2">
                        <h3 class="text-sm text-gray-900 font-normal mb-1">
                            <a href="{{ route('front.details', $product->slug) }}">{{ $product->name }}</a>
                        </h3>
                        <p class="text-sm text-gray-500 font-light">
                            IDR {{ number_format($product->variants->first()->price ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
             @empty
                <div class="col-span-full text-center py-12"><p class="text-sm uppercase tracking-widest text-gray-400">Women's products coming soon.</p></div>
             @endforelse
        </div>
         <div class="text-center mt-16">
            <a href="{{ route('front.catalog', ['gender' => 'Women']) }}" class="btn-lv-pill">Discover Women</a>
        </div>
    </div>

    {{-- ================= UNISEX SECTION (Ditambahkan Kembali) ================= --}}
    {{-- Banner Unisex --}}
    <div class="flex flex-col md:flex-row h-auto md:h-[700px]">
        <div class="w-full md:w-1/2 bg-[#F6F5F3] flex items-center justify-center p-12 order-2 md:order-1">
            <div class="text-center max-w-md">
                <h2 class="text-3xl uppercase tracking-widest mb-6 font-medium">Unisex Collection</h2>
                <p class="text-gray-600 mb-10 leading-relaxed">
                    Scents without boundaries. Shared passions and universal appeal for everyone.
                </p>
                <a href="{{ route('front.catalog', ['gender' => 'Unisex']) }}" class="px-8 py-3 border border-black uppercase text-xs tracking-widest hover:bg-black hover:text-white transition duration-300">Explore Unisex</a>
            </div>
        </div>
        <div class="w-full md:w-1/2 h-[500px] md:h-auto order-1 md:order-2">
            <img src="https://images.unsplash.com/photo-1541643600914-78b084683601?q=80&w=1920&auto=format&fit=crop" class="w-full h-full object-cover">
        </div>
    </div>

    {{-- Katalog Grid Unisex --}}
    <div id="katalog-unisex" class="py-24 bg-white">
        <div class="text-center mb-16">
            <h2 class="text-[10px] uppercase tracking-[0.2em] mb-2 font-medium text-gray-500">Unisex</h2>
            <h2 class="text-3xl font-normal tracking-wide text-gray-900">Universal Appeal</h2>
        </div>
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
             {{-- Asumsi Anda mengirim variable $unisex_products dari Controller --}}
             @forelse($unisex_products as $product)
                <div class="group cursor-pointer text-center">
                    <div class="relative aspect-[3/4] bg-[#F5F5F5] mb-6 overflow-hidden flex items-center justify-center p-8">
                        <a href="{{ route('front.details', $product->slug) }}" class="block w-full h-full">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain mix-blend-multiply transition duration-500 group-hover:scale-105">
                            @else
                                <div class="flex items-center justify-center h-full text-gray-300 uppercase tracking-widest text-xs">No Image</div>
                            @endif
                        </a>
                    </div>
                    <div class="px-2">
                        <h3 class="text-sm text-gray-900 font-normal mb-1">
                            <a href="{{ route('front.details', $product->slug) }}">{{ $product->name }}</a>
                        </h3>
                        <p class="text-sm text-gray-500 font-light">
                            IDR {{ number_format($product->variants->first()->price ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
             @empty
                <div class="col-span-full text-center py-12"><p class="text-sm uppercase tracking-widest text-gray-400">Unisex products coming soon.</p></div>
             @endforelse
        </div>
        <div class="text-center mt-16">
            <a href="{{ route('front.catalog', ['gender' => 'Unisex']) }}" class="btn-lv-pill">Discover Unisex</a>
        </div>
    </div>

@endsection

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
</script>
@endpush