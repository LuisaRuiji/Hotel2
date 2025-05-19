@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="h4 mb-0">Check-in Management</h2>
                    <p class="text-muted mb-0">Process guest check-ins</p>
                </div>
                <a href="{{ route('receptionist.dashboard') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Back to Dashboard
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Pending Check-ins -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Pending Check-ins</h5>
                        <div class="input-group" style="width: 300px;">
                            <input type="text" class="form-control" placeholder="Search guest name..." id="searchInput">
                            <button class="btn btn-outline-secondary" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0">Booking ID</th>
                                    <th class="border-0">Guest Name</th>
                                    <th class="border-0">Room</th>
                                    <th class="border-0">Check-in Date</th>
                                    <th class="border-0">Length of Stay</th>
                                    <th class="border-0">Status</th>
                                    <th class="border-0">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendingCheckins as $booking)
                                <tr>
                                    <td>#{{ $booking->id }}</td>
                                    <td>{{ $booking->user->name }}</td>
                                    <td>Room {{ $booking->room->room_number }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->check_in_date)->diffInDays($booking->check_out_date) }} nights</td>
                                    <td>
                                        <span class="badge bg-warning">Pending</span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" 
                                                    class="btn btn-success process-checkin" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#checkinModal"
                                                    data-booking-id="{{ $booking->id }}"
                                                    data-guest-name="{{ $booking->user->name }}"
                                                    data-room-number="{{ $booking->room->room_number }}">
                                                <i class="fas fa-check me-1"></i>
                                                Process Check-in
                                            </button>
                                            <a href="{{ route('receptionist.bookings.view', $booking->id) }}" class="btn btn-outline-secondary">
                                                <i class="fas fa-info-circle"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        <i class="fas fa-bed me-2"></i>
                                        No pending check-ins for today
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @if($futureApproved->count())
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Future Approved Reservations</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0">Booking ID</th>
                                    <th class="border-0">Guest Name</th>
                                    <th class="border-0">Room</th>
                                    <th class="border-0">Check-in Date</th>
                                    <th class="border-0">Length of Stay</th>
                                    <th class="border-0">Status</th>
                                    <th class="border-0">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($futureApproved as $booking)
                                <tr>
                                    <td>#{{ $booking->id }}</td>
                                    <td>{{ $booking->user->name }}</td>
                                    <td>Room {{ $booking->room->room_number }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->check_in_date)->diffInDays($booking->check_out_date) }} nights</td>
                                    <td>
                                        <span class="badge bg-info">Upcoming</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('receptionist.bookings.view', $booking->id) }}" class="btn btn-outline-secondary btn-sm">
                                            <i class="fas fa-info-circle"></i> Details
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Check-in Modal -->
<div class="modal fade" id="checkinModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Process Check-in</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="checkinForm" action="{{ route('receptionist.process-checkin') }}" method="POST">
                @csrf
                <input type="hidden" name="booking_id" id="bookingId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Guest Name</label>
                        <input type="text" class="form-control" id="guestName" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Room Number</label>
                        <input type="text" class="form-control" id="roomNumber" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Special Requests/Notes</label>
                        <textarea class="form-control" name="notes" rows="3" placeholder="Enter any special requests or notes..."></textarea>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="id_verified" id="idVerified" value="1" required>
                        <label class="form-check-label" for="idVerified">
                            I confirm that I have verified the guest's ID
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check me-1"></i>
                        Complete Check-in
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle check-in button clicks
    const checkinModal = document.getElementById('checkinModal');
    checkinModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const bookingId = button.getAttribute('data-booking-id');
        const guestName = button.getAttribute('data-guest-name');
        const roomNumber = button.getAttribute('data-room-number');
        
        document.getElementById('bookingId').value = bookingId;
        document.getElementById('guestName').value = guestName;
        document.getElementById('roomNumber').value = roomNumber;
    });

    // Search functionality
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('keyup', function() {
        const searchText = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('tbody tr');
        
        tableRows.forEach(row => {
            const guestName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            row.style.display = guestName.includes(searchText) ? '' : 'none';
        });
    });
});
</script>
@endpush
@endsection 