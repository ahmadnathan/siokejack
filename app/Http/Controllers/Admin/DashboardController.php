<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Order;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $statusCount = Order::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $stats = [
            'total_pesanan' => Order::count(),
            'pelanggan' => User::where('role', 'pelanggan')->count(),
            'driver' => Driver::count(),
            'pendapatan' => Order::whereHas('payment', fn ($q) => $q->where('status', 'lunas'))->sum('tarif'),
            'belum_bayar' => Order::where('status', 'selesai')
                ->whereDoesntHave('payment', fn ($q) => $q->where('status', 'lunas'))
                ->count(),
            'rating' => round(Review::avg('rating') ?? 0, 1),
        ];

        $terbaru = Order::with(['pelanggan', 'driver.user', 'zonaAsal', 'zonaTujuan'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('statusCount', 'stats', 'terbaru'));
    }
}