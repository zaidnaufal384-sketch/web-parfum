<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Olfactory Notes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="flex justify-between mb-6">
                    <h3 class="text-lg font-medium text-gray-900">List Notes</h3>
                    <a href="{{ route('admin.notes.create') }}" class="bg-black text-white px-4 py-2 rounded-md text-sm uppercase tracking-widest hover:bg-gray-800">
                        + Tambah Note
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="w-full border-collapse border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="border p-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Note</th>
                            <th class="border p-3 text-center text-xs font-medium text-gray-500 uppercase w-48">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($notes as $note)
                        <tr class="hover:bg-gray-50">
                            {{-- Panggil 'name', bukan 'title' --}}
                            <td class="border p-3">{{ $note->name }}</td>
                            <td class="border p-3 text-center space-x-2">
                                <a href="{{ route('admin.notes.edit', $note->id) }}" class="text-blue-600 hover:underline text-sm">Edit</a>
                                <form action="{{ route('admin.notes.destroy', $note->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus note ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline text-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="border p-3 text-center text-gray-400">Belum ada data notes.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                
                <div class="mt-4">
                    {{ $notes->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>