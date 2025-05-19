<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    public function run()
    {
        $roomTypes = [
            'Standard' => ['price' => 1200.00, 'capacity' => 2],
            'Deluxe' => ['price' => 1500.00, 'capacity' => 2],
            'Suite' => ['price' => 1800.00, 'capacity' => 3],
            'Family' => ['price' => 2000.00, 'capacity' => 4],
            'Presidential' => ['price' => 2500.00, 'capacity' => 4]
        ];

        $views = ['City View', 'Garden View', 'Pool View', 'Ocean View', 'Mountain View'];
        
        $rooms = [];
        for ($floor = 2; $floor <= 6; $floor++) {
            for ($room = 1; $room <= 5; $room++) {
                $roomType = array_rand($roomTypes);
                $view = $views[array_rand($views)];
                
                $roomNumber = $floor . str_pad($room, 2, '0', STR_PAD_LEFT);
                $rooms[] = [
                    'room_number' => $roomNumber,
                    'type' => $roomType,
                    'price_per_night' => $roomTypes[$roomType]['price'],
                    'capacity' => $roomTypes[$roomType]['capacity'],
                    'description' => "$roomType Room with $view",
                    'status' => 'available',
                    'floor' => $floor,
                    'image_url' => 'https://picsum.photos/400/250?random=' . uniqid(),
                ];
            }
        }

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}
