<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Produk Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- PESAN ERROR VALIDASI --}}
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

                    {{-- FORMULIR UTAMA --}}
                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf 

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            {{-- Nama Produk --}}
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Parfum</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500" required>
                            </div>

                            {{-- Brand --}}
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Brand</label>
                                <input type="text" name="brand" value="{{ old('brand') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500" required>
                            </div>

                            {{-- Kategori --}}
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                                <select name="category_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Gender --}}
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Target Gender</label>
                                <select name="gender" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500">
                                    <option value="Men" {{ old('gender') == 'Men' ? 'selected' : '' }}>Men</option>
                                    <option value="Women" {{ old('gender') == 'Women' ? 'selected' : '' }}>Women</option>
                                    <option value="Unisex" {{ old('gender') == 'Unisex' ? 'selected' : '' }}>Unisex</option>
                                </select>
                            </div>

                            {{-- Notes --}}
                            <div class="mb-4 md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Olfactory Notes</label>
                                <div class="flex flex-wrap gap-4">
                                    @foreach($notes as $note)
                                        <label class="flex items-center gap-2">
                                            {{-- PERBAIKAN: Gunakan $note->id pada value, BUKAN $note->name --}}
                                            <input type="checkbox" name="notes[]" value="{{ $note->id }}" 
                                                   {{ (is_array(old('notes')) && in_array($note->id, old('notes'))) ? 'checked' : '' }}
                                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                            <span class="text-sm text-gray-700">{{ $note->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                            <textarea name="description" rows="4" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500" required>{{ old('description') }}</textarea>
                        </div>

                        {{-- Upload Foto --}}
                        <div class="mb-4 p-4 bg-gray-50 border rounded-md">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Foto Produk</label>
                            <input type="file" name="image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
                        </div>

                        {{-- === BAGIAN INPUT VARIAN DINAMIS (JavaScript) === --}}
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <div class="flex justify-between items-center mb-4">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">Varian Produk</h3>
                                    <p class="text-sm text-gray-500">Masukkan ukuran dan harga (Wajib minimal 1).</p>
                                </div>
                                <button type="button" onclick="addVariant()" 
                                    class="text-sm bg-indigo-50 text-indigo-700 hover:bg-indigo-100 px-4 py-2 rounded-md font-medium transition flex items-center gap-2">
                                    <span>+</span> Tambah Ukuran Lain
                                </button>
                            </div>
                            
                          <div id="variants-container" class="space-y-3">
    {{-- Baris Varian Pertama --}}
    <div class="variant-row flex gap-3 items-end"> {{-- Ubah items-start jadi items-end agar label sejajar --}}
        <div class="w-1/3">
            <label class="block text-xs font-bold text-gray-500 mb-1">Ukuran (Cth: 100ml)</label>
            <input type="text" name="sizes[]" 
                   class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 text-sm" 
                   placeholder="100ml" required>
        </div>
        <div class="w-1/3">
            <label class="block text-xs font-bold text-gray-500 mb-1">Harga (Rp)</label>
            <input type="number" name="prices[]" 
                   class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 text-sm" 
                   placeholder="1500000" required>
        </div>
        {{-- TAMBAHKAN KOLOM STOK DI BAWAH INI --}}
        <div class="w-1/3">
            <label class="block text-xs font-bold text-gray-500 mb-1">Stok Awal</label>
            <input type="number" name="stocks[]" 
                   class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 text-sm" 
                   placeholder="10" required>
        </div>
        {{-- Spacer agar sejajar dengan baris yang punya tombol hapus --}}
        <div class="w-10"></div> 
    </div>
</div>
                        </div>

                        {{-- Tombol Simpan --}}
                        <div class="flex items-center gap-4 mt-8 pt-6 border-t">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded shadow-md w-full md:w-auto">
                                SIMPAN PRODUK
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPT JAVASCRIPT UNTUK TAMBAH/HAPUS KOLOM --}}
    <script>
    function addVariant() {
        const container = document.getElementById('variants-container');
        const newRow = document.createElement('div');
        newRow.className = 'variant-row flex gap-3 items-start mt-2';
        
        newRow.innerHTML = `
            <div class="w-1/3">
                <input type="text" name="sizes[]" 
                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 text-sm" 
                       placeholder="Ukuran (Cth: 50ml)" required>
            </div>
            <div class="w-1/3">
                <input type="number" name="prices[]" 
                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 text-sm" 
                       placeholder="Harga (Rp)" required>
            </div>
            <div class="w-1/3">
                <input type="number" name="stocks[]" 
                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 text-sm" 
                       placeholder="Stok" required>
            </div>
            <button type="button" onclick="this.parentElement.remove()" 
                    class="text-red-500 hover:text-red-700 p-2 bg-red-50 hover:bg-red-100 rounded-md transition" title="Hapus Baris">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                </svg>
            </button>
        `;
        
        container.appendChild(newRow);
    }
</script>
</x-app-layout>