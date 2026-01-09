<x-app-layout>
    <div class="container mx-auto px-6 py-20" style="margin-top: 80px;">
        <div class="max-w-2xl mx-auto bg-white border border-gray-100 p-10 shadow-sm">
            <h2 class="text-2xl font-light tracking-[0.3em] uppercase text-center mb-10">Payment Instructions</h2>
            
            {{-- Informasi Rekening --}}
            <div class="bg-gray-50 p-8 mb-10 text-center">
                <p class="text-[10px] uppercase tracking-widest text-gray-400 mb-2">Transfer To</p>
                <p class="text-lg font-medium tracking-widest text-gray-900">BANK BCA</p>
                <p class="text-2xl font-light tracking-[0.2em] my-2">123 4567 890</p>
                <p class="text-sm uppercase tracking-wider text-gray-600">A/N ZAID WILDAN</p>
            </div>

            <div class="flex justify-between mb-8 border-b border-gray-100 pb-4">
                <span class="text-xs uppercase tracking-widest text-gray-400">Total Amount</span>
                <span class="text-sm font-bold tracking-widest text-gray-900">IDR {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>

            {{-- Form Upload --}}
            <form action="{{ route('orders.payment.upload', $order->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-8">
                    <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-4 text-center">Upload Transfer Proof (JPG/PNG)</label>
                    <input type="file" name="payment_proof" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:border file:border-black file:bg-white file:text-black hover:file:bg-black hover:file:text-white transition-all duration-300" required>
                </div>

                <button type="submit" class="w-full bg-black text-white py-4 text-[11px] uppercase tracking-[0.3em] font-medium hover:bg-gray-800 transition shadow-lg">
                    Submit Payment
                </button>
            </form>

            <a href="{{ route('orders.show', $order->id) }}" class="block text-center mt-6 text-[10px] uppercase tracking-widest text-gray-400 hover:text-black transition">
                Cancel
            </a>
        </div>
    </div>
</x-app-layout>