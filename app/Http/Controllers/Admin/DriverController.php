<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::with('user')->latest()->get();

        return view('admin.drivers.index', compact('drivers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'no_hp' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8'],
            'plat_nomor' => ['required', 'string', 'max:15'],
            'jenis_motor' => ['nullable', 'string', 'max:255'],
        ]);

        DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'no_hp' => $data['no_hp'],
                'role' => 'driver',
                'password' => $data['password'],
            ]);

            Driver::create([
                'user_id' => $user->id,
                'plat_nomor' => $data['plat_nomor'],
                'jenis_motor' => $data['jenis_motor'] ?? null,
                'status' => 'aktif',
            ]);
        });

        return back()->with('success', 'Driver berhasil ditambahkan.');
    }

    public function toggle(Driver $driver)
    {
        $driver->update([
            'status' => $driver->status === 'aktif' ? 'nonaktif' : 'aktif',
        ]);

        return back()->with('success', 'Status driver diperbarui.');
    }
}