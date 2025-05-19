<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    public function show(Room $room)
    {
        return view('rooms.show', compact('room'));
    }

    public function bookingForm(Room $room)
    {
        if (!auth()->check()) {
            // Store room info in session for after login
            session(['intended_room_booking' => $room->id]);
            
            // If it's an AJAX request, return JSON response
            if (request()->ajax() || request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please log in to continue with your booking.',
                    'login_required' => true
                ]);
            }
            
            // If there's a referer header, the user likely clicked a link on our site
            // Add a session message to inform that the login modal should appear after redirect
            if (request()->headers->has('referer')) {
                session()->flash('show_login_modal', true);
                session()->flash('message', 'Please log in to continue with your booking.');
            }
            
            // For regular requests with no referer, redirect to login page
            return redirect()->route('login')
                ->with('message', 'Please log in to continue with your booking.');
        }

        $services = Service::where('is_available', true)->get();
        return view('rooms.booking', compact('room', 'services'));
    }

    public function processBooking(Request $request, Room $room)
    {
        // More detailed debugging
        \Log::info('Form submitted - processBooking called', [
            'room_id' => $room->id,
            'room_number' => $room->room_number,
            'user_id' => auth()->id(),
            'user_email' => auth()->user()->email,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'form_data' => $request->all(),
            'url' => $request->fullUrl()
        ]);
        
        try {
            $request->validate([
                'check_in' => 'required|date|after:today',
                'check_out' => 'required|date|after:check_in',
                'guests' => 'required|integer|min:1|max:' . $room->capacity,
                'special_requests' => 'nullable|string|max:500',
                'services' => 'nullable|array',
                'services.*' => 'exists:services,id',
                'service_quantity' => 'nullable|array',
                'service_quantity.*' => 'integer|min:1|max:5',
                'service_time' => 'nullable|array',
                'service_time.*' => 'string',
                'service_date' => 'nullable|array',
                'service_date.*' => 'date|after_or_equal:check_in|before_or_equal:check_out'
            ]);

            // Check if room is available for these dates
            $conflictingBooking = Booking::where('room_id', $room->id)
                ->where(function($query) use ($request) {
                    $query->whereBetween('check_in_date', [$request->check_in, $request->check_out])
                        ->orWhereBetween('check_out_date', [$request->check_in, $request->check_out])
                        ->orWhere(function($q) use ($request) {
                            $q->where('check_in_date', '<=', $request->check_in)
                              ->where('check_out_date', '>=', $request->check_out);
                        });
                })->first();

            if ($conflictingBooking) {
                $message = 'Room is not available for these dates. ';
                $message .= 'The room is already booked from ' . 
                    $conflictingBooking->check_in_date->format('M d, Y') . 
                    ' to ' . 
                    $conflictingBooking->check_out_date->format('M d, Y');
                
                \Log::warning('Booking failed - date conflict', [
                    'room_id' => $room->id,
                    'conflicting_booking_id' => $conflictingBooking->id
                ]);
                
                return back()->withErrors(['message' => $message])->withInput();
            }

            // Calculate total nights and room price
            $checkIn = \Carbon\Carbon::parse($request->check_in);
            $checkOut = \Carbon\Carbon::parse($request->check_out);
            $nights = $checkIn->diffInDays($checkOut);
            
            if ($nights < 1) {
                return back()->withErrors(['message' => 'Minimum stay is 1 night'])->withInput();
            }

            // Calculate room total
            $roomTotal = $room->price_per_night * $nights;

            // Calculate services total
            $servicesTotal = 0;
            $selectedServices = [];
            
            if ($request->has('services')) {
                $services = Service::whereIn('id', $request->services)->get();
                foreach ($services as $service) {
                    $quantity = (int) $request->input("service_quantity.{$service->id}", 1);
                    
                    // For services that might need to be multiplied by nights (like breakfast)
                    $serviceTotal = $service->price * $quantity;
                    if ($service->category === 'dining' && $service->name === 'In-Room Breakfast') {
                        $serviceTotal *= $nights; // Multiply by number of nights for breakfast
                    }
                    
                    $selectedServices[] = [
                        'service_id' => $service->id,
                        'quantity' => $quantity,
                        'price' => $serviceTotal
                    ];
                    
                    $servicesTotal += $serviceTotal;
                }
            }

            // Calculate final total
            $totalPrice = $roomTotal + $servicesTotal;

            // Create booking
            $booking = Booking::create([
                'user_id' => Auth::id(),
                'room_id' => $room->id,
                'check_in_date' => $request->check_in,
                'check_out_date' => $request->check_out,
                'guests' => $request->guests,
                'special_requests' => $request->special_requests,
                'total_amount' => $totalPrice,
                'status' => 'pending'
            ]);

            // Attach services to booking
            foreach ($selectedServices as $service) {
                // Get the selected time or default to noon
                $serviceTime = $request->input("service_time.{$service['service_id']}", '12:00:00');
                // Get the selected date or default to check-in date
                $serviceDate = $request->input("service_date.{$service['service_id']}", $checkIn->format('Y-m-d'));
                // Combine date with selected time
                $scheduledAt = $serviceDate . ' ' . $serviceTime;
                
                $booking->services()->attach($service['service_id'], [
                    'quantity' => $service['quantity'],
                    'scheduled_at' => $scheduledAt,
                    'notes' => null
                ]);
            }

            // Log successful booking
            \Log::info('Booking created successfully', [
                'booking_id' => $booking->id,
                'room_id' => $room->id,
                'user_id' => Auth::id(),
                'total_amount' => $totalPrice
            ]);

            // Redirect directly to dashboard instead of confirmation page
            return redirect()->route('dashboard')
                ->with('success', 'Your booking has been submitted successfully!');
        } catch (\Exception $e) {
            \Log::error('Exception in processBooking', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->withErrors(['message' => 'An error occurred while processing your booking: ' . $e->getMessage()])->withInput();
        }
    }

    public function confirmation(Booking $booking)
    {
        // Make sure the user can only see their own booking confirmation
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('bookings.confirmation', compact('booking'));
    }
} 