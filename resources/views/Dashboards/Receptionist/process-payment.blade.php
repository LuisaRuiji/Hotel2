@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Process Payment</h5>
                        <span class="badge bg-primary">Booking #{{ $booking->id }}</span>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form id="paymentForm" action="{{ route('receptionist.bookings.process-payment', $booking->id) }}" method="POST">
                        @csrf
                        @method('POST')
                        
                        <!-- Booking Summary -->
                        <div class="mb-4">
                            <h6 class="text-muted mb-3">Booking Summary</h6>
                            <div class="bg-light p-3 rounded">
                                <div class="row g-2">
                                    <div class="col-sm-6">
                                        <p class="mb-1"><strong>Guest:</strong> {{ $booking->user->name }}</p>
                                        <p class="mb-1"><strong>Room:</strong> {{ $booking->room->room_number }}</p>
                                        <p class="mb-1"><strong>Check-in:</strong> {{ $booking->check_in_date->format('M d, Y') }}</p>
                                        <p class="mb-0"><strong>Check-out:</strong> {{ $booking->check_out_date->format('M d, Y') }}</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="mb-1"><strong>Room Rate:</strong> ₱{{ number_format($booking->room->price_per_night, 2) }}/night</p>
                                        <p class="mb-1"><strong>Number of Nights:</strong> {{ $booking->check_in_date->diffInDays($booking->check_out_date) }}</p>
                                        <p class="mb-1"><strong>Number of Guests:</strong> {{ $booking->guests }}</p>
                                        <p class="mb-0"><strong>Base Amount:</strong> ₱{{ number_format($booking->total_amount, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Discount Section -->
                        <div class="mb-4">
                            <h6 class="text-muted mb-3">Discount (Optional)</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <select name="discount_type" class="form-select" id="discountType">
                                        <option value="">No Discount</option>
                                        <option value="senior">Senior Citizen (20%)</option>
                                        <option value="pwd">PWD (20%)</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="discount_id" id="discountId" placeholder="ID Number (if applicable)" disabled>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="mb-4">
                            <h6 class="text-muted mb-3">Payment Method</h6>
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="btn-group w-100" role="group">
                                        <input type="radio" class="btn-check" name="payment_method" value="cash" id="cashMethod" checked>
                                        <label class="btn btn-outline-primary" for="cashMethod">
                                            <i class="fas fa-money-bill-wave me-2"></i>Cash
                                        </label>

                                        <input type="radio" class="btn-check" name="payment_method" value="credit_card" id="cardMethod">
                                        <label class="btn btn-outline-primary" for="cardMethod">
                                            <i class="fas fa-credit-card me-2"></i>Credit Card
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Credit Card Details (initially hidden) -->
                        <div id="cardDetails" class="mb-4 d-none">
                            <div class="row g-3">
                                <div class="col-12">
                                    <input type="text" class="form-control" name="card_number" placeholder="Card Number">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="card_expiry" placeholder="MM/YY">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="card_cvv" placeholder="CVV">
                                </div>
                                <div class="col-12">
                                    <input type="text" class="form-control" name="card_holder" placeholder="Card Holder Name">
                                </div>
                            </div>
                        </div>

                        <!-- Payment Summary -->
                        <div class="mb-4">
                            <h6 class="text-muted mb-3">Payment Summary</h6>
                            <div class="bg-light p-3 rounded">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Base Amount:</span>
                                    <span>₱{{ number_format($booking->total_amount, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2" id="discountRow" style="display: none !important;">
                                    <span>Discount (20%):</span>
                                    <span class="text-danger">-₱{{ number_format($booking->total_amount * 0.2, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between fw-bold">
                                    <span>Total Amount:</span>
                                    <span id="finalAmount">₱{{ number_format($booking->total_amount, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-check-circle me-2"></i>Process Payment & Confirm Booking
                            </button>
                            <a href="{{ route('receptionist.dashboard') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('paymentForm');
        const discountType = document.getElementById('discountType');
        const discountId = document.getElementById('discountId');
        const discountRow = document.getElementById('discountRow');
        const finalAmount = document.getElementById('finalAmount');
        const baseAmount = {{ $booking->total_amount }};
        const cardDetails = document.getElementById('cardDetails');
        const paymentMethods = document.getElementsByName('payment_method');
        const submitButton = form.querySelector('button[type="submit"]');

        // Handle discount changes
        discountType.addEventListener('change', function() {
            const hasDiscount = this.value !== '';
            discountId.disabled = !hasDiscount;
            discountRow.style.display = hasDiscount ? 'flex' : 'none';
            
            // Update final amount
            const discountAmount = hasDiscount ? baseAmount * 0.2 : 0;
            const finalAmountValue = baseAmount - discountAmount;
            finalAmount.textContent = '₱' + finalAmountValue.toFixed(2);
        });

        // Handle payment method changes
        paymentMethods.forEach(method => {
            method.addEventListener('change', function() {
                cardDetails.classList.toggle('d-none', this.value !== 'credit_card');
                
                // Reset card fields when switching payment methods
                if (this.value !== 'credit_card') {
                    cardDetails.querySelectorAll('input').forEach(input => input.value = '');
                }
            });
        });

        // Form submission handling
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Disable submit button to prevent double submission
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';

            // Validate form
            let isValid = true;
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
            
            // Validate discount ID if discount is selected
            if (discountType.value && !discountId.value.trim()) {
                alert('Please enter the discount ID number');
                isValid = false;
            }

            // Validate credit card fields if credit card is selected
            if (paymentMethod === 'credit_card') {
                const cardFields = cardDetails.querySelectorAll('input');
                cardFields.forEach(field => {
                    if (!field.value.trim()) {
                        alert('Please fill in all credit card details');
                        isValid = false;
                        return false;
                    }
                });
            }

            if (isValid) {
                this.submit();
            } else {
                submitButton.disabled = false;
                submitButton.innerHTML = '<i class="fas fa-check-circle me-2"></i>Process Payment & Confirm Booking';
            }
        });

        // Initialize card input formatting
        if (typeof Cleave !== 'undefined') {
            new Cleave('input[name="card_number"]', {
                creditCard: true,
                onCreditCardTypeChanged: function(type) {
                    // Handle card type change if needed
                }
            });

            new Cleave('input[name="card_expiry"]', {
                date: true,
                datePattern: ['m', 'y']
            });

            new Cleave('input[name="card_cvv"]', {
                numeral: true,
                numeralPositiveOnly: true,
                blocks: [3]
            });
        }
    });
</script>
@endpush
@endsection 