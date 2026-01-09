<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Pesanan') }} #{{ $order->invoice_number }}
            </h2>
            {{-- Tambahan: Tombol Kembali --}}
            <a href="{{ route('admin.orders.index') }}" class="text-sm bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600 transition">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                <strong class="font-bold">Berhasil!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Menampilkan Tanggal Pesanan --}}
        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
            <p class="text-sm text-blue-700">
                Pesanan dibuat pada: <strong>{{ $order->created_at->format('d M Y, H:i') }}</strong>
            </p>
        </div>
    </div>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col md:flex-row gap-6">
            
            {{-- KOLOM KIRI: RINCIAN BARANG --}}
            <div class="w-full md:w-2/3">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Item Dibeli</h3>
                    
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                        <div class="flex items-center gap-4 border-b border-gray-100 pb-4 last:border-0">
                            <div class="w-16 h-16 bg-gray-100 rounded overflow-hidden">
                                @if($item->product && $item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="flex items-center justify-center h-full text-xs text-gray-400">No IMG</div>
                                @endif
                            </div>
                            
                            <div class="flex-1">
                                <h4 class="text-sm font-medium text-gray-900">{{ $item->product->name ?? 'Produk Dihapus' }}</h4>
                                <p class="text-xs text-gray-500">Ukuran: {{ $item->variant->size ?? '-' }}</p>
                            </div>

                            <div class="text-right">
                                <p class="text-sm font-medium">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-500">x {{ $item->quantity }}</p>
                            </div>

                            <div class="text-right font-bold text-sm w-24">
                                Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-6 flex justify-end border-t pt-4">
                        <div class="text-right">
                            <span class="text-sm text-gray-500">Total Transaksi:</span>
                            <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: INFO PENGIRIMAN --}}
            <div class="w-full md:w-1/3">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                    <h3 class="text-sm font-bold uppercase tracking-widest text-gray-500 mb-4">Info Pengiriman</h3>
                    
                    <div class="mb-4">
                        <label class="text-xs text-gray-400 italic">Penerima</label>
                        <p class="font-medium text-gray-900">{{ $order->name }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <label class="text-xs text-gray-400 italic">WhatsApp</label>
                        <p class="font-medium text-gray-900 flex items-center gap-2">
                            {{ $order->phone }}
                            {{-- Perbaikan Link WA: Mengubah 0 jadi 62 --}}
                            @php
                                $waPhone = preg_replace('/^0/', '62', $order->phone);
                            @endphp
                            <a href="https://wa.me/{{ $waPhone }}" target="_blank" class="bg-green-500 text-white px-2 py-1 rounded text-[10px] uppercase font-bold hover:bg-green-600">
                                Chat WA
                            </a>
                        </p>
                    </div>

                    <div class="mb-2">
                        <label class="text-xs text-gray-400 italic">Alamat</label>
                        <p class="text-sm text-gray-700 leading-relaxed bg-gray-50 p-3 rounded mt-1 border">
                            {{ $order->address }}
                        </p>
                    </div>
                </div>


                {{-- BUKTI PEMBAYARAN --}}
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
    <h3 class="text-sm font-bold uppercase tracking-widest text-gray-500 mb-4">Bukti Pembayaran</h3>
    
    @if($order->payment_proof)
        <div class="relative group">
            {{-- Menampilkan Gambar Bukti --}}
            <img src="{{ asset('storage/' . $order->payment_proof) }}" 
                 alt="Bukti Pembayaran" 
                 class="w-full h-auto rounded border shadow-md hover:shadow-lg transition-shadow duration-300">
            
            {{-- Overlay untuk klik perbesar --}}
            <div class="mt-3">
                <a href="{{ asset('storage/' . $order->payment_proof) }}" 
                   target="_blank" 
                   class="block text-center text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 rounded font-semibold transition">
                    🔍 Buka Gambar Full Screen
                </a>
            </div>
        </div>
    @else
        {{-- Kondisi Jika Belum Upload --}}
        <div class="flex flex-col items-center justify-center py-6 bg-gray-50 border-2 border-dashed border-gray-200 rounded-lg">
            <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <p class="text-xs text-gray-500 italic">Belum ada bukti pembayaran</p>
        </div>
    @endif
</div>

                {{-- Update Status --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-sm font-bold uppercase tracking-widest text-gray-500 mb-4">Update Status</h3>
                    
                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-4">
                            <select name="status" class="w-full border-gray-300 rounded-md shadow-sm focus:border-black focus:ring-black">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
                                <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Paid (Sudah Bayar)</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped (Dikirim)</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed (Selesai)</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled (Batal)</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition font-bold shadow-md">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>