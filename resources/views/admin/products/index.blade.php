<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="mb-6 flex justify-between items-center">
                        <h3 class="text-lg font-bold">Daftar Produk Parfum</h3>
                        <a href="{{ route('admin.products.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            + Tambah Produk
                        </a>
                    </div>

                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">No</th>
                                    <th scope="col" class="px-6 py-3">Foto</th>
                                    <th scope="col" class="px-6 py-3">Nama Produk</th>
                                    <th scope="col" class="px-6 py-3">Brand</th>
                                    <th scope="col" class="px-6 py-3">Kategori</th>
                                    <th scope="col" class="px-6 py-3">Gender</th>
                                    <th class="px-4 py-3 text-center">STOK</th>
                                    <th scope="col" class="px-6 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product)
                                    <tr class="bg-white border-b">
                                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4">
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" class="w-16 h-16 object-cover rounded" alt="Foto">
                                            @else
                                                <span class="text-gray-400">No Image</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 font-medium text-gray-900">{{ $product->name }}</td>
                                        <td class="px-6 py-4">{{ $product->brand }}</td>
                                        {{-- Menampilkan Nama Kategori dari Relasi --}}
                                        <td class="px-6 py-4">
                                            <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded border border-gray-500">
                                                {{ $product->category->name ?? 'Tanpa Kategori' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">{{ $product->gender }}</td>
                                        <td class="px-4 py-3 text-center">
    @php $totalStok = $product->variants->sum('stock'); @endphp
    
    @if($totalStok <= 0)
        <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-[10px] font-bold uppercase">Habis</span>
    @elseif($totalStok <= 5)
        <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-[10px] font-bold uppercase">Sisa {{ $totalStok }}</span>
    @else
        <span class="text-sm font-medium text-gray-900">{{ $totalStok }} Unit</span>
    @endif
</td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('admin.products.edit', $product->id) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">Edit</a>
                                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus produk ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        </td>
                                        
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                            Belum ada data produk.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>