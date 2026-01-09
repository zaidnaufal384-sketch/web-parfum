<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pesanan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if($orders->isEmpty())
                        <div class="text-center py-10">
                            <p class="text-gray-500 mb-4">Belum ada pesanan.</p>
                            <a href="{{ url('/') }}" class="bg-black text-white px-4 py-2 rounded">Belanja Sekarang</a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3">No. Invoice</th>
                                        <th class="px-6 py-3">Tanggal</th>
                                        <th class="px-6 py-3">Total Harga</th>
                                        <th class="px-6 py-3">Status</th>
                                        <th class="px-6 py-3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4 font-bold text-gray-900">
                                            #{{ $order->invoice_number }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $order->created_at->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 font-bold">
                                            IDR {{ number_format($order->total_price, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{-- Label Status Warna-warni --}}
                                            @php
                                                $statusColor = match($order->status) {
                                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                                    'paid' => 'bg-blue-100 text-blue-800',
                                                    'shipped' => 'bg-purple-100 text-purple-800',
                                                    'completed' => 'bg-green-100 text-green-800',
                                                    'cancelled' => 'bg-red-100 text-red-800',
                                                    default => 'bg-gray-100 text-gray-800',
                                                };
                                            @endphp
                                            <span class="{{ $statusColor }} px-2 py-1 rounded-full text-xs font-semibold">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('orders.show', $order->id) }}" class="text-blue-600 hover:underline">
                                                Lihat Detail
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>