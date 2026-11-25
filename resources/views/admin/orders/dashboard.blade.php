<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Admin</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Ringkasan --}}
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <div class="bg-white shadow-sm sm:rounded-lg p-4">
                    <div class="text-gray-500 text-sm">Total Pesanan</div>
                    <div class="text-2xl font-semibold">{{ $stats['total_pesanan'] }}</div>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-4">
                    <div class="text-gray-500 text-sm">Pendapatan (lunas)</div>
                    <div class="text-2xl font-semibold">Rp{{ number_format($stats['pendapatan'], 0, ',', '.') }}</div>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-4">
                    <div class="text-gray-500 text-sm">Selesai, belum dibayar</div>
                    <div class="text-2xl font-semibold">{{ $stats['belum_bayar'] }}</div>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-4">
                    <div class="text-gray-500 text-sm">Pelanggan</div>
                    <div class="text-2xl font-semibold">{{ $stats['pelanggan'] }}</div>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-4">
                    <div class="text-gray-500 text-sm">Driver</div>
                    <div class="text-2xl font-semibold">{{ $stats['driver'] }}</div>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-4">
                    <div class="text-gray-500 text-sm">Rata-rata rating</div>
                    <div class="text-2xl font-semibold">{{ $stats['rating'] }} ★</div>
                </div>
            </div>

            {{-- Rekap per status --}}
            <div>
                <h3 class="font-semibold text-lg mb-2">Rekap Status Pesanan</h3>
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                    @foreach (['menunggu', 'diterima', 'dijemput', 'selesai', 'dibatalkan'] as $s)
                        <a href="{{ route('admin.orders.index', ['status' => $s]) }}"
                           class="bg-white shadow-sm sm:rounded-lg p-4 hover:bg-gray-50">
                            <div class="text-gray-500 text-sm capitalize">{{ $s }}</div>
                            <div class="text-xl font-semibold">{{ $statusCount[$s] ?? 0 }}</div>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Pesanan terbaru --}}
            <div>
                <div class="flex items-center justify-between mb-2">
                    <h3 class="font-semibold text-lg">Pesanan Terbaru</h3>
                    <a href="{{ route('admin.orders.index') }}" class="text-sm text-gray-600 hover:underline">Lihat semua</a>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50 text-left text-gray-600">
                            <tr>
                                <th class="px-4 py-3">Tanggal</th>
                                <th class="px-4 py-3">Pelanggan</th>
                                <th class="px-4 py-3">Rute</th>
                                <th class="px-4 py-3">Driver</th>
                                <th class="px-4 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @forelse ($terbaru as $order)
                                <tr>
                                    <td class="px-4 py-3">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-4 py-3">{{ $order->pelanggan->name }}</td>
                                    <td class="px-4 py-3">{{ $order->zonaAsal->nama_zona }} → {{ $order->zonaTujuan->nama_zona }}</td>
                                    <td class="px-4 py-3">{{ $order->driver?->user?->name ?? '-' }}</td>
                                    <td class="px-4 py-3"><x-status-badge :status="$order->status" /></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-6 text-center text-gray-500">Belum ada pesanan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>