<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tarif;
use App\Models\Zone;
use Illuminate\Http\Request;

class TarifController extends Controller
{
    public function index()
    {
        $zones = Zone::orderBy('nama_zona')->get();

        $tarifMap = Tarif::all()->mapWithKeys(fn ($t) => [
            $t->zona_asal_id.'-'.$t->zona_tujuan_id => $t->harga,
        ]);

        return view('admin.tarifs.index', compact('zones', 'tarifMap'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'harga.*.*' => ['nullable', 'integer', 'min:0'],
        ]);

        $zoneIds = Zone::pluck('id')->all();

        foreach ($request->input('harga', []) as $asalId => $daftar) {
            foreach ($daftar as $tujuanId => $harga) {
                if ($harga === null || $harga === '') {
                    continue;
                }
                if (! in_array((int) $asalId, $zoneIds) || ! in_array((int) $tujuanId, $zoneIds)) {
                    continue;
                }

                Tarif::updateOrCreate(
                    ['zona_asal_id' => $asalId, 'zona_tujuan_id' => $tujuanId],
                    ['harga' => $harga]
                );
            }
        }

        return back()->with('success', 'Tarif disimpan. Pesanan lama tidak ikut berubah.');
    }
}