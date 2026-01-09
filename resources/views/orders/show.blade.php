<x-app-layout>
    <div class="container mx-auto px-6 py-12" style="margin-top: 100px;">
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row gap-12">
            
            {{-- KOLOM KIRI: ITEM DIBELI --}}
            <div class="w-full md:w-2/3">
                <div class="border-b border-gray-100 pb-4 mb-8 flex justify-between items-end">
                    <div>
                        <h2 class="text-2xl font-medium tracking-[0.2em] uppercase">Order Detail</h2>
                        <p class="text-[11px] text-gray-400 tracking-widest mt-1">INVOICE: #{{ $order->invoice_number }}</p>
                    </div>
                    <p class="text-[11px] text-gray-400 tracking-widest">{{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
                
                <div class="space-y-8">
                    @foreach($order->items as $item)
                    <div class="flex items-center gap-6 pb-6 border-b border-gray-50 last:border-0">
                        {{-- Foto Produk --}}
                        <div class="w-24 h-32 bg-gray-50 overflow-hidden flex-shrink-0">
                            @if($item->product && $item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                            @else
                                <div class="flex items-center justify-center h-full text-[10px] text-gray-400 uppercase tracking-widest">No Image</div>
                            @endif
                        </div>
                        
                        {{-- Info Produk --}}
                        <div class="flex-1">
                            <h4 class="text-sm font-medium text-gray-900 uppercase tracking-widest">{{ $item->product->name ?? 'Product Removed' }}</h4>
                            <p class="text-[11px] text-gray-500 uppercase tracking-tighter mt-1">Size: {{ $item->variant->size ?? '-' }}</p>
                            <p class="text-[11px] text-gray-400 mt-4">QTY: {{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>

                        {{-- Subtotal --}}
                        <div class="text-right font-medium text-sm">
                            Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Total --}}
                <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end text-right">
                    <div>
                        <span class="text-[10px] uppercase tracking-[0.2em] text-gray-400">Total Amount</span>
                        <p class="text-2xl font-light tracking-wider text-gray-900 mt-1">IDR {{ number_format($order->total_price, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: INFO STATUS & PENGIRIMAN --}}
            <div class="w-full md:w-1/3 space-y-8">
                
                {{-- Status Pesanan --}}
                <div class="bg-gray-50 p-8">
                    <h3 class="text-[11px] font-bold uppercase tracking-[0.3em] text-gray-400 mb-6">Order Status</h3>
                    
                    @php
                        $statusColor = match($order->status) {
                            'pending' => 'text-yellow-600',
                            'paid' => 'text-blue-600',
                            'shipped' => 'text-purple-600',
                            'completed' => 'text-green-600',
                            'cancelled' => 'text-red-600',
                            default => 'text-gray-800',
                        };
                    @endphp

                    <div class="text-center border-b border-gray-200 pb-6 mb-6">
                        <p class="text-xl font-medium uppercase tracking-[0.2em] {{ $statusColor }}">{{ $order->status }}</p>
                        @if($order->status == 'pending')
                            <p class="text-[10px] uppercase tracking-widest text-gray-500 mt-2">Waiting for Payment</p>

                            <a href="{{ route('orders.payment', $order->id) }}" class="block w-full bg-black text-white py-3 text-[11px] uppercase tracking-[0.3em] hover:bg-gray-800 transition duration-500 shadow-xl">
            Pay Now
        </a>
                        @endif
                    </div>

                    {{-- Info Pengiriman --}}
                    <div class="space-y-4">
                        <div>
                            <label class="text-[10px] uppercase tracking-widest text-gray-400">Recipient</label>
                            <p class="text-sm font-medium uppercase tracking-wider text-gray-900 mt-1">{{ $order->name }}</p>
                        </div>
                        <div>
                            <label class="text-[10px] uppercase tracking-widest text-gray-400">Contact</label>
                            <p class="text-sm text-gray-900 mt-1">{{ $order->phone }}</p>
                        </div>
                        <div>
                            <label class="text-[10px] uppercase tracking-widest text-gray-400">Address</label>
                            <p class="text-[12px] text-gray-600 leading-relaxed uppercase tracking-wide mt-1 italic">
                                {{ $order->address }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Tombol Kembali --}}
                <a href="{{ route('orders.history') }}" class="block w-full text-center border border-black py-3 text-[11px] uppercase tracking-[0.3em] hover:bg-black hover:text-white transition duration-500">
                    Back to History
                </a>
            </div>
        </div>
    </div>
</x-app-layout>