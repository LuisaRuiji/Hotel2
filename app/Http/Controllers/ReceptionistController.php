<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReceptionistController extends Controller
{
    public function dashboard()
    {
        // Get today's date
        $today = now()->format('Y-m-d');

        // Get today's check-ins
        $todayCheckins = Booking::whereDate('check_in_date', $today)
            ->where('status', 'pending')
            ->count();

        // Get today's check-outs - include both scheduled and actual checkouts
        $todayCheckouts = Booking::where(function($query) use ($today) {
            // Include bookings with scheduled checkout today
            $query->whereDate('check_out_date', $today)
                  ->whereIn('status', ['checked_in', 'completed']);
        })
        ->orWhere(function($query) use ($today) {
            // Include bookings actually checked out today
            $query->whereDate('checked_out_at', $today)
                  ->where('status', 'completed');
        })
        ->distinct()
        ->count();

        // Get room counts by status
        $availableRooms = Room::where('status', Room::STATUS_AVAILABLE)->count();
        $occupiedRooms = Room::where('status', Room::STATUS_OCCUPIED)->count();
        $reservedRooms = Room::where('status', Room::STATUS_RESERVED)->count();
        $maintenanceRooms = Room::whereIn('status', [Room::STATUS_CLEANING, Room::STATUS_MAINTENANCE])->count();

        // Get pending reservations
        $pendingReservations = Booking::where('status', 'pending')
            ->with(['user', 'room'])
            ->orderBy('check_in_date')
            ->get();

        // Get today's schedule
        $todaySchedule = Booking::where(function ($query) use ($today) {
            $query->whereDate('check_in_date', $today)
                ->orWhereDate('check_out_date', $today);
        })
            ->whereNotIn('status', ['cancelled'])
            ->with(['user', 'room'])
            ->get()
            ->map(function ($booking) {
                $isCheckIn = Carbon::parse($booking->check_in_date)->format('Y-m-d') === now()->format('Y-m-d');
                return (object) [
                    'time' => $isCheckIn
                        ? Carbon::parse($booking->check_in_date)->format('H:i')
                        : Carbon::parse($booking->check_out_date)->format('H:i'),
                    'guest_name' => $booking->user->name ?? 'Guest',
                    'room_number' => $booking->room->room_number ?? 'N/A',
                    'action' => $isCheckIn ? 'Check-in' : 'Check-out',
                    'status' => $booking->status,
                    'booking_id' => $booking->id
                ];
            })
            ->sortBy('time');

        // Get recent notifications (you can customize this based on your needs)
        $notifications = collect(); // Empty collection for now

        return view('Dashboards.Receptionist.dashboard', compact(
            'todayCheckins',
            'todayCheckouts',
            'availableRooms',
            'occupiedRooms',
            'reservedRooms',
            'maintenanceRooms',
            'todaySchedule',
            'notifications',
            'pendingReservations'
        ));
    }

    public function checkin()
    {
        // Get all approved bookings that are ready for check-in
        $pendingCheckins = Booking::where('status', 'approved')
            ->whereDate('check_in_date', '<=', now())
            ->with(['user', 'room'])
            ->orderBy('check_in_date')
            ->get();

        // New: Future approved reservations
        $futureApproved = Booking::where('status', 'approved')
            ->whereDate('check_in_date', '>', now())
            ->with(['user', 'room'])
            ->orderBy('check_in_date')
            ->get();

        return view('Dashboards.Receptionist.checkin', compact('pendingCheckins', 'futureApproved'));
    }

    public function processCheckin(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'id_verified' => 'required|accepted',
            'notes' => 'nullable|string'
        ]);

        DB::beginTransaction();
        try {
            $booking = Booking::findOrFail($request->booking_id);

            // Check if the room is still available
            $room = Room::findOrFail($booking->room_id);
            if ($room->status !== Room::STATUS_RESERVED) {
                throw new \Exception('Room is not reserved for check-in.');
            }

            // Update booking status
            $booking->update([
                'status' => 'checked_in',
                'notes' => $request->notes,
                'checked_in_at' => now(),
                'checked_in_by' => auth()->id()
            ]);

            // Update room status to occupied
            $room->update(['status' => Room::STATUS_OCCUPIED]);

            DB::commit();

            return redirect()->route('receptionist.checkin')
                ->with('success', 'Guest has been successfully checked in.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', 'Failed to process check-in: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function checkout()
    {
        // Get all checked-in bookings
        $activeBookings = Booking::where('status', 'checked_in')
            ->with(['user', 'room'])
            ->orderBy('check_out_date')
            ->get();

        return view('Dashboards.Receptionist.checkout', compact('activeBookings'));
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'additional_charges' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'room_inspected' => 'required|accepted'
        ]);

        DB::beginTransaction();
        try {
            $booking = Booking::with('room')->findOrFail($request->booking_id);

            // Verify booking status
            if ($booking->status !== 'checked_in') {
                throw new \Exception('Booking must be checked in to process check-out.');
            }

            // Calculate final amount including additional charges
            $finalAmount = $booking->total_amount + ($request->additional_charges ?? 0);

            // Update booking status
            $booking->update([
                'status' => 'completed',
                'checked_out_at' => now(),
                'checked_out_by' => auth()->id(),
                'notes' => $request->notes,
                'final_amount' => $finalAmount
            ]);

            // Update room status to cleaning
            $booking->room->update(['status' => Room::STATUS_CLEANING]);

            DB::commit();

            return redirect()->route('receptionist.dashboard')
                ->with('success', 'Guest has been successfully checked out.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to process check-out: ' . $e->getMessage());
        }
    }

    public function viewBooking($id)
    {
        $booking = Booking::with(['user', 'room'])->findOrFail($id);
        return view('Dashboards.Receptionist.booking-details', compact('booking'));
    }

    public function rooms()
    {
        // Get all rooms with their current bookings
        $rooms = Room::with(['currentBooking.user'])
            ->orderBy('room_number')
            ->paginate(10);

        // Get room counts by status
        $availableRooms = Room::where('status', Room::STATUS_AVAILABLE)->count();
        $occupiedRooms = Room::where('status', Room::STATUS_OCCUPIED)->count();
        $reservedRooms = Room::where('status', Room::STATUS_RESERVED)->count();
        $cleaningRooms = Room::whereIn('status', [Room::STATUS_CLEANING, Room::STATUS_MAINTENANCE])->count();

        return view('Dashboards.Receptionist.rooms', compact(
            'rooms',
            'availableRooms',
            'occupiedRooms',
            'reservedRooms',
            'cleaningRooms'
        ));
    }

    public function createBooking()
    {
        return view('Dashboards.Receptionist.create-booking');
    }

    public function approveBooking($id)
    {
        try {
            $booking = Booking::findOrFail($id);

            // Check if the room is still available
            $room = Room::findOrFail($booking->room_id);
            if (!$room->is_available) {
                return back()->with('error', 'Room is no longer available.');
            }

            // Redirect to payment processing
            return redirect()->route('receptionist.bookings.payment', $booking->id);

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to process booking: ' . $e->getMessage());
        }
    }

    public function showPayment($id)
    {
        $booking = Booking::with(['user', 'room'])->findOrFail($id);
        return view('Dashboards.Receptionist.process-payment', compact('booking'));
    }

    public function processPayment(Request $request, $id)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,credit_card',
            'discount_type' => 'nullable|in:senior,pwd',
            'discount_id' => 'required_with:discount_type',
            'card_number' => 'required_if:payment_method,credit_card',
            'card_expiry' => 'required_if:payment_method,credit_card',
            'card_cvv' => 'required_if:payment_method,credit_card',
            'card_holder' => 'required_if:payment_method,credit_card',
        ]);

        DB::beginTransaction();
        try {
            $booking = Booking::findOrFail($id);

            // Calculate final amount with discount
            $finalAmount = $booking->total_amount;
            if ($request->discount_type) {
                $discountAmount = $finalAmount * 0.20; // 20% discount
                $finalAmount -= $discountAmount;
            }

            $transaction_id_global = 'TXN' . time() . rand(1000, 9999);

            // Create payment record
            $payment = Payment::create([
                'booking_id' => $booking->id,
                'amount' => $finalAmount,
                'payment_method' => $request->payment_method,
                'status' => 'completed',
                'transaction_id' => $transaction_id_global,
                'card_type' => $request->payment_method === 'credit_card' ? $this->detectCardType($request->card_number) : null,
                'card_last_four' => $request->payment_method === 'credit_card' ? substr($request->card_number, -4) : null,
                'card_expiry' => $request->payment_method === 'credit_card' ? $request->card_expiry : null,
                'notes' => $request->discount_type ? "Applied {$request->discount_type} discount" : null
            ]);

            $transaction = Transaction::create([
                'invoice_number' => $payment->transaction_id,
                'booking_id' => $booking->id,
                'user_id' => $booking->user->id,
                'payment_method' => $payment->payment_method,
                'amount' => $finalAmount,
                'description' => "Payment for booking #{$booking->id}",
                'guest_name' => $booking->user->name,
                'room_number' => $booking->room->room_number,
                'reference_number' => $transaction_id_global,
                'status' => 'completed',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Update booking status and payment details
            $booking->update([
                'status' => 'approved',
                'payment_method' => $request->payment_method,
                'payment_amount' => $finalAmount,
                'discount_type' => $request->discount_type,
                'discount_id' => $request->discount_id,
                'payment_date' => now(),
                'approved_at' => now(),
                'approved_by' => auth()->id(),
                'card_last_four' => $request->payment_method === 'credit_card' ? substr($request->card_number, -4) : null
            ]);

            // Update room status
            $room = Room::findOrFail($booking->room_id);
            $room->updateStatusFromBooking('approved');

            DB::commit();

            return redirect()->route('receptionist.dashboard')
                ->with('success', 'Payment processed successfully. Booking has been approved.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', 'Failed to process payment: ' . $e->getMessage())
                ->withInput();
        }
    }

    private function detectCardType($cardNumber)
    {
        $cardNumber = preg_replace('/\D/', '', $cardNumber);

        if (preg_match('/^4/', $cardNumber)) {
            return 'Visa';
        } elseif (preg_match('/^5[1-5]/', $cardNumber)) {
            return 'Mastercard';
        } elseif (preg_match('/^3[47]/', $cardNumber)) {
            return 'American Express';
        } else {
            return 'Unknown';
        }
    }

    public function rejectBooking($id)
    {
        try {
            $booking = Booking::findOrFail($id);

            // Update booking status
            $booking->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
                'cancelled_by' => auth()->id()
            ]);

            return back()->with('success', 'Reservation has been rejected successfully.');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to reject reservation: ' . $e->getMessage());
        }
    }

    public function updateRoomStatus($id, Request $request)
    {
        try {
            $room = Room::findOrFail($id);
            $newStatus = $request->status;

            // Validate the status
            if (
                !in_array($newStatus, [
                    Room::STATUS_AVAILABLE,
                    Room::STATUS_CLEANING,
                    Room::STATUS_RESERVED,
                    Room::STATUS_OCCUPIED
                ])
            ) {
                return back()->with('error', 'Invalid room status');
            }

            $room->status = $newStatus;
            $room->save();

            return back()->with('success', "Room {$room->room_number} status has been updated to " . ucfirst($newStatus));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update room status: ' . $e->getMessage());
        }
    }
}