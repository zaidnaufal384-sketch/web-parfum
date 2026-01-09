@extends('layouts.front')

@section('content')
<div class="py-32 bg-white min-h-screen">
    <div class="max-w-7xl mx-auto px-6">
        <h1 class="text-3xl font-light tracking-[0.3em] uppercase text-center mb-16">My Wishlist</h1>

        @if($wishlists->isEmpty())
            <div class="text-center py-20">
                <p class="text-gray-400 uppercase tracking-widest text-xs">Your wishlist is currently empty.</p>
                <a href="{{ url('/') }}" class="inline-block mt-8 border-b border-black pb-1 text-[10px] uppercase tracking-widest font-bold">Discover Fragrances</a>
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-4 gap-10">
                @foreach($wishlists as $product)

                    <div class="group">
                        <div class="relative overflow-hidden bg-gray-50 aspect-[3/4] mb-4">
                            <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover transition duration-700">
                        </div>
                        <h3 class="text-[11px] uppercase tracking-widest font-bold">{{ $product->brand }}</h3>
                        <p class="text-sm text-gray-500 font-light mt-1">{{ $product->name }}</p>
                        <a href="{{ route('product.show', $product->slug) }}" class="inline-block mt-4 text-[10px] uppercase tracking-widest border-b border-black pb-0.5">View Product</a>
                    </div>
                    <div class="mt-6">
    <button onclick="addToCart({{ $product->id }})" class="w-full bg-black text-white text-[10px] uppercase tracking-widest py-3 hover:bg-gray-800 transition">
        Add to Cart
    </button>
</div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection