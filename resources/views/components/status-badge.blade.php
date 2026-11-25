@props(['status'])

@php
$warna = match ($status) {
    'menunggu' => 'bg-yellow-100 text-yellow-800',
    'diterima' => 'bg-blue-100 text-blue-800',
    'dijemput' => 'bg-indigo-100 text-indigo-800',
    'selesai' => 'bg-green-100 text-green-800',
    'dibatalkan' => 'bg-red-100 text-red-800',
    default => 'bg-gray-100 text-gray-800',
};
@endphp

<span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-medium capitalize {{ $warna }}">{{ $status }}</span>