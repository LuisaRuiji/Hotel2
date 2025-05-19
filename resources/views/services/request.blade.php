@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Request Additional Services</h4>
                </div>
                <div class="card-body">
                    @if(!$currentBooking)
                        <div class="alert alert-warning">
                            You need to have an active booking to request additional services.
                        </div>
                    @else
                        <form action="{{ route('customer.service-request.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="booking_id" value="{{ $currentBooking->id }}">
                            
                            <div class="mb-4">
                                <h5>Current Stay Details</h5>
                                <p class="mb-1">Room: {{ $currentBooking->room->type }} - {{ $currentBooking->room->room_number }}</p>
                                <p class="mb-1">Check-in: {{ $currentBooking->check_in_date->format('M d, Y') }}</p>
                                <p>Check-out: {{ $currentBooking->check_out_date->format('M d, Y') }}</p>
                            </div>

                            <div class="mb-4">
                                <h5>Available Services</h5>
                                @foreach($services as $service)
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-md-6">
                                                <h6 class="mb-1">{{ $service->name }}</h6>
                                                <p class="small text-muted mb-0">{{ $service->description }}</p>
                                                <p class="mb-0">Price: ₱{{ number_format($service->price, 2) }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check d-flex align-items-center">
                                                    <input class="form-check-input" type="checkbox" 
                                                           name="services[]" 
                                                           value="{{ $service->id }}" 
                                                           id="service{{ $service->id }}">
                                                    <label class="form-check-label ms-2" for="service{{ $service->id }}">
                                                        Quantity: 
                                                        <input type="number" 
                                                               name="quantities[]" 
                                                               class="form-control form-control-sm d-inline-block w-auto ms-2" 
                                                               value="1" 
                                                               min="1">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Submit Request</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 