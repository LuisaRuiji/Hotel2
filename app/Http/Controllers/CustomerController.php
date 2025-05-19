<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CustomerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get current booking (active or upcoming)
        $currentBooking = Booking::where('user_id', $user->id)
            ->where(function($query) {
                $today = Carbon::today();
                $query->where(function($q) use ($today) {
                    $q->where('check_in_date', '<=', $today)
                      ->where('check_out_date', '>=', $today);
                })->orWhere(function($q) use ($today) {
                    $q->where('check_in_date', '>', $today)
                      ->orderBy('check_in_date', 'asc');
                });
            })
            ->first();

        // Get booking history (all bookings)
        $bookingHistory = Booking::where('user_id', $user->id)
            ->with('room')
            ->orderByRaw("FIELD(status, 'pending', 'checked_in', 'completed', 'cancelled') ASC")
            ->orderBy('check_in_date', 'desc')
            ->get();

        // Get available rooms
        $availableRooms = Room::where('is_available', true)
            ->orderBy('price_per_night')
            ->take(3)
            ->get();

        return view('Dashboards.Customer.dashboard', compact('currentBooking', 'bookingHistory', 'availableRooms'));
    }
    
    public function cancelBooking(Request $request, Booking $booking)
    {
        // Check if the booking belongs to the authenticated user
        if ($booking->user_id !== Auth::id()) {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to cancel this booking.');
        }
        
        // Check if the booking is in a cancellable state
        if ($booking->status !== 'pending') {
            return redirect()->route('dashboard')->with('error', 'This booking cannot be cancelled.');
        }
        
        // Calculate cancellation fee based on time until check-in
        $now = Carbon::now();
        $daysUntilCheckin = $now->diffInDays($booking->check_in_date);
        $hoursUntilCheckin = $daysUntilCheckin * 24;
        
        // Determine fee percentage based on hours until check-in
        $cancellationFeePercentage = $hoursUntilCheckin < 12 ? 50 : 30;
        
        $cancellationFeeAmount = ($booking->total_amount * $cancellationFeePercentage) / 100;
        
        // Redirect to payment page if this is the initial submission
        if (!$request->has('payment_confirmed')) {
            // Store cancellation details in session for the payment page
            session([
                'cancellation_booking_id' => $booking->id,
                'cancellation_fee' => $cancellationFeeAmount
            ]);
            
            return redirect()->route('customer.booking.cancel.payment');
        }
        
        // Process has payment confirmation
        
        // Update booking status to cancelled
        $booking->status = 'cancelled';
        $booking->cancellation_date = now();
        $booking->cancellation_fee = $cancellationFeeAmount;
        $booking->payment_method = $request->input('payment_method', 'Credit Card');
        $booking->card_last_four = $request->input('card_last_four', '****');
        $booking->save();
        
        // Make the room available again
        $room = $booking->room;
        if ($room) {
            $room->status = 'Available';
            $room->is_available = true;
            $room->save();
        }
        
        // Notify user about the cancellation and fee
        return redirect()->route('dashboard')->with('success', 'Your booking has been cancelled successfully. Cancellation fee: ₱' . number_format($cancellationFeeAmount, 2));
    }
    
    public function showCancellationPayment()
    {
        // Get cancellation details from session
        $bookingId = session('cancellation_booking_id');
        $cancellationFee = session('cancellation_fee');
        
        if (!$bookingId || !$cancellationFee) {
            return redirect()->route('dashboard')->with('error', 'Invalid cancellation request.');
        }
        
        $booking = Booking::findOrFail($bookingId);
        
        // Check if the booking belongs to the authenticated user
        if ($booking->user_id !== Auth::id()) {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to cancel this booking.');
        }
        
        return view('bookings.cancellation-payment', compact('booking', 'cancellationFee'));
    }
    
    public function processCancellationPayment(Request $request)
    {
        // Validate payment details
        $request->validate([
            'booking_id' => 'required',
            'card_number' => 'required',
            'card_expiry' => 'required',
            'card_cvv' => 'required',
            'cancellation_fee' => 'required'
        ]);
        
        // Process payment here (in a real system)
        // ...
        
        // Get the booking
        $booking = Booking::findOrFail($request->booking_id);
        
        // Clear the session data
        session()->forget(['cancellation_booking_id', 'cancellation_fee']);
        
        // Continue with cancellation with payment confirmed
        $request->merge(['payment_confirmed' => true, 'card_last_four' => substr($request->card_number, -4)]);
        
        return $this->cancelBooking($request, $booking);
    }
    
    public function showReceipt(Booking $booking)
    {
        // Check if the booking belongs to the authenticated user
        if ($booking->user_id !== Auth::id()) {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to view this receipt.');
        }
        
        return view('bookings.receipt', compact('booking'));
    }
} 