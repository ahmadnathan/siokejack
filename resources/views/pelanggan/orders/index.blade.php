<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pesanan Saya</h2>
            <a href="{{ route('pelanggan.orders.create') }}"
               class="px-4 py-2 bg-orange-600 text-white text-sm rounded-md hover:bg-orange-700">
                + Pesan Ojek
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 text-left text-gray-600">
                        <tr>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Rute</th>
                            <th class="px-4 py-3">Alamat</th>
                            <th class="px-4 py-3">Tarif</th>
                            <th class="px-4 py-3">Driver</th>
                            <th class="px-4 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($orders as $order)
                            <tr>
                                <td class="px-4 py-3">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-3">{{ $order->zonaAsal->nama_zona }} → {{ $order->zonaTujuan->nama_zona }}</td>
                                <td class="px-4 py-3">
                                    <div>{{ $order->alamat_jemput }}</div>
                                    <div class="text-gray-500">ke {{ $order->alamat_tujuan }}</div>
                                </td>
                                <td class="px-4 py-3">Rp{{ number_format($order->tarif, 0, ',', '.') }}</td>
                                <td class="px-4 py-3">{{ $order->driver?->user?->name ?? '-' }}</td>
                                <td class="px-4 py-3">
    <x-status-badge :status="$order->status" />
    @if ($order->status === 'menunggu')
        <form method="POST" action="{{ route('pelanggan.orders.cancel', $order) }}" class="mt-2"
              onsubmit="return confirm('Batalkan pesanan ini?')">
            @csrf
            @method('PATCH')
            <button class="text-xs text-red-600 hover:underline">Batalkan</button>
        </form>
    @endif
</td>-status-badge :status="$order->status" /></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                    Belum ada pesanan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>