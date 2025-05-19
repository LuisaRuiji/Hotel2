<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminAccounts = [
            [
                'name' => 'Main Admin',
                'email' => 'admin@hotel.com',
                'password' => 'admin',
                'role' => 'admin'
            ],
            [
                'name' => 'Hotel Receptionist',
                'email' => 'receptionist@hotel.com',
                'password' => 'admin',
                'role' => 'receptionist'
            ],
            [
                'name' => 'Tester',
                'email' => 'tester@hotel.com',
                'password' => 'admin',
                'role' => 'customer'
            ]
        ];

        foreach ($adminAccounts as $admin) {
            User::create([
                'name' => $admin['name'],
                'email' => $admin['email'],
                'email_verified_at' => now(),
                'password' => Hash::make($admin['password']),
                'remember_token' => Str::random(10),
                'role' => $admin['role'],
            ]);
        }
    }
} 