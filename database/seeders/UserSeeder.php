<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@hotel.com',
            'role' => 'admin',
            'password' => Hash::make('123456789'), // Change this in production!
        ]);

        // Receptionist
        User::create([
            'name' => 'Receptionist Jane',
            'email' => 'reception@hotel.com',
            'role' => 'receptionist',
            'password' => Hash::make('123456789'),
        ]);
    }
}
