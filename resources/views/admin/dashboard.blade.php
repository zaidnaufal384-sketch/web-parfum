<x-app-layout>
    <style>
        .stat-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid #f3f4f6;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.05);
            border-color: #000;
        }
    </style>

    <div class="py-12 bg-[#fafafa] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-10 flex justify-between items-end">
                <div>
                    <h2 class="text-3xl font-light tracking-[0.2em] uppercase text-gray-900">Executive Dashboard</h2>
                    <p class="text-xs text-gray-400 uppercase tracking-widest mt-2">Welcome back, Administrator</p>
                </div>
                <div class="text-right">
                    <p class="text-[10px] text-gray-400 uppercase tracking-widest">{{ now()->format('d F Y') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <div class="stat-card bg-white p-8 rounded-none flex items-center justify-between">
                    <div>
                        <p class="text-[10px] uppercase tracking-[0.2em] text-gray-400 mb-1">Total Fragrances</p>
                        <h3 class="text-3xl font-bold text-gray-900">{{ $totalProducts }}</h3>
                    </div>
                    <div class="p-3 bg-gray-50 text-black">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke-width="1.5"/></svg>
                    </div>
                </div>

                <div class="stat-card bg-white p-8 rounded-none flex items-center justify-between">
                    <div>
                        <p class="text-[10px] uppercase tracking-[0.2em] text-gray-400 mb-1">Incoming Orders</p>
                        <h3 class="text-3xl font-bold text-gray-900">{{ $totalOrders }}</h3>
                    </div>
                    <div class="p-3 bg-gray-50 text-black">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" stroke-width="1.5"/></svg>
                    </div>
                </div>

                <div class="stat-card bg-white p-8 rounded-none flex items-center justify-between">
                    <div>
                        <p class="text-[10px] uppercase tracking-[0.2em] text-gray-400 mb-1">Registered Clients</p>
                        <h3 class="text-3xl font-bold text-gray-900">{{ $totalUsers }}</h3>
                    </div>
                    <div class="p-3 bg-gray-50 text-black">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" stroke-width="1.5"/></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-100 shadow-sm p-8">
                <div class="flex justify-between items-center mb-8">
                    <h4 class="text-sm font-bold uppercase tracking-[0.2em]">Latest Transactions</h4>
                    <a href="{{ route('admin.orders.index') }}" class="text-[10px] uppercase tracking-widest border-b border-black pb-1 hover:opacity-50 transition">View All Orders</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[10px] uppercase tracking-widest text-gray-400 border-b border-gray-50">
                                <th class="pb-4">Order ID</th>
                                <th class="pb-4">Client</th>
                                <th class="pb-4 text-center">Total</th>
                                <th class="pb-4 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($recentOrders as $order)
                            <tr class="text-xs">
                                <td class="py-6 font-medium">#{{ $order->id }}</td>
                                <td class="py-6">{{ $order->user->name }}</td>
                                <td class="py-6 text-center">IDR {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td class="py-6 text-right">
                                    <span class="px-3 py-1 bg-gray-50 text-[9px] font-bold uppercase tracking-tighter">
                                        {{ $order->status }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>