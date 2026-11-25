<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverOrderController extends Controller
{
    private function driverLogin()
    {
        $driver = Auth::user()->driver;

        abort_if(! $driver, 403, 'Akun ini belum terdaftar sebagai driver.');

        return $driver;
    }

    public function index()
    {
        $driver = $this->driverLogin();

        // Pesanan masuk: belum ada driver dan masih menunggu
        $masuk = Order::with(['pelanggan', 'zonaAsal', 'zonaTujuan'])
            ->whereNull('driver_id')
            ->where('status', 'menunggu')
            ->oldest()
            ->get();

        // Pesanan milik driver ini
        $saya = Order::with(['pelanggan', 'zonaAsal', 'zonaTujuan', 'payment'])
            ->where('driver_id', $driver->id)
            ->latest()
            ->get();

        return view('driver.orders.index', compact('masuk', 'saya'));
    }

    public function accept(Order $order)
    {
        $driver = $this->driverLogin();

        if ($driver->status !== 'aktif') {
            return back()->with('error', 'Akun driver kamu sedang nonaktif.');
        }

        // Update bersyarat supaya tidak diambil dua driver sekaligus
        $berhasil = Order::where('id', $order->id)
            ->whereNull('driver_id')
            ->where('status', 'menunggu')
            ->update(['driver_id' => $driver->id, 'status' => 'diterima']);

        if (! $berhasil) {
            return back()->with('error', 'Pesanan sudah diambil driver lain atau dibatalkan.');
        }

        return back()->with('success', 'Pesanan diterima.');
    }

    public function updateStatus(Order $order)
    {
        $driver = $this->driverLogin();

        abort_if($order->driver_id !== $driver->id, 403);

        $berikutnya = [
            'diterima' => 'dijemput',
            'dijemput' => 'selesai',
        ];

        if (! isset($berikutnya[$order->status])) {
            return back()->with('error', 'Status pesanan ini tidak bisa diubah lagi.');
        }

        $order->update(['status' => $berikutnya[$order->status]]);

        return back()->with('success', 'Status pesanan diperbarui.');
    }

    public function payment(Request $request, Order $order)
    {
        $driver = $this->driverLogin();

        abort_if($order->driver_id !== $driver->id, 403);

        if ($order->status !== 'selesai') {
            return back()->with('error', 'Pembayaran hanya bisa dicatat setelah pesanan selesai.');
        }

        $data = $request->validate([
            'metode' => ['required', 'in:tunai,transfer'],
        ]);

        Payment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'metode' => $data['metode'],
                'status' => 'lunas',
                'dicatat_oleh' => Auth::id(),
                'dibayar_pada' => now(),
            ]
        );

        return back()->with('success', 'Pembayaran dicatat lunas.');
    }
}