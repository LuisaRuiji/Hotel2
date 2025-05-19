@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Extend Your Stay</h4>
                </div>
                <div class="card-body">
                    @if(!$currentBooking)
                        <div class="alert alert-warning">
                            You don't have an active booking to extend.
                        </div>
                    @else
                        <form action="{{ route('customer.extend-stay.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="booking_id" value="{{ $currentBooking->id }}">
                            
                            <div class="mb-4">
                                <h5>Current Stay Details</h5>
                                <p class="mb-1">Room: {{ $currentBooking->room->type }} - {{ $currentBooking->room->room_number }}</p>
                                <p class="mb-1">Current Check-in: {{ $currentBooking->check_in_date->format('M d, Y') }}</p>
                                <p>Current Check-out: {{ $currentBooking->check_out_date->format('M d, Y') }}</p>
                            </div>

                            <div class="mb-4">
                                <label for="additional_nights" class="form-label">Number of Additional Nights</label>
                                <div class="input-group">
                                    <input type="number" 
                                           class="form-control @error('additional_nights') is-invalid @enderror" 
                                           id="additional_nights" 
                                           name="additional_nights" 
                                           value="{{ old('additional_nights', 1) }}"
                                           min="1"
                                           max="30">
                                    <span class="input-group-text">nights</span>
                                </div>
                                @error('additional_nights')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Rate per night: ₱{{ number_format($currentBooking->room->price_per_night, 2) }}
                                </div>
                            </div>

                            <div class="form-text" id="extendTotalFee">
                                Total extension fee: ₱{{ number_format($currentBooking->room->price_per_night, 2) }}
                            </div>

                            @if(session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Extend Stay</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const nightsInput = document.getElementById('additional_nights');
    const totalFeeDiv = document.getElementById('extendTotalFee');
    const ratePerNight = {{ $currentBooking->room->price_per_night }};

    function updateTotalFee() {
        let nights = parseInt(nightsInput.value) || 1;
        let total = nights * ratePerNight;
        totalFeeDiv.textContent = `Total extension fee: ₱${total.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
    }

    nightsInput.addEventListener('input', updateTotalFee);
    updateTotalFee();
});
</script>
@endsection 