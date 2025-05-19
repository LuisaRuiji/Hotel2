<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Room;
use App\Models\Booking;

class UpdateRoomStatuses extends Command
{
    protected $signature = 'rooms:update-statuses';
    protected $description = 'Update all room statuses based on their current bookings';

    public function handle()
    {
        $this->info('Updating room statuses...');

        $rooms = Room::with(['bookings' => function($query) {
            $query->whereIn('status', ['approved', 'checked_in'])
                ->where('check_out_date', '>=', now());
        }])->get();

        foreach ($rooms as $room) {
            $currentBooking = $room->bookings->first();
            
            if ($currentBooking) {
                $room->updateStatusFromBooking($currentBooking->status);
                $this->line("Room {$room->room_number}: Updated to " . $room->status);
            } else {
                $room->update(['status' => Room::STATUS_AVAILABLE]);
                $this->line("Room {$room->room_number}: Set to available");
            }
        }

        $this->info('Room statuses have been updated successfully!');
    }
} 