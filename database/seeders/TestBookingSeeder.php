<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\User;
use App\Models\Room;
use Carbon\Carbon;

class TestBookingSeeder extends Seeder
{
    public function run()
    {
        // Create a test user if not exists
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
                'role' => 'customer'
            ]
        );

        // Today's date
        $today = Carbon::today();

        // Create 3 test bookings for different rooms
        $rooms = [
            [
                'number' => '301',
                'check_in' => $today->copy(),
                'check_out' => $today->copy()->addDays(2),
                'amount' => 1500.00
            ],
            [
                'number' => '302',
                'check_in' => $today->copy(),
                'check_out' => $today->copy()->addDays(3),
                'amount' => 1800.00
            ],
            [
                'number' => '303',
                'check_in' => $today->copy(),
                'check_out' => $today->copy()->addDays(1),
                'amount' => 1200.00
            ]
        ];

        foreach ($rooms as $roomData) {
            $room = Room::where('room_number', $roomData['number'])->first();
            
            if ($room) {
                Booking::create([
                    'user_id' => $user->id,
                    'room_id' => $room->id,
                    'check_in_date' => $roomData['check_in'],
                    'check_out_date' => $roomData['check_out'],
                    'guests' => 2,
                    'total_amount' => $roomData['amount'],
                    'status' => 'pending',
                    'special_requests' => 'Test booking for room ' . $roomData['number']
                ]);
            }
        }
    }
} 