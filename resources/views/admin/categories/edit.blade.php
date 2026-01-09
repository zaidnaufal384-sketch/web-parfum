<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Kategori') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h3 class="text-lg font-bold mb-6">Edit Kategori: {{ $category->name }}</h3>

                    {{-- Form Edit --}}
                    {{-- Action mengarah ke route update dengan membawa ID kategori --}}
                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                        @csrf 
                        @method('PUT') {{-- PENTING: Mengubah method POST menjadi PUT untuk update --}}

                        {{-- Input Nama --}}
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                            {{-- Value diambil dari database ($category->name) --}}
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name', $category->name) }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                   required>
                        </div>

                        {{-- Input Slug --}}
                        <div class="mb-4">
                            <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug (URL)</label>
                            <input type="text" 
                                   name="slug" 
                                   id="slug" 
                                   value="{{ old('slug', $category->slug) }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <p class="text-xs text-gray-500 mt-1">Kosongkan jika ingin generate ulang otomatis dari nama.</p>
                        </div>

                        <div class="flex items-center gap-2 mt-6">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Kategori
                            </button>
                            <a href="{{ route('admin.categories.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                                Batal
                            </a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>