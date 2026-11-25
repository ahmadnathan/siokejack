<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@siokejack.test'],
            [
                'name' => 'Admin SiOkejack',
                'no_hp' => '081234567890',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'driver@siokejack.test'],
            [
                'name' => 'Driver Contoh',
                'no_hp' => '081234567891',
                'role' => 'driver',
                'password' => Hash::make('password'),
            ]
        );
    }
}