<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Tarif</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if (session('success'))
                <div class="p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="p-3 bg-red-100 text-red-800 rounded">Ada isian tarif yang tidak valid (harus angka bulat, minimal 0).</div>
            @endif

            <p class="text-sm text-gray-600">
                Baris = zona jemput, kolom = zona tujuan. Isi harga dalam rupiah tanpa titik.
                Kotak yang dikosongkan tidak diubah.
            </p>

            <form method="POST" action="{{ route('admin.tarifs.update') }}">
                @csrf
                @method('PUT')

                <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50 text-left text-gray-600">
                            <tr>
                                <th class="px-4 py-3">Jemput \ Tujuan</th>
                                @foreach ($zones as $tujuan)
                                    <th class="px-4 py-3">{{ $tujuan->nama_zona }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @forelse ($zones as $asal)
                                <tr>
                                    <td class="px-4 py-3 font-medium">{{ $asal->nama_zona }}</td>
                                    @foreach ($zones as $tujuan)
                                        <td class="px-4 py-3">
                                            <input type="number" min="0" step="500"
                                                   name="harga[{{ $asal->id }}][{{ $tujuan->id }}]"
                                                   value="{{ $tarifMap[$asal->id.'-'.$tujuan->id] ?? '' }}"
                                                   class="w-28 border-gray-300 rounded-md text-sm">
                                        </td>
                                    @endforeach
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-4 py-6 text-center text-gray-500">Belum ada zona. Tambahkan dulu di menu Zona.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <button class="px-4 py-2 bg-orange-600 text-white rounded-md hover:bg-orange-700">Simpan Tarif</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>