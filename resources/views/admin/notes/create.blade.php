<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Note Baru
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('admin.notes.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nama Note (Misal: Floral)</label>
                        {{-- Ubah name="title" menjadi name="name" --}}
                        <input type="text" name="name" class="w-full border-gray-300 rounded-md shadow-sm focus:border-black focus:ring-black" required>
                    </div>

                    <div class="flex justify-end gap-4">
                        <a href="{{ route('admin.notes.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Batal</a>
                        <button type="submit" class="px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800">Simpan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>