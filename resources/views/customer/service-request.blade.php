@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0 fw-bold">Request Service</h2>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Back to Dashboard
                </a>
            </div>
            
            @if(!$activeBooking)
                <div class="alert alert-warning">
                    <h5 class="alert-heading">No Active Booking Found</h5>
                    <p>You need to have an active booking to request services.</p>
                    <hr>
                    <p class="mb-0">Please book a room first or contact the reception for assistance.</p>
                </div>
            @else
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Active Booking Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Room:</strong> {{ $activeBooking->room->room_number }}</p>
                                <p><strong>Check-in:</strong> {{ $activeBooking->check_in_date->format('M d, Y') }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Room Type:</strong> {{ $activeBooking->room->type }}</p>
                                <p><strong>Check-out:</strong> {{ $activeBooking->check_out_date->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">New Service Request</h5>
                    </div>
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger mb-4">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <form action="{{ route('customer.service-request.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="booking_id" value="{{ $activeBooking->id }}">
                            
                            <div class="mb-3">
                                <label for="service_id" class="form-label">Select Service</label>
                                <select class="form-select @error('service_id') is-invalid @enderror" id="service_id" name="service_id" required>
                                    <option value="">-- Select a service --</option>
                                    @foreach($services->groupBy('category') as $category => $categoryServices)
                                        <optgroup label="{{ App\Models\Service::CATEGORIES[$category] }}">
                                            @foreach($categoryServices as $service)
                                                <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                                    {{ $service->name }} (₱{{ number_format($service->price, 2) }})
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                                @error('service_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="requested_date" class="form-label">Date</label>
                                        <input type="date" class="form-control @error('requested_date') is-invalid @enderror" 
                                               id="requested_date" name="requested_date" 
                                               min="{{ date('Y-m-d') }}" 
                                               max="{{ $activeBooking->check_out_date->format('Y-m-d') }}" 
                                               value="{{ old('requested_date', date('Y-m-d')) }}" required>
                                        @error('requested_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="requested_time" class="form-label">Time</label>
                                        <select class="form-select @error('requested_time') is-invalid @enderror" 
                                                id="requested_time" name="requested_time" required>
                                            <option value="">-- Select a time --</option>
                                            <option value="08:00 AM" {{ old('requested_time') == '08:00 AM' ? 'selected' : '' }}>08:00 AM</option>
                                            <option value="09:00 AM" {{ old('requested_time') == '09:00 AM' ? 'selected' : '' }}>09:00 AM</option>
                                            <option value="10:00 AM" {{ old('requested_time') == '10:00 AM' ? 'selected' : '' }}>10:00 AM</option>
                                            <option value="11:00 AM" {{ old('requested_time') == '11:00 AM' ? 'selected' : '' }}>11:00 AM</option>
                                            <option value="12:00 PM" {{ old('requested_time') == '12:00 PM' ? 'selected' : '' }}>12:00 PM</option>
                                            <option value="01:00 PM" {{ old('requested_time') == '01:00 PM' ? 'selected' : '' }}>01:00 PM</option>
                                            <option value="02:00 PM" {{ old('requested_time') == '02:00 PM' ? 'selected' : '' }}>02:00 PM</option>
                                            <option value="03:00 PM" {{ old('requested_time') == '03:00 PM' ? 'selected' : '' }}>03:00 PM</option>
                                            <option value="04:00 PM" {{ old('requested_time') == '04:00 PM' ? 'selected' : '' }}>04:00 PM</option>
                                            <option value="05:00 PM" {{ old('requested_time') == '05:00 PM' ? 'selected' : '' }}>05:00 PM</option>
                                        </select>
                                        @error('requested_time')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label for="notes" class="form-label">Special Instructions (Optional)</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" 
                                          id="notes" name="notes" rows="3" 
                                          placeholder="Any specific requirements or instructions...">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Submit Request</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 