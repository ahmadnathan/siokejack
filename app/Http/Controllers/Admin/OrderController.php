<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $orders = Order::with(['pelanggan', 'driver.user', 'zonaAsal', 'zonaTujuan', 'payment', 'review'])
            ->when($status, fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.orders.index', compact('orders', 'status'));
    }

    public function payment(Request $request, Order $order)
    {
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