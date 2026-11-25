<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Tarif;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;

class PelangganOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['zonaAsal', 'zonaTujuan', 'driver.user', 'payment', 'review'])
            ->where('pelanggan_id', Auth::id())
            ->latest()
            ->get();

        return view('pelanggan.orders.index', compact('orders'));
    }

    public function create()
    {
        $zones = Zone::orderBy('nama_zona')->get();

        // Peta tarif untuk estimasi di browser: "asal-tujuan" => harga
        $tarifMap = Tarif::all()->mapWithKeys(fn ($t) => [
            $t->zona_asal_id.'-'.$t->zona_tujuan_id => $t->harga,
        ]);

        return view('pelanggan.orders.create', compact('zones', 'tarifMap'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'zona_asal_id' => ['required', 'exists:zones,id'],
            'zona_tujuan_id' => ['required', 'exists:zones,id'],
            'alamat_jemput' => ['required', 'string', 'max:255'],
            'alamat_tujuan' => ['required', 'string', 'max:255'],
            'catatan' => ['nullable', 'string', 'max:500'],
        ]);

        // Tarif dihitung ulang di server, bukan dari input browser
        $tarif = Tarif::where('zona_asal_id', $data['zona_asal_id'])
            ->where('zona_tujuan_id', $data['zona_tujuan_id'])
            ->first();

        if (! $tarif) {
            return back()->withInput()
                ->withErrors(['zona_tujuan_id' => 'Tarif untuk rute ini belum tersedia.']);
        }

        Order::create($data + [
            'pelanggan_id' => Auth::id(),
            'tarif' => $tarif->harga,
            'status' => 'menunggu',
        ]);

        return redirect()->route('pelanggan.orders.index')
            ->with('success', 'Pesanan berhasil dibuat. Menunggu driver menerima.');
    }
    public function review(Request $request, Order $order)
{
    abort_if($order->pelanggan_id !== Auth::id(), 403);

    if ($order->status !== 'selesai') {
        return back()->with('error', 'Ulasan hanya bisa diberikan setelah pesanan selesai.');
    }

    if ($order->review) {
        return back()->with('error', 'Pesanan ini sudah kamu beri ulasan.');
    }

    $data = $request->validate([
        'rating' => ['required', 'integer', 'between:1,5'],
        'ulasan' => ['nullable', 'string', 'max:500'],
    ]);

    Review::create($data + ['order_id' => $order->id]);

    return back()->with('success', 'Terima kasih, ulasanmu tersimpan.');
}
public function cancel(Order $order)
{
    abort_if($order->pelanggan_id !== Auth::id(), 403);

    // Update bersyarat: hanya berhasil kalau masih menunggu
    $berhasil = Order::where('id', $order->id)
        ->where('pelanggan_id', Auth::id())
        ->where('status', 'menunggu')
        ->update(['status' => 'dibatalkan']);

    if (! $berhasil) {
        return back()->with('error', 'Pesanan tidak bisa dibatalkan karena sudah diterima driver.');
    }

    return back()->with('success', 'Pesanan dibatalkan.');
}
}