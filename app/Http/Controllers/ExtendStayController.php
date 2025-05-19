<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ExtendStayController extends Controller
{
    public function index()
    {
        $currentBooking = Booking::where('user_id', Auth::id())
            ->whereIn('status', ['checked_in', 'confirmed'])
            ->where('check_in_date', '<=', now())
            ->where('check_out_date', '>=', now())
            ->first();

        return view('bookings.extend-stay', compact('currentBooking'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'additional_nights' => 'required|integer|min:1|max:30',
        ]);

        $booking = Booking::findOrFail($request->booking_id);
        
        // Fix: Cast additional_nights to int and use copy() on check_out_date
        $additionalNights = (int) $request->additional_nights;
        $newCheckOutDate = $booking->check_out_date->copy()->addDays($additionalNights);
        
        // Check for conflicting bookings
        $conflictingBookings = Booking::where('room_id', $booking->room_id)
            ->where('id', '!=', $booking->id)
            ->where('check_in_date', '<', $newCheckOutDate)
            ->where('check_out_date', '>', $booking->check_out_date)
            ->exists();

        if ($conflictingBookings) {
            return back()->with('error', 'Room is not available for the requested extension period.');
        }

        // Calculate additional cost
        $additionalCost = $booking->room->price_per_night * $additionalNights;
        
        // Update booking
        $booking->update([
            'check_out_date' => $newCheckOutDate,
            'total_amount' => $booking->total_amount + $additionalCost
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Stay extended successfully! New check-out date: ' . $newCheckOutDate->format('M d, Y'));
    }
} 