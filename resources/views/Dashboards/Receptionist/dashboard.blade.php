@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h4 mb-0">Receptionist Dashboard</h2>
                <div class="text-muted">{{ now()->format('l, F j, Y') }}</div>
            </div>

            <!-- Stats Cards -->
            <div class="row g-4 mb-4">
                <!-- Check-ins Today -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="text-muted mb-1">Check-ins Today</h6>
                                    <h3 class="mb-0">{{ $todayCheckins }}</h3>
                                </div>
                                <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                    <i class="fas fa-sign-in-alt text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Check-outs Today -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="text-muted mb-1">Check-outs Today</h6>
                                    <h3 class="mb-0">{{ $todayCheckouts }}</h3>
                                </div>
                                <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                    <i class="fas fa-sign-out-alt text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Room Status Summary -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="text-muted mb-1">Room Status</h6>
                                    <div class="d-flex gap-3">
                                        <div>
                                            <small class="text-success d-block">Available</small>
                                            <span class="h5 mb-0">{{ $availableRooms }}</span>
                                        </div>
                                        <div>
                                            <small class="text-warning d-block">Reserved</small>
                                            <span class="h5 mb-0">{{ $reservedRooms }}</span>
                                        </div>
                                        <div>
                                            <small class="text-danger d-block">Occupied</small>
                                            <span class="h5 mb-0">{{ $occupiedRooms }}</span>
                                        </div>
                                        <div>
                                            <small class="text-info d-block">Maintenance</small>
                                            <span class="h5 mb-0">{{ $maintenanceRooms }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-info bg-opacity-10 rounded-circle p-3">
                                    <i class="fas fa-bed text-info"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="card-title mb-0">Quick Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <a href="{{ route('receptionist.checkin') }}" class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center gap-2">
                                        <i class="fas fa-sign-in-alt"></i>
                                        New Check-in
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ route('receptionist.checkout') }}" class="btn btn-outline-success w-100 d-flex align-items-center justify-content-center gap-2">
                                        <i class="fas fa-sign-out-alt"></i>
                                        Process Check-out
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ route('receptionist.bookings.create') }}" class="btn btn-outline-info w-100 d-flex align-items-center justify-content-center gap-2">
                                        <i class="fas fa-calendar-plus"></i>
                                        New Booking
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ route('receptionist.rooms') }}" class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-center gap-2">
                                        <i class="fas fa-th-large"></i>
                                        Room Status
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Today's Schedule -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="card-title mb-0">Today's Schedule</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="border-0">Time</th>
                                            <th class="border-0">Guest Name</th>
                                            <th class="border-0">Room</th>
                                            <th class="border-0">Action</th>
                                            <th class="border-0">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($todaySchedule as $schedule)
                                        <tr>
                                            <td>{{ $schedule->time }}</td>
                                            <td>{{ $schedule->guest_name }}</td>
                                            <td>{{ $schedule->room_number }}</td>
                                            <td>{{ $schedule->action }}</td>
                                            <td>
                                                <span class="badge bg-{{ $schedule->status === 'completed' ? 'success' : ($schedule->status === 'pending' ? 'warning' : 'secondary') }}">
                                                    {{ ucfirst($schedule->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted">
                                                <i class="fas fa-calendar-day me-2"></i>
                                                No scheduled activities for today
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Reservations -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="card-title mb-0">Pending Reservations</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="border-0">Guest Name</th>
                                            <th class="border-0">Room</th>
                                            <th class="border-0">Check-in</th>
                                            <th class="border-0">Check-out</th>
                                            <th class="border-0">Total Amount</th>
                                            <th class="border-0">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($pendingReservations as $booking)
                                        <tr>
                                            <td>{{ $booking->user->name }}</td>
                                            <td>{{ $booking->room->room_number }}</td>
                                            <td>{{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') }}</td>
                                            <td>₱{{ number_format($booking->total_amount, 2) }}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <form action="{{ route('receptionist.bookings.approve', $booking->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success btn-sm me-1">
                                                            <i class="fas fa-check"></i> Approve
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('receptionist.bookings.reject', $booking->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger btn-sm me-1">
                                                            <i class="fas fa-times"></i> Reject
                                                        </button>
                                                    </form>
                                                    <a href="{{ route('receptionist.bookings.view', $booking->id) }}" class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4 text-muted">
                                                <i class="fas fa-calendar-check me-2"></i>
                                                No pending reservations
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Notifications -->
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Recent Notifications</h5>
                            <button class="btn btn-sm btn-outline-primary">View All</button>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                @forelse($notifications as $notification)
                                <div class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="avatar {{ $notification->type === 'alert' ? 'bg-danger' : 'bg-info' }} bg-opacity-10 rounded-circle p-2">
                                                <i class="fas fa-bell {{ $notification->type === 'alert' ? 'text-danger' : 'text-info' }}"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="mb-1">{{ $notification->message }}</p>
                                            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-4 text-muted">
                                    <i class="fas fa-bell-slash me-2"></i>
                                    No new notifications
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .card {
        transition: transform 0.2s ease-in-out;
    }
    .card:hover {
        transform: translateY(-2px);
    }
    .avatar {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endpush

@push('scripts')
<script>
    // Add any JavaScript enhancements here
</script>
@endpush
@endsection 