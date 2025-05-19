<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class ServiceRequestController extends Controller
{
    /**
     * Display the service request form
     */
    public function index()
    {
        // Get the current active booking for the logged-in user
        $activeBooking = Booking::where('user_id', Auth::id())
            ->whereIn('status', ['checked_in', 'approved', 'pending'])
            ->orderBy('check_in_date', 'asc')
            ->first();
            
        // Get all available services
        $services = Service::where('is_available', true)->get();
        
        return view('customer.service-request', compact('activeBooking', 'services'));
    }
    
    /**
     * Store a new service request
     */
    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'service_id' => 'required|exists:services,id',
            'requested_date' => 'required|date|after_or_equal:today',
            'requested_time' => 'required',
            'notes' => 'nullable|string|max:255',
        ]);
        
        // Verify this booking belongs to the current user
        $booking = Booking::findOrFail($request->booking_id);
        if ($booking->user_id !== Auth::id()) {
            return back()->withErrors(['booking_id' => 'Invalid booking selected.']);
        }
        
        // Create the service request
        $serviceRequest = ServiceRequest::create([
            'user_id' => Auth::id(),
            'booking_id' => $request->booking_id,
            'service_id' => $request->service_id,
            'requested_date' => $request->requested_date,
            'requested_time' => $request->requested_time,
            'notes' => $request->notes,
            'status' => 'pending'
        ]);
        
        // Add the service price to the booking's total_amount
        $service = Service::find($request->service_id);
        if ($service) {
            $booking->total_amount += $service->price;
            $booking->save();
        }
        
        return redirect()->route('dashboard')
            ->with('success', 'Your service request has been submitted and the amount has been updated.');
    }
} 