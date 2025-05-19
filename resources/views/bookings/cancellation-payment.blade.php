@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Cancellation Fee Payment</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info mb-4">
                        <p class="mb-0">To complete your booking cancellation, please pay the cancellation fee of 
                            <strong>₱{{ number_format($cancellationFee, 2) }}</strong> for Room {{ $booking->room->room_number }}.
                        </p>
                    </div>

                    <form action="{{ route('customer.booking.cancel.payment.process') }}" method="POST">
                        @csrf
                        <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                        <input type="hidden" name="cancellation_fee" value="{{ $cancellationFee }}">

                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Payment Details</h6>
                            <div class="credit-card-form p-3 border rounded bg-light">
                                <div class="mb-3">
                                    <label for="card_number" class="form-label">Card Number</label>
                                    <input type="text" class="form-control @error('card_number') is-invalid @enderror" 
                                           id="card_number" name="card_number" placeholder="XXXX XXXX XXXX XXXX" required>
                                    @error('card_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="card_expiry" class="form-label">Expiration Date</label>
                                        <input type="text" class="form-control @error('card_expiry') is-invalid @enderror" 
                                               id="card_expiry" name="card_expiry" placeholder="MM/YY" required>
                                        @error('card_expiry')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="card_cvv" class="form-label">CVV</label>
                                        <input type="text" class="form-control @error('card_cvv') is-invalid @enderror" 
                                               id="card_cvv" name="card_cvv" placeholder="XXX" required>
                                        @error('card_cvv')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="card_name" class="form-label">Cardholder Name</label>
                                    <input type="text" class="form-control @error('card_name') is-invalid @enderror" 
                                           id="card_name" name="card_name" required>
                                    @error('card_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-credit-card me-2"></i>Pay Cancellation Fee & Complete Cancellation
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Add credit card validation here if needed
</script>
@endpush 