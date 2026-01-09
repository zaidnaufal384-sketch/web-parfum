<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Bagian Statistik (Grid Card) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-blue-500">
                    <div class="p-6 text-gray-900 flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Kategori</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $totalCategories }}</p>
                        </div>
                        {{-- Ikon Folder (SVG) --}}
                        <div class="p-3 bg-blue-100 rounded-full text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-2 border-t text-sm">
                        <a href="{{ route('admin.categories.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold">Kelola Kategori &rarr;</a>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-green-500">
                    <div class="p-6 text-gray-900 flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Produk</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $totalProducts }}</p>
                        </div>
                        {{-- Ikon Box (SVG) --}}
                        <div class="p-3 bg-green-100 rounded-full text-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-2 border-t text-sm">
                        <a href="{{ route('admin.products.index') }}" class="text-green-600 hover:text-green-800 font-semibold">Kelola Produk &rarr;</a>
                    </div>
                </div>

            </div>

            {{-- Bagian Selamat Datang --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-2">Selamat Datang, Admin!</h3>
                    <p class="text-gray-600">Ini adalah halaman kontrol utama. Gunakan menu navigasi di atas atau kartu di atas untuk mengelola konten website toko parfum Anda.</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>