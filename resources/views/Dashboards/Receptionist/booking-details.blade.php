@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header with Back Button -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h4 mb-0">Booking Details</h2>
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>

            <!-- Booking Status Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Booking #{{ $booking->id }}</h5>
                        <span class="badge bg-{{ 
                            $booking->status === 'pending' ? 'warning' : 
                            ($booking->status === 'approved' ? 'success' : 
                            ($booking->status === 'checked_in' ? 'info' : 
                            ($booking->status === 'completed' ? 'success' : 'danger'))) 
                        }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <!-- Guest Information -->
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">Guest Information</h6>
                            <p class="mb-2"><strong>Name:</strong> {{ $booking->user->name }}</p>
                            <p class="mb-2"><strong>Email:</strong> {{ $booking->user->email }}</p>
                            <p class="mb-2"><strong>Phone:</strong> {{ $booking->user->phone ?? 'Not provided' }}</p>
                            <p class="mb-0"><strong>Number of Guests:</strong> {{ $booking->guests }}</p>
                        </div>

                        <!-- Room Information -->
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">Room Information</h6>
                            <p class="mb-2"><strong>Room Number:</strong> {{ $booking->room->room_number }}</p>
                            <p class="mb-2"><strong>Room Type:</strong> {{ $booking->room->type }}</p>
                            <p class="mb-2"><strong>Floor:</strong> {{ $booking->room->floor }}</p>
                            <p class="mb-0"><strong>Rate:</strong> ₱{{ number_format($booking->room->price_per_night, 2) }}/night</p>
                        </div>

                        <!-- Booking Details -->
                        <div class="col-12">
                            <hr>
                            <h6 class="text-muted mb-3">Booking Details</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-2"><strong>Check-in Date:</strong> {{ $booking->check_in_date->format('M d, Y') }}</p>
                                    <p class="mb-2"><strong>Check-out Date:</strong> {{ $booking->check_out_date->format('M d, Y') }}</p>
                                    <p class="mb-2"><strong>Length of Stay:</strong> {{ $booking->check_in_date->diffInDays($booking->check_out_date) }} nights</p>
                                    <p class="mb-0"><strong>Total Amount:</strong> ₱{{ number_format($booking->total_amount, 2) }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2"><strong>Booking Date:</strong> {{ $booking->created_at->format('M d, Y h:i A') }}</p>
                                    @if($booking->checked_in_at)
                                    <p class="mb-2"><strong>Checked in:</strong> {{ $booking->checked_in_at->format('M d, Y h:i A') }}</p>
                                    @endif
                                    @if($booking->checked_out_at)
                                    <p class="mb-2"><strong>Checked out:</strong> {{ $booking->checked_out_at->format('M d, Y h:i A') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Special Requests -->
                        @if($booking->special_requests)
                        <div class="col-12">
                            <hr>
                            <h6 class="text-muted mb-3">Special Requests</h6>
                            <p class="mb-0">{{ $booking->special_requests }}</p>
                        </div>
                        @endif

                        <!-- Additional Services -->
                        @if($booking->services->count() > 0)
                        <div class="col-12">
                            <hr>
                            <h6 class="text-muted mb-3">Additional Services</h6>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Service</th>
                                            <th>Quantity</th>
                                            <th>Scheduled For</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($booking->services as $service)
                                        <tr>
                                            <td>{{ $service->name }}</td>
                                            <td>{{ $service->pivot->quantity }}</td>
                                            <td>{{ $service->pivot->scheduled_at ? Carbon\Carbon::parse($service->pivot->scheduled_at)->format('M d, Y h:i A') : 'Not scheduled' }}</td>
                                            <td>{{ $service->pivot->notes ?? '-' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif

                        <!-- Service Requests -->
                        @php
                            $serviceRequests = App\Models\ServiceRequest::where('booking_id', $booking->id)->get();
                        @endphp
                        @if($serviceRequests->count() > 0)
                        <div class="col-12">
                            <hr>
                            <h6 class="text-muted mb-3">Service Requests During Stay</h6>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Service</th>
                                            <th>Requested Date</th>
                                            <th>Requested Time</th>
                                            <th>Status</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($serviceRequests as $request)
                                        <tr>
                                            <td>{{ $request->service->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($request->requested_date)->format('M d, Y') }}</td>
                                            <td>{{ $request->requested_time }}</td>
                                            <td>
                                                <span class="badge bg-{{ $request->status === 'completed' ? 'success' : ($request->status === 'pending' ? 'warning' : 'info') }}">
                                                    {{ ucfirst($request->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $request->notes ?? '-' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="col-12">
                            <hr>
                            <div class="d-flex gap-2">
                                @if($booking->status === 'pending')
                                <form action="{{ route('receptionist.bookings.approve', $booking->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-check"></i> Approve Booking
                                    </button>
                                </form>
                                <form action="{{ route('receptionist.bookings.reject', $booking->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-times"></i> Reject Booking
                                    </button>
                                </form>
                                @endif

                                @if($booking->status === 'approved' && $booking->check_in_date->isToday())
                                <form action="{{ route('receptionist.process-checkin') }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-sign-in-alt"></i> Process Check-in
                                    </button>
                                </form>
                                @endif

                                @if($booking->status === 'checked_in' && $booking->check_out_date->isToday())
                                <form action="{{ route('receptionist.process-checkout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                                    <button type="submit" class="btn btn-info">
                                        <i class="fas fa-sign-out-alt"></i> Process Check-out
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 