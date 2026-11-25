<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Zona</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
            @endif
            @if ($errors->any())
                <div class="p-3 bg-red-100 text-red-800 rounded">
                    <ul class="list-disc ms-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-3">Tambah Zona</h3>
                <form method="POST" action="{{ route('admin.zones.store') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @csrf
                    <input name="nama_zona" value="{{ old('nama_zona') }}" placeholder="Nama zona" required
                           class="border-gray-300 rounded-md shadow-sm">
                    <input name="keterangan" value="{{ old('keterangan') }}" placeholder="Keterangan (opsional)"
                           class="border-gray-300 rounded-md shadow-sm">
                    <button class="px-4 py-2 bg-orange-600 text-white rounded-md hover:bg-orange-700">Tambah</button>
                </form>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 text-left text-gray-600">
                        <tr>
                            <th class="px-4 py-3">Zona</th>
                            <th class="px-4 py-3">Keterangan</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($zones as $zone)
                            <tr>
                                <td class="px-4 py-3">{{ $zone->nama_zona }}</td>
                                <td class="px-4 py-3 text-gray-500">{{ $zone->keterangan }}</td>
                                <td class="px-4 py-3">
                                    <form method="POST" action="{{ route('admin.zones.destroy', $zone) }}"
                                          onsubmit="return confirm('Hapus zona ini beserta tarifnya?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-3 py-1 border border-red-300 text-red-700 rounded hover:bg-red-50">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-6 text-center text-gray-500">Belum ada zona.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>