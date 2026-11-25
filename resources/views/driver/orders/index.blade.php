<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Driver</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-8">
            @if (session('success'))
                <div class="p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
            @endif

            {{-- Pesanan masuk --}}
            <div>
                <h3 class="font-semibold text-lg mb-2">Pesanan Masuk</h3>
                <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50 text-left text-gray-600">
                            <tr>
                                <th class="px-4 py-3">Pelanggan</th>
                                <th class="px-4 py-3">Rute</th>
                                <th class="px-4 py-3">Alamat</th>
                                <th class="px-4 py-3">Tarif</th>
                                <th class="px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @forelse ($masuk as $order)
                                <tr>
                                    <td class="px-4 py-3">
                                        <div>{{ $order->pelanggan->name }}</div>
                                        <div class="text-gray-500">{{ $order->pelanggan->no_hp }}</div>
                                    </td>
                                    <td class="px-4 py-3">{{ $order->zonaAsal->nama_zona }} → {{ $order->zonaTujuan->nama_zona }}</td>
                                    <td class="px-4 py-3">
                                        <div>{{ $order->alamat_jemput }}</div>
                                        <div class="text-gray-500">ke {{ $order->alamat_tujuan }}</div>
                                        @if ($order->catatan)
                                            <div class="text-gray-500 italic">{{ $order->catatan }}</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">Rp{{ number_format($order->tarif, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3">
                                        <form method="POST" action="{{ route('driver.orders.accept', $order) }}">
                                            @csrf
                                            <button class="px-3 py-1 bg-orange-600 text-white rounded hover:bg-orange-700">
                                                Terima
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                                        Belum ada pesanan masuk.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pesanan saya --}}
            <div>
                <h3 class="font-semibold text-lg mb-2">Pesanan Saya</h3>
                <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50 text-left text-gray-600">
                            <tr>
                                <th class="px-4 py-3">Pelanggan</th>
                                <th class="px-4 py-3">Rute</th>
                                <th class="px-4 py-3">Tarif</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @forelse ($saya as $order)
                                <tr>
                                    <td class="px-4 py-3">
                                        <div>{{ $order->pelanggan->name }}</div>
                                        <div class="text-gray-500">{{ $order->pelanggan->no_hp }}</div>
                                    </td>
                                    <td class="px-4 py-3">{{ $order->zonaAsal->nama_zona }} → {{ $order->zonaTujuan->nama_zona }}</td>
                                    <td class="px-4 py-3">Rp{{ number_format($order->tarif, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3"><x-status-badge :status="$order->status" /></td>
                                    <td class="px-4 py-3">
                                        @if ($order->status === 'diterima')
                                            <form method="POST" action="{{ route('driver.orders.status', $order) }}">
                                                @csrf
                                                <button class="px-3 py-1 bg-blue-700 text-white rounded hover:bg-blue-600">
                                                    Sudah Menjemput
                                                </button>
                                            </form>
                                        @elseif ($order->status === 'dijemput')
                                            <form method="POST" action="{{ route('driver.orders.status', $order) }}">
                                                @csrf
                                                <button class="px-3 py-1 bg-green-700 text-white rounded hover:bg-green-600">
                                                    Selesai
                                                </button>
                                            </form>
                                        @elseif ($order->status === 'selesai')
                                            @if ($order->payment?->status === 'lunas')
                                                <span class="text-green-700">Lunas ({{ $order->payment->metode }})</span>
                                            @else
                                                <form method="POST" action="{{ route('driver.orders.payment', $order) }}" class="flex gap-2">
                                                    @csrf
                                                    <select name="metode" class="border-gray-300 rounded-md text-sm">
                                                        <option value="tunai">Tunai</option>
                                                        <option value="transfer">Transfer</option>
                                                    </select>
                                                    <button class="px-3 py-1 bg-orange-600 text-white rounded hover:bg-orange-700">
                                                        Catat Lunas
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                                        Belum ada pesanan yang kamu ambil.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>