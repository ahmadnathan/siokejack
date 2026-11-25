<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Driver</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
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

            {{-- Form tambah driver --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-3">Tambah Driver</h3>
                <form method="POST" action="{{ route('admin.drivers.store') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @csrf
                    <input name="name" value="{{ old('name') }}" placeholder="Nama" required
                           class="border-gray-300 rounded-md shadow-sm">
                    <input name="email" type="email" value="{{ old('email') }}" placeholder="Email" required
                           class="border-gray-300 rounded-md shadow-sm">
                    <input name="no_hp" value="{{ old('no_hp') }}" placeholder="No. HP" required
                           class="border-gray-300 rounded-md shadow-sm">
                    <input name="password" type="password" placeholder="Password (min. 8 karakter)" required
                           class="border-gray-300 rounded-md shadow-sm">
                    <input name="plat_nomor" value="{{ old('plat_nomor') }}" placeholder="Plat nomor" required
                           class="border-gray-300 rounded-md shadow-sm">
                    <input name="jenis_motor" value="{{ old('jenis_motor') }}" placeholder="Jenis motor (opsional)"
                           class="border-gray-300 rounded-md shadow-sm">
                    <div class="md:col-span-2">
                        <button class="px-4 py-2 bg-orange-600 text-white rounded-md hover:bg-orange-700">Simpan Driver</button>
                    </div>
                </form>
            </div>

            {{-- Daftar driver --}}
            <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 text-left text-gray-600">
                        <tr>
                            <th class="px-4 py-3">Nama</th>
                            <th class="px-4 py-3">Kontak</th>
                            <th class="px-4 py-3">Motor</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($drivers as $driver)
                            <tr>
                                <td class="px-4 py-3">{{ $driver->user->name }}</td>
                                <td class="px-4 py-3">
                                    <div>{{ $driver->user->email }}</div>
                                    <div class="text-gray-500">{{ $driver->user->no_hp }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <div>{{ $driver->plat_nomor }}</div>
                                    <div class="text-gray-500">{{ $driver->jenis_motor }}</div>
                                </td>
                                <td class="px-4 py-3 capitalize">{{ $driver->status }}</td>
                                <td class="px-4 py-3">
                                    <form method="POST" action="{{ route('admin.drivers.toggle', $driver) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button class="px-3 py-1 border rounded hover:bg-gray-50">
                                            {{ $driver->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-gray-500">Belum ada driver.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>