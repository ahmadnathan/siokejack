<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DriverController as AdminDriverController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\TarifController as AdminTarifController;
use App\Http\Controllers\Admin\ZoneController as AdminZoneController;
use App\Http\Controllers\DriverOrderController;
use App\Http\Controllers\PelangganOrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return match (Auth::user()->role) {
        'admin' => redirect('/admin/dashboard'),
        'driver' => redirect('/driver/dashboard'),
        default => redirect('/pelanggan/dashboard'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::post('/orders/{order}/payment', [AdminOrderController::class, 'payment'])->name('orders.payment');

    Route::get('/drivers', [AdminDriverController::class, 'index'])->name('drivers.index');
    Route::post('/drivers', [AdminDriverController::class, 'store'])->name('drivers.store');
    Route::patch('/drivers/{driver}/toggle', [AdminDriverController::class, 'toggle'])->name('drivers.toggle');

    Route::get('/zones', [AdminZoneController::class, 'index'])->name('zones.index');
    Route::post('/zones', [AdminZoneController::class, 'store'])->name('zones.store');
    Route::delete('/zones/{zone}', [AdminZoneController::class, 'destroy'])->name('zones.destroy');

    Route::get('/tarifs', [AdminTarifController::class, 'index'])->name('tarifs.index');
    Route::put('/tarifs', [AdminTarifController::class, 'update'])->name('tarifs.update');
});

Route::middleware(['auth', 'role:pelanggan'])->prefix('pelanggan')->name('pelanggan.')->group(function () {
    Route::get('/dashboard', fn () => redirect()->route('pelanggan.orders.index'))->name('dashboard');
    Route::get('/orders', [PelangganOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [PelangganOrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [PelangganOrderController::class, 'store'])->name('orders.store');
    Route::post('/orders/{order}/review', [PelangganOrderController::class, 'review'])->name('orders.review');
    Route::patch('/orders/{order}/cancel', [PelangganOrderController::class, 'cancel'])->name('orders.cancel');
});

Route::middleware(['auth', 'role:driver'])->prefix('driver')->name('driver.')->group(function () {
    Route::get('/dashboard', fn () => redirect()->route('driver.orders.index'))->name('dashboard');
    Route::get('/orders', [DriverOrderController::class, 'index'])->name('orders.index');
    Route::post('/orders/{order}/accept', [DriverOrderController::class, 'accept'])->name('orders.accept');
    Route::post('/orders/{order}/status', [DriverOrderController::class, 'updateStatus'])->name('orders.status');
    Route::post('/orders/{order}/payment', [DriverOrderController::class, 'payment'])->name('orders.payment');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';