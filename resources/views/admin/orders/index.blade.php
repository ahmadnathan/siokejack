<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Semua Pesanan</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if (session('success'))
                <div class="p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
            @endif

            {{-- Filter status --}}
            <div class="flex flex-wrap gap-2 text-sm">
                <a href="{{ route('admin.orders.index') }}"
                   class="px-3 py-1 rounded border {{ $status ? 'bg-white' : 'bg-orange-600 text-white' }}">Semua</a>
                @foreach (['menunggu', 'diterima', 'dijemput', 'selesai', 'dibatalkan'] as $s)
                    <a href="{{ route('admin.orders.index', ['status' => $s]) }}"
                       class="px-3 py-1 rounded border capitalize {{ $status === $s ? 'bg-orange-600 text-white' : 'bg-white' }}">{{ $s }}</a>
                @endforeach
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 text-left text-gray-600">
                        <tr>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Pelanggan</th>
                            <th class="px-4 py-3">Rute</th>
                            <th class="px-4 py-3">Tarif</th>
                            <th class="px-4 py-3">Driver</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Pembayaran</th>
                            <th class="px-4 py-3">Rating</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($orders as $order)
                            <tr>
                                <td class="px-4 py-3">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-3">
                                    <div>{{ $order->pelanggan->name }}</div>
                                    <div class="text-gray-500">{{ $order->pelanggan->no_hp }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <div>{{ $order->zonaAsal->nama_zona }} → {{ $order->zonaTujuan->nama_zona }}</div>
                                    <div class="text-gray-500">{{ $order->alamat_jemput }} ke {{ $order->alamat_tujuan }}</div>
                                </td>
                                <td class="px-4 py-3">Rp{{ number_format($order->tarif, 0, ',', '.') }}</td>
                                <td class="px-4 py-3">{{ $order->driver?->user?->name ?? '-' }}</td>
                                <td class="px-4 py-3"><x-status-badge :status="$order->status" /></td>
                                <td class="px-4 py-3">
                                    @if ($order->payment?->status === 'lunas')
                                        <span class="text-green-700">Lunas ({{ $order->payment->metode }})</span>
                                    @elseif ($order->status === 'selesai')
                                        <form method="POST" action="{{ route('admin.orders.payment', $order) }}" class="flex gap-2">
                                            @csrf
                                            <select name="metode" class="border-gray-300 rounded-md text-sm">
                                                <option value="tunai">Tunai</option>
                                                <option value="transfer">Transfer</option>
                                            </select>
                                            <button class="px-3 py-1 bg-orange-600 text-white rounded hover:bg-orange-700">
                                                Catat Lunas
                                            </button>
                                        </form>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    {{ $order->review ? $order->review->rating.' ★' : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-6 text-center text-gray-500">Tidak ada pesanan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $orders->links() }}
        </div>
    </div>
</x-app-layout>