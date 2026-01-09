<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Shopping Bag') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if($cartItems->count() > 0)
                    <div class="flex flex-col md:flex-row gap-8">
                        
                        {{-- DAFTAR ITEM --}}
                        <div class="w-full md:w-2/3">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-gray-200 text-xs uppercase tracking-widest text-gray-500">
                                        <th class="py-4">Product</th>
                                        <th class="py-4 text-center">Qty</th>
                                        <th class="py-4 text-right">Total</th>
                                        <th class="py-4"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cartItems as $item)
                                    <tr class="border-b border-gray-100 last:border-0">
                                        <td class="py-6 flex gap-4 items-center">
                                            {{-- Gambar Produk --}}
                                            <div class="w-20 h-24 bg-gray-50 flex-shrink-0 flex items-center justify-center">
                                                @if($item->product->image)
                                                    <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-contain mix-blend-multiply">
                                                @else
                                                    <span class="text-[10px] text-gray-400">NO IMG</span>
                                                @endif
                                            </div>
                                            <div>
                                                <h3 class="text-sm font-medium text-gray-900 uppercase tracking-wide">
                                                    {{ $item->product->name }}
                                                </h3>
                                                <p class="text-xs text-gray-500 mt-1">
                                                    Size: {{ $item->variant->size ?? '-' }}
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                    IDR {{ number_format($item->variant->price, 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </td>
                                        <td class="py-6 text-center">
                                            <span class="text-sm font-medium">{{ $item->quantity }}</span>
                                        </td>
                                        <td class="py-6 text-right">
                                            <p class="text-sm font-bold">
                                                IDR {{ number_format($item->variant->price * $item->quantity, 0, ',', '.') }}
                                            </p>
                                        </td>
                                        <td class="py-6 text-right">
                                            {{-- Tombol Hapus --}}
                                            {{-- Pastikan route 'cart.destroy' ada di web.php --}}
                                            <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-600 transition">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                      <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- TOTAL & CHECKOUT --}}
                        <div class="w-full md:w-1/3">
                            <div class="bg-gray-50 p-6 rounded-lg sticky top-24">
                                <h3 class="text-xs uppercase tracking-widest font-bold text-gray-900 mb-6">Order Summary</h3>
                                
                                <div class="flex justify-between mb-4 text-sm">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="font-medium">IDR {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                                
                                <div class="border-t border-gray-200 pt-4 flex justify-between mb-8">
                                    <span class="font-bold text-base">Total</span>
                                    <span class="font-bold text-xl">IDR {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>

                                <a href="{{ route('checkout') }}" class="block w-full bg-black text-white text-center py-3 text-xs uppercase tracking-widest font-medium hover:bg-gray-800 transition">
                                    Proceed to Checkout
                                </a>
                                
                                <div class="mt-6 text-center">
                                    <a href="/" class="text-xs text-gray-500 hover:text-black underline transition">Continue Shopping</a>
                                </div>
                            </div>
                        </div>

                    </div>
                @else
                    {{-- JIKA KOSONG --}}
                    <div class="text-center py-20">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mx-auto text-gray-300 mb-6">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 5.408c.63 2.712-.42 5.09-2.58 6.002-1.91.808-4.402.08-5.323-2.072M8.25 19.5a3.75 3.75 0 1 1-7.5 0M15.75 10.5H5.25" />
                        </svg>
                        <h2 class="text-xl font-medium text-gray-900 mb-2">Tas Belanja Kosong</h2>
                        <a href="/" class="inline-block border border-black px-8 py-3 text-xs uppercase tracking-widest font-medium hover:bg-black hover:text-white transition mt-4">
                            Mulai Belanja
                        </a>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>