<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Zone;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    public function index()
    {
        $zones = Zone::orderBy('nama_zona')->get();

        return view('admin.zones.index', compact('zones'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_zona' => ['required', 'string', 'max:255', 'unique:zones,nama_zona'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ]);

        Zone::create($data);

        return back()->with('success', 'Zona ditambahkan. Atur tarifnya di menu Tarif.');
    }

    public function destroy(Zone $zone)
    {
        $dipakai = Order::where('zona_asal_id', $zone->id)
            ->orWhere('zona_tujuan_id', $zone->id)
            ->exists();

        if ($dipakai) {
            return back()->with('error', 'Zona sudah dipakai di pesanan, tidak bisa dihapus.');
        }

        $zone->delete();

        return back()->with('success', 'Zona dihapus.');
    }
}