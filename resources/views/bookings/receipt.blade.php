@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 fw-bold">Booking Receipt</h4>
                        <button class="btn btn-sm btn-outline-secondary" onclick="window.print()">
                            <i class="fas fa-print me-1"></i> Print
                        </button>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <h5 class="fw-bold mb-1">Hotel Management</h5>
                        <p class="text-muted mb-0">123 Luxury Avenue, City Center</p>
                        <p class="text-muted">Phone: +1 234 567 8900</p>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold">Guest Information</h6>
                            <p class="mb-1">{{ $booking->user->name }}</p>
                            <p class="mb-1">{{ $booking->user->email }}</p>
                            <p class="mb-0">Booking #{{ $booking->id }}</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <h6 class="fw-bold">Booking Details</h6>
                            <p class="mb-1">Status: <span class="badge {{ $booking->status === 'completed' ? 'bg-success' : 'bg-info' }}">{{ ucfirst($booking->status) }}</span></p>
                            <p class="mb-1">Booked on: {{ $booking->created_at->format('M d, Y') }}</p>
                            <p class="mb-0">Receipt #{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</p>
                        </div>
                    </div>
                    
                    <div class="border-top border-bottom py-3 mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="fw-bold">Room Information</h6>
                                <p class="mb-1">Room {{ $booking->room->room_number }} - {{ $booking->room->type }}</p>
                                <p class="mb-0">{{ $booking->guests }} Guest(s)</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold">Stay Duration</h6>
                                <p class="mb-1">Check-in: {{ $booking->check_in_date->format('M d, Y') }}</p>
                                <p class="mb-0">Check-out: {{ $booking->check_out_date->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <h6 class="fw-bold mb-3">Charges</h6>
                    <div class="table-responsive mb-4">
                        <table class="table table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Description</th>
                                    <th class="text-end">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $nights = $booking->check_in_date->diffInDays($booking->check_out_date);
                                    $roomCharge = $booking->room->price_per_night * $nights;
                                    $servicesTotal = 0;
                                @endphp
                                <tr>
                                    <td>Room Charge ({{ $nights }} night(s) @ ₱{{ number_format($booking->room->price_per_night, 2) }})</td>
                                    <td class="text-end">₱{{ number_format($roomCharge, 2) }}</td>
                                </tr>
                                
                                @if($booking->services->count() > 0)
                                    @foreach($booking->services as $service)
                                        @php
                                            $serviceTotal = $service->pivot->quantity * $service->price;
                                            $servicesTotal += $serviceTotal;
                                        @endphp
                                        <tr>
                                            <td>{{ $service->name }} ({{ $service->pivot->quantity }} x ₱{{ number_format($service->price, 2) }})</td>
                                            <td class="text-end">₱{{ number_format($serviceTotal, 2) }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                
                                @php
                                    $taxRate = 0.12; // 12% tax
                                    $subtotal = $roomCharge + $servicesTotal;
                                    $tax = $subtotal * $taxRate;
                                    $total = $subtotal + $tax;
                                @endphp
                                
                                <tr>
                                    <td>Subtotal</td>
                                    <td class="text-end">₱{{ number_format($subtotal, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Tax (12%)</td>
                                    <td class="text-end">₱{{ number_format($tax, 2) }}</td>
                                </tr>
                                <tr class="fw-bold">
                                    <td>Total</td>
                                    <td class="text-end">₱{{ number_format($total, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="text-center mb-4">
                        <h6 class="fw-bold">Payment Information</h6>
                        <p class="mb-1">Payment Method: Credit Card</p>
                        <p class="mb-1">Payment Status: <span class="badge bg-success">Paid</span></p>
                        <p class="mb-0">Payment Date: {{ $booking->updated_at->format('M d, Y') }}</p>
                    </div>
                    
                    <div class="border-top pt-3 text-center">
                        <p class="mb-0">Thank you for choosing Hotel Management!</p>
                        <p class="text-muted small mb-0">For any inquiries or assistance, please contact our front desk.</p>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .card, .card * {
            visibility: visible;
        }
        .card {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        
        .btn {
            display: none;
        }
    }
</style>
@endpush
@endsection 