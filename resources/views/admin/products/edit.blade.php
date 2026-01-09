<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Produk') }}: {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- ERROR HANDLING --}}
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                            <strong class="font-bold">Periksa inputan Anda!</strong>
                            <ul class="mt-2 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') {{-- Wajib untuk Edit --}}

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            {{-- Nama Produk --}}
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Parfum</label>
                                <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-black" required>
                            </div>

                            {{-- Brand --}}
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Brand</label>
                                <input type="text" name="brand" value="{{ old('brand', $product->brand) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-black" required>
                            </div>

                            {{-- Kategori --}}
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                                <select name="category_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-black" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Gender --}}
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Target Gender</label>
                                <select name="gender" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-black">
                                    <option value="Men" {{ $product->gender == 'Men' ? 'selected' : '' }}>Men</option>
                                    <option value="Women" {{ $product->gender == 'Women' ? 'selected' : '' }}>Women</option>
                                    <option value="Unisex" {{ $product->gender == 'Unisex' ? 'selected' : '' }}>Unisex</option>
                                </select>
                            </div>

                            {{-- OLFACTORY NOTES (BAGIAN PENTING) --}}
                            <div class="mb-4 md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Olfactory Notes</label>
                                <div class="flex flex-wrap gap-4 p-4 bg-gray-50 rounded-md border border-gray-200">
                                    @foreach($notes as $note)
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            {{-- Cek apakah produk ini punya note tersebut --}}
                                            <input type="checkbox" name="notes[]" value="{{ $note->id }}" 
                                                   {{ $product->notes->contains('id', $note->id) ? 'checked' : '' }}
                                                   class="rounded border-gray-300 text-black shadow-sm focus:ring-black">
                                            <span class="text-sm text-gray-700">{{ $note->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                            <textarea name="description" rows="4" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-black" required>{{ old('description', $product->description) }}</textarea>
                        </div>

                        {{-- Upload Foto --}}
                        <div class="mb-4 p-4 bg-gray-50 border rounded-md flex gap-4 items-center">
                            @if($product->image)
                                <div class="w-20 h-20 bg-white border p-1 rounded">
                                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-contain">
                                </div>
                            @endif
                            <div class="flex-1">
                                <label class="block text-sm font-bold text-gray-700 mb-1">Ganti Foto (Opsional)</label>
                                <input type="file" name="image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-200 file:text-gray-700 hover:file:bg-gray-300">
                            </div>
                        </div>

                        {{-- === VARIAN PRODUK (EDIT MODE) === --}}
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <div class="flex justify-between items-center mb-4">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">Varian Produk</h3>
                                    <p class="text-sm text-gray-500">Kelola ukuran dan harga.</p>
                                </div>
                                <button type="button" onclick="addVariant()" class="text-sm bg-black text-white px-4 py-2 rounded-md hover:bg-gray-800 transition">
                                    + Tambah Varian
                                </button>
                            </div>
                            
                            <div id="variants-container" class="space-y-3">
    {{-- LOOP VARIAN YANG SUDAH ADA --}}
    @foreach($product->variants as $variant)
        <div class="variant-row flex gap-3 items-end bg-white p-3 border rounded-md shadow-sm">
            <div class="flex-1">
                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Ukuran</label>
                <input type="text" name="sizes[]" value="{{ $variant->size }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-black text-sm" placeholder="Contoh: 100ml" required>
            </div>
            <div class="flex-1">
                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Harga (Rp)</label>
                <input type="number" name="prices[]" value="{{ $variant->price }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-black text-sm" placeholder="Harga" required>
            </div>
            <div class="w-24">
                <label class="block text-[10px] font-bold text-gray-600 uppercase mb-1">Stok</label>
                <input type="number" name="stocks[]" value="{{ $variant->stock }}" class="w-full border-gray-300 bg-blue-50 rounded-md shadow-sm focus:ring-blue-500 text-sm font-bold" placeholder="0" required>
            </div>
            {{-- Tombol Hapus Baris --}}
            <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 p-2 mb-1" title="Hapus Baris">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
            </button>
        </div>
    @endforeach
</div>
                        </div>

                        <div class="flex items-center gap-4 mt-8 pt-6 border-t">
                            <a href="{{ route('admin.products.index') }}" class="text-gray-600 hover:text-gray-900">Batal</a>
                            <button type="submit" class="bg-black text-white font-bold py-2.5 px-6 rounded shadow-md hover:bg-gray-800">
                                UPDATE PRODUK
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- Script JavaScript sama seperti Create --}}
    <script>
        function addVariant() {
            const container = document.getElementById('variants-container');
            const newRow = document.createElement('div');
            newRow.className = 'variant-row flex gap-3 items-start mt-2';
            newRow.innerHTML = `
                <div class="w-1/2">
                    <input type="text" name="sizes[]" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-black text-sm" placeholder="Ukuran Baru" required>
                </div>
                <div class="w-1/2">
                    <input type="number" name="prices[]" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-black text-sm" placeholder="Harga" required>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="mt-1 text-red-500 hover:text-red-700 p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
                </button>
            `;
            container.appendChild(newRow);
        }
    </script>
</x-app-layout>