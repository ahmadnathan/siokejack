<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SiOkejack - Pesan Ojek di Jembrana</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-800 bg-white">

    {{-- Navbar --}}
    <header class="bg-white border-b border-gray-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="/" class="text-xl font-bold text-orange-600">
                Si<span class="text-gray-800">Okejack</span>
            </a>

            <nav class="flex items-center gap-3 text-sm">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="px-4 py-2 rounded-md bg-orange-600 text-white font-medium hover:bg-orange-700">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-3 py-2 text-gray-700 hover:text-orange-600">Masuk</a>
                    <a href="{{ route('register') }}"
                       class="px-4 py-2 rounded-md bg-orange-600 text-white font-medium hover:bg-orange-700">
                        Daftar
                    </a>
                @endauth
            </nav>
        </div>
    </header>

    {{-- Hero --}}
    <section class="bg-gradient-to-br from-orange-500 to-amber-400 text-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-28 text-center">
            <h1 class="text-4xl md:text-5xl font-bold leading-tight">
                Pesan Ojek di Jembrana,<br class="hidden md:block"> Lebih Mudah dan Tertata
            </h1>
            <p class="mt-5 text-lg md:text-xl text-orange-50 max-w-2xl mx-auto">
                SiOkejack membantu kamu memesan ojek tanpa chat yang berulang-ulang.
                Tarif jelas, status perjalanan terpantau, riwayat tersimpan.
            </p>
            <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="px-6 py-3 rounded-md bg-white text-orange-600 font-semibold hover:bg-orange-50">
                        Buka Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}"
                       class="px-6 py-3 rounded-md bg-white text-orange-600 font-semibold hover:bg-orange-50">
                        Mulai Pesan Sekarang
                    </a>
                    <a href="{{ route('login') }}"
                       class="px-6 py-3 rounded-md border border-white/70 text-white font-semibold hover:bg-white/10">
                        Sudah punya akun? Masuk
                    </a>
                @endauth
            </div>
        </div>
    </section>

    {{-- Keunggulan --}}
    <section class="py-16 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl md:text-3xl font-bold text-center">Kenapa SiOkejack?</h2>
            <p class="mt-2 text-center text-gray-600">Dibuat supaya pemesanan lewat WhatsApp jadi lebih rapi.</p>

            <div class="mt-10 grid gap-6 md:grid-cols-3">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="w-10 h-10 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center font-bold">1</div>
                    <h3 class="mt-4 font-semibold text-lg">Tarif Jelas</h3>
                    <p class="mt-2 text-gray-600 text-sm">
                        Estimasi tarif langsung tampil berdasarkan zona jemput dan tujuan,
                        jadi tidak perlu tawar-menawar lagi.
                    </p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="w-10 h-10 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center font-bold">2</div>
                    <h3 class="mt-4 font-semibold text-lg">Status Terpantau</h3>
                    <p class="mt-2 text-gray-600 text-sm">
                        Lihat pesananmu dari menunggu, diterima, dijemput, sampai selesai
                        di satu halaman.
                    </p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="w-10 h-10 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center font-bold">3</div>
                    <h3 class="mt-4 font-semibold text-lg">Riwayat dan Ulasan</h3>
                    <p class="mt-2 text-gray-600 text-sm">
                        Semua pesanan tersimpan rapi, dan kamu bisa memberi rating
                        untuk driver setelah perjalanan selesai.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Cara pesan --}}
    <section class="py-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl md:text-3xl font-bold text-center">Cara Memesan</h2>

            <div class="mt-10 grid gap-8 md:grid-cols-4">
                <div class="text-center">
                    <div class="mx-auto w-12 h-12 rounded-full bg-orange-600 text-white flex items-center justify-center text-lg font-bold">1</div>
                    <h3 class="mt-3 font-semibold">Daftar atau Masuk</h3>
                    <p class="mt-1 text-sm text-gray-600">Buat akun pelanggan dalam beberapa detik.</p>
                </div>
                <div class="text-center">
                    <div class="mx-auto w-12 h-12 rounded-full bg-orange-600 text-white flex items-center justify-center text-lg font-bold">2</div>
                    <h3 class="mt-3 font-semibold">Isi Rute</h3>
                    <p class="mt-1 text-sm text-gray-600">Pilih zona dan tulis alamat jemput serta tujuan.</p>
                </div>
                <div class="text-center">
                    <div class="mx-auto w-12 h-12 rounded-full bg-orange-600 text-white flex items-center justify-center text-lg font-bold">3</div>
                    <h3 class="mt-3 font-semibold">Driver Menerima</h3>
                    <p class="mt-1 text-sm text-gray-600">Driver terdekat mengambil pesananmu.</p>
                </div>
                <div class="text-center">
                    <div class="mx-auto w-12 h-12 rounded-full bg-orange-600 text-white flex items-center justify-center text-lg font-bold">4</div>
                    <h3 class="mt-3 font-semibold">Selesai dan Beri Rating</h3>
                    <p class="mt-1 text-sm text-gray-600">Bayar ke driver, lalu tinggalkan ulasan.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Ajakan --}}
    <section class="bg-gray-800 text-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-14 text-center">
            <h2 class="text-2xl md:text-3xl font-bold">Siap memesan ojek pertamamu?</h2>
            <div class="mt-6">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="inline-block px-6 py-3 rounded-md bg-orange-500 font-semibold hover:bg-orange-600">
                        Ke Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}"
                       class="inline-block px-6 py-3 rounded-md bg-orange-500 font-semibold hover:bg-orange-600">
                        Daftar Gratis
                    </a>
                @endauth
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="py-6 text-center text-sm text-gray-500">
        &copy; {{ date('Y') }} SiOkejack &middot; Okejack Jembrana
    </footer>

</body>
</html>