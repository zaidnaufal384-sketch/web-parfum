<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Pesanan Masuk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <h3 class="text-lg font-medium text-gray-900 mb-4">History Transaksi</h3>

                <div class="overflow-x-auto">


                <div class="bg-white p-6 rounded-lg shadow-sm mb-6 no-print">
    <form action="{{ route('admin.orders.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
        {{-- Filter Status --}}
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Status</label>
            <select name="status" class="rounded-md border-gray-300 text-sm focus:border-black focus:ring-black">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>

        {{-- Filter Tanggal --}}
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Dari Tanggal</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}" class="rounded-md border-gray-300 text-sm focus:border-black focus:ring-black">
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Sampai Tanggal</label>
            <input type="date" name="end_date" value="{{ request('end_date') }}" class="rounded-md border-gray-300 text-sm focus:border-black focus:ring-black">
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex gap-2">
            <button type="submit" class="bg-black text-white px-4 py-2 rounded-md text-sm hover:bg-gray-800 transition">
                Filter
            </button>
            <a href="{{ route('admin.orders.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md text-sm hover:bg-gray-300 transition">
                Reset
            </a>
            {{-- Tombol Print --}}
            <button type="button" onclick="window.print()" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak Laporan
            </button>
        </div>
    </form>
</div>
                    <table class="w-full border-collapse border border-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="border p-3 text-left text-xs font-medium text-gray-500 uppercase">No. Invoice</th>
                                <th class="border p-3 text-left text-xs font-medium text-gray-500 uppercase">Pemesan</th>
                                <th class="border p-3 text-left text-xs font-medium text-gray-500 uppercase">Total Bayar</th>
                                <th class="border p-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="border p-3 text-center text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="border p-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($orders as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 text-sm font-bold text-gray-900">
                                    {{ $order->invoice_number }}
                                </td>
                                <td class="p-3 text-sm text-gray-700">
                                    <div class="font-medium">{{ $order->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $order->phone }}</div>
                                </td>
                                <td class="p-3 text-sm font-medium text-gray-900">
                                    IDR {{ number_format($order->total_price, 0, ',', '.') }}
                                </td>
                                <td class="p-3 text-sm">
                                    @php
                                        $statusClass = match($order->status) {
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'paid' => 'bg-blue-100 text-blue-800',
                                            'shipped' => 'bg-purple-100 text-purple-800',
                                            'completed' => 'bg-green-100 text-green-800',
                                            'cancelled' => 'bg-red-100 text-red-800',
                                            default => 'bg-gray-100 text-gray-800'
                                        };
                                    @endphp
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="p-3 text-center text-xs text-gray-500">
                                    {{ $order->created_at->format('d M Y H:i') }}
                                </td>
                                <td class="p-3 text-center">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" 
                                       class="bg-black text-white px-3 py-1.5 rounded text-xs uppercase tracking-widest hover:bg-gray-800">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-gray-400">
                                    Belum ada pesanan masuk.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $orders->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

<style>
@media print {
    /* Sembunyikan navigasi, sidebar, dan form filter saat print */
    .no-print, 
    nav, 
    header, 
    footer, 
    button, 
    .aksi-column {
        display: none !important;
    }

    /* Lebarkan tabel agar memenuhi kertas */
    .max-w-7xl {
        max-width: 100% !important;
        width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    body {
        background-color: white !important;
    }

    table {
        border: 1px solid #e5e7eb !important;
    }
}
</style>