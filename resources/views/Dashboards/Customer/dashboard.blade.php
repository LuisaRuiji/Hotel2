@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Success Message -->
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            
            <h2 class="mb-4 fw-bold">Welcome, {{ Auth::user()->name }}</h2>

            <!-- Current Booking Status -->
            @if($currentBooking)
            <div class="card shadow-sm mb-5 border-primary">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <span class="fw-semibold">Current Stay</span>
                    <span class="badge bg-light text-primary">Room {{ $currentBooking->room_number }}</span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="text-muted small">Check-in</div>
                            <div class="fw-semibold">{{ $currentBooking->check_in_date->format('M d, Y') }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-muted small">Check-out</div>
                            <div class="fw-semibold">{{ $currentBooking->check_out_date->format('M d, Y') }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-muted small">Total Amount</div>
                            <div class="fw-semibold text-success">${{ number_format($currentBooking->total_amount, 2) }}</div>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('customer.service-request') }}" class="btn btn-outline-primary">Request Service</a>
                        <a href="{{ route('customer.extend-stay') }}" class="btn btn-primary">Extend Stay</a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Booking History -->
            <div class="mb-5">
                <h3 class="mb-3 fw-semibold">Booking History</h3>
                <div class="card shadow-sm">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Room</th>
                                    <th>Check-in</th>
                                    <th>Check-out</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bookingHistory ?? [] as $booking)
                                <tr>
                                    <td>{{ $booking->room->room_number }}</td>
                                    <td>{{ $booking->check_in_date->format('M d, Y') }}</td>
                                    <td>{{ $booking->check_out_date->format('M d, Y') }}</td>
                                    <td>₱{{ number_format($booking->total_amount, 2) }}</td>
                                    <td>
                                        <span class="badge 
                                            {{ $booking->status === 'completed' ? 'bg-success' : 
                                               ($booking->status === 'pending' ? 'bg-warning' :
                                               ($booking->status === 'checked_in' ? 'bg-info' :
                                               ($booking->status === 'cancelled' ? 'bg-danger' : 'bg-secondary'))) }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($booking->status === 'pending')
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#cancelBookingModal{{ $booking->id }}">
                                                Cancel
                                            </button>
                                            
                                            <!-- Cancel Booking Modal -->
                                            <div class="modal fade" id="cancelBookingModal{{ $booking->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Cancel Booking Confirmation</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to cancel your booking for Room {{ $booking->room->room_number }}?</p>
                                                            
                                                            <div class="alert alert-warning">
                                                                <h6 class="fw-bold">Cancellation Policy:</h6>
                                                                <ul class="mb-0">
                                                                    <li>Cancellations made less than 12 hours before check-in: 50% cancellation fee</li>
                                                                    <li>All other cancellations: 30% cancellation fee</li>
                                                                </ul>
                                                            </div>
                                                            
                                                            @php
                                                                $now = Carbon\Carbon::now();
                                                                // Calculate days between dates first
                                                                $daysUntilCheckin = $now->diffInDays($booking->check_in_date);
                                                                $hoursUntilCheckin = $daysUntilCheckin * 24;
                                                                
                                                                // Determine fee percentage based on hours until check-in
                                                                $cancellationFeePercentage = $hoursUntilCheckin < 12 ? 50 : 30;
                                                                
                                                                $cancellationFeeAmount = ($booking->total_amount * $cancellationFeePercentage) / 100;
                                                            @endphp
                                                            
                                                            <p class="mb-0">
                                                                <strong>Cancellation fee:</strong> 
                                                                ₱{{ number_format($cancellationFeeAmount, 2) }} 
                                                                ({{ $cancellationFeePercentage }}% of ₱{{ number_format($booking->total_amount, 2) }})
                                                            </p>
                                                            
                                                            <div class="small text-muted mt-2">
                                                                <strong>Details:</strong><br>
                                                                Current time: {{ $now->format('M d, Y H:i:s') }}<br>
                                                                Check-in: {{ $booking->check_in_date->format('M d, Y H:i:s') }}<br>
                                                                Hours until check-in: {{ $hoursUntilCheckin }}
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <form action="{{ route('customer.booking.cancel', $booking) }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="cancellation_fee" value="{{ $cancellationFeeAmount }}">
                                                                <button type="submit" class="btn btn-danger">Pay Fee & Confirm Cancellation</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif($booking->status === 'completed' || $booking->status === 'checked_in')
                                            <a href="{{ route('customer.booking.receipt', $booking) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-receipt me-1"></i> Receipt
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">No booking history found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Special Offers -->
            <div>
                <h3 class="mb-3 fw-semibold">Special Offers</h3>
                <div class="row g-4">
                    @forelse($specialOffers ?? [] as $offer)
                    <div class="col-md-6">
                        <div class="card h-100 shadow-sm">
                            <div class="position-relative">
                                <img src="{{ $offer->image_url }}" alt="{{ $offer->title }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                                <span class="position-absolute top-0 end-0 m-2 badge bg-danger">Save {{ $offer->discount }}%</span>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $offer->title }}</h5>
                                <p class="card-text text-muted">{{ $offer->description }}</p>
                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                    <small class="text-muted">Valid until {{ $offer->valid_until->format('M d, Y') }}</small>
                                    <a href="{{ route('customer.book-offer', $offer) }}" class="btn btn-outline-primary btn-sm">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center text-muted py-4">
                        No special offers available at the moment
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 