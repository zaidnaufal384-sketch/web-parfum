<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - LOUIS PARFUM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style> body { font-family: 'Jost', sans-serif; } </style>
</head>
<body class="bg-white text-gray-900">

    {{-- Header Simpel --}}
    <div class="border-b border-gray-100 py-6 text-center">
        <a href="/" class="text-2xl tracking-[0.25em] uppercase font-medium">LOUIS PARFUM</a>
    </div>

    <div class="max-w-6xl mx-auto px-6 py-12">
        <h1 class="text-2xl uppercase tracking-widest mb-10 font-medium">Checkout</h1>

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            
            <div class="flex flex-col md:flex-row gap-12">
                
                {{-- KOLOM KIRI: FORMULIR --}}
                <div class="w-full md:w-3/5">
                    <h2 class="text-sm uppercase tracking-widest mb-6 border-b pb-2">Shipping Details</h2>
                    
                    <div class="mb-6">
                        <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Full Name</label>
                        <input type="text" name="name" class="w-full border-gray-300 p-3 rounded-none focus:ring-black focus:border-black" required placeholder="John Doe">
                    </div>

                    <div class="mb-6">
                        <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">WhatsApp Number</label>
                        <input type="text" name="phone" class="w-full border-gray-300 p-3 rounded-none focus:ring-black focus:border-black" required placeholder="08123456789">
                    </div>

                    <div class="mb-6">
                        <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Full Address</label>
                        <textarea name="address" rows="4" class="w-full border-gray-300 p-3 rounded-none focus:ring-black focus:border-black" required placeholder="Street name, City, Postal Code"></textarea>
                    </div>

                    <div class="mt-8 p-4 bg-gray-50 border border-gray-200">
                        <h3 class="text-xs uppercase tracking-widest font-bold mb-2">Payment Method</h3>
                        <p class="text-sm text-gray-600">Bank Transfer (BCA)</p>
                        <p class="text-xs text-gray-400 mt-1">Details will be shown after placing order.</p>
                    </div>
                </div>

                {{-- KOLOM KANAN: RINGKASAN --}}
                <div class="w-full md:w-2/5 bg-gray-50 p-8 h-fit">
                    <h2 class="text-sm uppercase tracking-widest mb-6 border-b border-gray-200 pb-2">Order Summary</h2>

                    <div class="space-y-4 mb-6">
                        @foreach($cartItems as $item)
                        <div class="flex justify-between items-start text-sm">
                            <div>
                                <p class="font-medium">{{ $item->product->name }}</p>
                                <p class="text-xs text-gray-500">{{ $item->variant->size }} x {{ $item->quantity }}</p>
                            </div>
                            <p>IDR {{ number_format($item->variant->price * $item->quantity, 0, ',', '.') }}</p>
                        </div>
                        @endforeach
                    </div>

                    <div class="border-t border-gray-200 pt-4 flex justify-between items-center text-lg font-medium mb-8">
                        <span>Total</span>
                        <span>IDR {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <button type="submit" class="w-full bg-black text-white py-4 text-xs uppercase tracking-[0.2em] hover:opacity-80 transition">
                        Place Order
                    </button>
                    
                    <a href="{{ route('front.catalog') }}" class="block text-center mt-4 text-xs uppercase tracking-widest text-gray-500 hover:text-black">
                        Continue Shopping
                    </a>
                </div>

            </div>
        </form>
    </div>

</body>
</html>