<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Kategori Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Judul Form --}}
                    <h3 class="text-lg font-bold mb-6">Form Input Kategori</h3>

                    {{-- Form Start --}}
                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf 

                        {{-- Input Nama --}}
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                   placeholder="Masukkan nama kategori" 
                                   required>
                        </div>

                        {{-- Input Slug --}}
                        <div class="mb-4">
                            <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug (URL)</label>
                            <input type="text" 
                                   name="slug" 
                                   id="slug" 
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                   placeholder="Opsional: biarkan kosong untuk otomatis">
                            <p class="text-xs text-gray-500 mt-1">Jika dikosongkan, slug akan dibuat otomatis dari nama kategori.</p>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="flex items-center gap-2 mt-6">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Simpan Kategori
                            </button>
                            
                            <a href="{{ route('admin.categories.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                                Batal
                            </a>
                        </div>

                    </form>
                    {{-- Form End --}}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>