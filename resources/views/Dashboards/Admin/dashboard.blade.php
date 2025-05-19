@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-11">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="h4 mb-0">Admin Dashboard</h2>
                    <div class="text-muted">{{ now()->format('l, F j, Y') }}</div>
                </div>

                <!-- Stats Cards -->
                <div class="row g-4 mb-4">
                    <!-- Total Rooms -->
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="text-muted mb-1">Total Rooms</h6>
                                        <h3 class="mb-0">{{ $totalRooms ?? '0' }}</h3>
                                    </div>
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                        <i class="fas fa-bed text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Available Rooms -->
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="text-muted mb-1">Available Rooms</h6>
                                        <h3 class="mb-0">{{ $availableRooms ?? '0' }}</h3>
                                    </div>
                                    <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                        <i class="fas fa-door-open text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Current Bookings -->
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="text-muted mb-1">Occupied Rooms</h6>
                                        <h3 class="mb-0">{{ $occupiedRooms ?? '0' }}</h3>
                                    </div>
                                    <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                                        <i class="fas fa-calendar-check text-danger"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Revenue -->
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="text-muted mb-1">Total Revenue</h6>
                                        <h3 class="mb-0">₱{{ number_format($totalRevenue ?? 0, 2) }}</h3>
                                    </div>
                                    <div class="bg-info bg-opacity-10 rounded-circle p-3">
                                        <i class="fas fa-money-bill-wave text-info"></i>
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
                                    <div class="col-md-4">
                                        <a href="{{ route('admin.rooms') }}"
                                            class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center gap-2">
                                            <i class="fas fa-bed"></i>
                                            Manage Rooms
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="{{ route('admin.users') }}"
                                            class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center gap-2">
                                            <i class="fas fa-user-shield"></i>
                                            Manage Users
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="{{ route('admin.transactions') }}"
                                            class="btn btn-outline-info w-100 d-flex align-items-center justify-content-center gap-2">
                                            <i class="fas fa-receipt"></i>
                                            View Transactions
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Bookings & Activity -->
                <div class="row g-4 mb-4">
                    <!-- Recent Bookings -->
                    <div class="col-lg-7">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Recent Bookings</h5>
                                <a href="{{ route('admin.transactions') }}" class="btn btn-sm btn-outline-primary">View
                                    All</a>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="bg-light">
                                            <tr>
                                                <th class="border-0">Guest</th>
                                                <th class="border-0">Room</th>
                                                <th class="border-0">Check In</th>
                                                <th class="border-0">Status</th>
                                                <th class="border-0">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($recentBookings ?? [] as $booking)
                                                <tr>
                                                    <td>{{ $booking->guest_name }}</td>
                                                    <td>{{ $booking->room_number }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') }}
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge bg-{{ $booking->status === 'completed' ? 'success' : ($booking->status === 'pending' ? 'warning' : 'success') }} text-bg-{{ $booking->status === 'completed' ? 'success' : ($booking->status === 'pending' ? 'warning' : 'danger') }}">
                                                            {{ ucfirst($booking->status) }}

                                                        </span>
                                                    </td>
                                                    <td>₱{{ number_format($booking->total_amount, 2) }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center py-4 text-muted">
                                                        <i class="fas fa-calendar-day me-2"></i>
                                                        No recent bookings
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="col-lg-5">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0">Recent Activity</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="list-group list-group-flush">
                                    @forelse($recentActivities ?? [] as $activity)
                                        <div class="list-group-item border-0 py-3">
                                            <div class="d-flex">
                                                <div class="me-3">
                                                    <div
                                                        class="avatar avatar-sm bg-{{ $activity->status === 'completed' ? 'success' : ($activity->status === 'pending' ? 'warning' : 'danger') }} bg-opacity-10 rounded-circle">
                                                        <span
                                                            class="avatar-text text-{{ $activity->status === 'completed' ? 'success' : ($activity->status === 'pending' ? 'warning' : 'danger') }}">
                                                            <i
                                                                class="fas fa-{{ $activity->status === 'completed' ? 'check' : ($activity->status === 'pending' ? 'clock' : 'exclamation') }}"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <p class="mb-1 fw-medium">{{ $activity->description }}</p>
                                                    <div class="d-flex align-items-center">
                                                        <small class="text-muted">{{ $activity->user->name }}</small>
                                                        <span class="mx-2 text-muted">•</span>
                                                        <small
                                                            class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                                                    </div>
                                                </div>
                                                <div>
                                                    <span
                                                        class="badge bg-{{ $activity->status === 'completed' ? 'success' : ($activity->status === 'pending' ? 'warning' : 'danger') }}">
                                                        {{ ucfirst($activity->status) }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-5 text-muted">
                                            <i class="fas fa-history fa-2x mb-3"></i>
                                            <p>No recent activities</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Room Status Summary -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0">Room Status Summary</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <canvas id="roomStatusChart" height="200"></canvas>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="h-100 d-flex flex-column justify-content-center">
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="fw-medium">Available</span>
                                                    <span class="fw-medium text-success">{{ $availableRooms ?? 0 }}</span>
                                                </div>
                                                <div class="progress" style="height: 8px;">
                                                    <div class="progress-bar bg-success"
                                                        style="width: {{ ($availableRooms ?? 0) / (($totalRooms ?? 1) ?: 1) * 100 }}%">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="fw-medium">Occupied</span>
                                                    <span class="fw-medium text-danger">{{ $occupiedRooms ?? 0 }}</span>
                                                </div>
                                                <div class="progress" style="height: 8px;">
                                                    <div class="progress-bar bg-danger"
                                                        style="width: {{ ($occupiedRooms ?? 0) / (($totalRooms ?? 1) ?: 1) * 100 }}%">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="fw-medium">Maintenance</span>
                                                    <span class="fw-medium text-warning">{{ $maintenanceRooms ?? 0 }}</span>
                                                </div>
                                                <div class="progress" style="height: 8px;">
                                                    <div class="progress-bar bg-warning"
                                                        style="width: {{ ($maintenanceRooms ?? 0) / (($totalRooms ?? 1) ?: 1) * 100 }}%">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="fw-medium">Reserved</span>
                                                    <span class="fw-medium text-info">{{ $reservedRooms ?? 0 }}</span>
                                                </div>
                                                <div class="progress" style="height: 8px;">
                                                    <div class="progress-bar bg-info"
                                                        style="width: {{ ($reservedRooms ?? 0) / (($totalRooms ?? 1) ?: 1) * 100 }}%">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Room status chart
                const roomStatusChart = document.getElementById('roomStatusChart');
                if (roomStatusChart) {
                    new Chart(roomStatusChart, {
                        type: 'doughnut',
                        data: {
                            labels: ['Available', 'Occupied', 'Maintenance', 'Reserved'],
                            datasets: [{
                                data: [
                                                                                                                                                                                                                                            {{ $availableRooms ?? 0 }},
                                                                                                                                                                                                                                            {{ $occupiedRooms ?? 0 }},
                                                                                                                                                                                                                                            {{ $maintenanceRooms ?? 0 }},
                                    {{ $reservedRooms ?? 0 }}
                                ],
                                backgroundColor: [
                                    'rgba(40, 167, 69, 0.8)',  // success
                                    'rgba(220, 53, 69, 0.8)',  // danger
                                    'rgba(255, 193, 7, 0.8)',  // warning
                                    'rgba(23, 162, 184, 0.8)'  // info
                                ],
                                borderColor: [
                                    'rgba(40, 167, 69, 1)',
                                    'rgba(220, 53, 69, 1)',
                                    'rgba(255, 193, 7, 1)',
                                    'rgba(23, 162, 184, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                }
                            },
                            cutout: '65%'
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection