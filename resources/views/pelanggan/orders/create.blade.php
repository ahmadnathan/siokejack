<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pesan Ojek</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('pelanggan.orders.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <x-input-label for="zona_asal_id" value="Zona jemput" />
                        <select id="zona_asal_id" name="zona_asal_id" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">Pilih zona</option>
                            @foreach ($zones as $zone)
                                <option value="{{ $zone->id }}" @selected(old('zona_asal_id') == $zone->id)>{{ $zone->nama_zona }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('zona_asal_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="alamat_jemput" value="Alamat jemput" />
                        <x-text-input id="alamat_jemput" name="alamat_jemput" class="mt-1 block w-full"
                                      :value="old('alamat_jemput')" required />
                        <x-input-error :messages="$errors->get('alamat_jemput')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="zona_tujuan_id" value="Zona tujuan" />
                        <select id="zona_tujuan_id" name="zona_tujuan_id" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">Pilih zona</option>
                            @foreach ($zones as $zone)
                                <option value="{{ $zone->id }}" @selected(old('zona_tujuan_id') == $zone->id)>{{ $zone->nama_zona }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('zona_tujuan_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="alamat_tujuan" value="Alamat tujuan" />
                        <x-text-input id="alamat_tujuan" name="alamat_tujuan" class="mt-1 block w-full"
                                      :value="old('alamat_tujuan')" required />
                        <x-input-error :messages="$errors->get('alamat_tujuan')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="catatan" value="Catatan (opsional)" />
                        <textarea id="catatan" name="catatan" rows="2"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('catatan') }}</textarea>
                    </div>

                    <div class="p-3 bg-gray-50 rounded">
                        Estimasi tarif:
                        <span id="estimasi" class="font-semibold">Pilih zona jemput dan tujuan</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <x-primary-button>Pesan Sekarang</x-primary-button>
                        <a href="{{ route('pelanggan.orders.index') }}" class="text-sm text-gray-600 hover:underline">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const tarif = @json($tarifMap);
        const asal = document.getElementById('zona_asal_id');
        const tujuan = document.getElementById('zona_tujuan_id');
        const estimasi = document.getElementById('estimasi');

        function hitung() {
            if (!asal.value || !tujuan.value) {
                estimasi.textContent = 'Pilih zona jemput dan tujuan';
                return;
            }
            const harga = tarif[asal.value + '-' + tujuan.value];
            estimasi.textContent = harga
                ? 'Rp' + Number(harga).toLocaleString('id-ID')
                : 'Tarif belum tersedia';
        }

        asal.addEventListener('change', hitung);
        tujuan.addEventListener('change', hitung);
        hitung();
    </script>
</x-app-layout>