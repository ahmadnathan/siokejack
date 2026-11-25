<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\Tarif;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Database\Seeder;

class ZonaTarifSeeder extends Seeder
{
    public function run(): void
    {
        $namaZona = ['Zona 1 - Pusat', 'Zona 2 - Utara', 'Zona 3 - Selatan', 'Zona 4 - Timur'];

        $zones = [];
        foreach ($namaZona as $nama) {
            $zones[] = Zone::firstOrCreate(['nama_zona' => $nama]);
        }

        // Tarif contoh: Rp8.000 dasar + Rp4.000 per selisih zona (nanti diganti sesuai tarif mitra)
        foreach ($zones as $i => $asal) {
            foreach ($zones as $j => $tujuan) {
                Tarif::updateOrCreate(
                    ['zona_asal_id' => $asal->id, 'zona_tujuan_id' => $tujuan->id],
                    ['harga' => 8000 + abs($i - $j) * 4000]
                );
            }
        }

        // Hubungkan akun driver contoh ke tabel drivers
        $userDriver = User::where('email', 'driver@siokejack.test')->first();
        if ($userDriver) {
            Driver::firstOrCreate(
                ['user_id' => $userDriver->id],
                ['plat_nomor' => 'P 1234 XX', 'jenis_motor' => 'Honda Beat', 'status' => 'aktif']
            );
        }
    }
}