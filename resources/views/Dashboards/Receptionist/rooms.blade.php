@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h4 class="mb-0">Room Management</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('receptionist.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Rooms</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row g-4">
        <!-- Status Summary Cards -->
        <div class="col-12">
            <div class="row g-3">
                <div class="col-sm-6 col-md-3">
                    <div class="card bg-success bg-opacity-10 border-success border-opacity-25">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check-circle text-success fa-2x"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="card-title mb-1">Available</h6>
                                    <h3 class="mb-0">{{ $availableRooms }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card bg-danger bg-opacity-10 border-danger border-opacity-25">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-bed text-danger fa-2x"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="card-title mb-1">Occupied</h6>
                                    <h3 class="mb-0">{{ $occupiedRooms }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card bg-warning bg-opacity-10 border-warning border-opacity-25">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-clock text-warning fa-2x"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="card-title mb-1">Reserved</h6>
                                    <h3 class="mb-0">{{ $reservedRooms }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card bg-info bg-opacity-10 border-info border-opacity-25">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-broom text-info fa-2x"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="card-title mb-1">Cleaning</h6>
                                    <h3 class="mb-0">{{ $cleaningRooms }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rooms List -->
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <div class="row align-items-center mb-3">
                        <div class="col">
                            <h5 class="mb-0">All Rooms</h5>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" class="form-control" id="searchRoom" placeholder="Search room...">
                                <button class="btn btn-outline-secondary" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row g-2 filters-row">
                        <div class="col-md-3">
                            <select class="form-select form-select-sm" id="statusFilter">
                                <option value="all">All Statuses</option>
                                <option value="available">Available</option>
                                <option value="occupied">Occupied</option>
                                <option value="reserved">Reserved</option>
                                <option value="cleaning">Cleaning</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select form-select-sm" id="typeFilter">
                                <option value="all">All Room Types</option>
                                <option value="Standard">Standard</option>
                                <option value="Deluxe">Deluxe</option>
                                <option value="Suite">Suite</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select form-select-sm" id="floorFilter">
                                <option value="all">All Floors</option>
                                <option value="1">Floor 1</option>
                                <option value="2">Floor 2</option>
                                <option value="3">Floor 3</option>
                            </select>
                        </div>
                        <div class="col-md-3 text-end">
                            <button class="btn btn-sm btn-outline-secondary" id="clearFilters">
                                <i class="fas fa-times me-1"></i>Clear Filters
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Room</th>
                                    <th>Type</th>
                                    <th>Floor</th>
                                    <th>Status</th>
                                    <th>Current Guest</th>
                                    <th>Check-in</th>
                                    <th>Check-out</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rooms as $room)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="room-number fw-bold">{{ $room->room_number }}</div>
                                        </div>
                                    </td>
                                    <td>{{ $room->type }}</td>
                                    <td>{{ floor($room->room_number / 100) }}</td>
                                    <td>
                                        @if($room->status === 'available')
                                            <span class="badge bg-success">Available</span>
                                        @elseif($room->status === 'occupied')
                                            <span class="badge bg-danger">Occupied</span>
                                        @elseif($room->status === 'reserved')
                                            <span class="badge bg-warning">Reserved</span>
                                        @elseif($room->status === 'cleaning')
                                            <span class="badge bg-info">Cleaning</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($room->currentBooking)
                                            {{ $room->currentBooking->user->name }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($room->currentBooking)
                                            {{ $room->currentBooking->check_in_date->format('M d, Y') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($room->currentBooking)
                                            {{ $room->currentBooking->check_out_date->format('M d, Y') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group">
                                            @if($room->status === 'available')
                                                <a href="{{ route('receptionist.bookings.create', ['room' => $room->id]) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-plus me-1"></i>New Booking
                                                </a>
                                            @endif
                                            @if($room->status === 'cleaning')
                                                <form action="{{ route('receptionist.rooms.update-status', $room->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="status" value="available">
                                                    <button type="submit" class="btn btn-sm btn-outline-success">
                                                        <i class="fas fa-check-circle me-1"></i>Mark Available
                                                    </button>
                                                </form>
                                            @endif
                                            <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#roomDetails{{ $room->id }}">
                                                <i class="fas fa-info-circle"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($rooms->hasPages())
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="pagination-info">
                            Showing {{ $rooms->firstItem() }} to {{ $rooms->lastItem() }} of {{ $rooms->total() }} rooms
                        </div>
                        <nav aria-label="Room pagination">
                            <ul class="pagination pagination-sm mb-0">
                                {{-- First Page Link --}}
                                <li class="page-item {{ $rooms->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $rooms->url(1) }}" aria-label="First">
                                        <span aria-hidden="true"><i class="fas fa-angle-double-left"></i></span>
                                    </a>
                                </li>
                                
                                {{-- Previous Page Link --}}
                                <li class="page-item {{ $rooms->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $rooms->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true"><i class="fas fa-angle-left"></i></span>
                                    </a>
                                </li>
                                
                                {{-- Pagination Elements --}}
                                @php
                                    $currentPage = $rooms->currentPage();
                                    $lastPage = $rooms->lastPage();
                                    $window = 2; // Number of pages to show on each side of current page
                                    
                                    $startPage = max($currentPage - $window, 1);
                                    $endPage = min($currentPage + $window, $lastPage);
                                    
                                    // Always show first and last pages
                                    if ($startPage > 1) {
                                        echo '<li class="page-item"><a class="page-link" href="'.$rooms->url(1).'">1</a></li>';
                                        if ($startPage > 2) {
                                            echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                        }
                                    }
                                @endphp
                                
                                @for ($i = $startPage; $i <= $endPage; $i++)
                                    <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $rooms->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                
                                @php
                                    // Always show first and last pages
                                    if ($endPage < $lastPage) {
                                        if ($endPage < $lastPage - 1) {
                                            echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                        }
                                        echo '<li class="page-item"><a class="page-link" href="'.$rooms->url($lastPage).'">'.$lastPage.'</a></li>';
                                    }
                                @endphp
                                
                                {{-- Next Page Link --}}
                                <li class="page-item {{ $rooms->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $rooms->nextPageUrl() }}" aria-label="Next">
                                        <span aria-hidden="true"><i class="fas fa-angle-right"></i></span>
                                    </a>
                                </li>
                                
                                {{-- Last Page Link --}}
                                <li class="page-item {{ $rooms->currentPage() == $rooms->lastPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $rooms->url($rooms->lastPage()) }}" aria-label="Last">
                                        <span aria-hidden="true"><i class="fas fa-angle-double-right"></i></span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@foreach($rooms as $room)
<!-- Room Details Modal -->
<div class="modal fade" id="roomDetails{{ $room->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Room {{ $room->room_number }} Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-6">
                        <p class="mb-1 text-muted">Room Type</p>
                        <p class="fw-bold">{{ $room->type }}</p>
                    </div>
                    <div class="col-6">
                        <p class="mb-1 text-muted">Floor</p>
                        <p class="fw-bold">{{ floor($room->room_number / 100) }}</p>
                    </div>
                    <div class="col-6">
                        <p class="mb-1 text-muted">Status</p>
                        <p class="fw-bold">
                            @if($room->status === 'available')
                                <span class="text-success">Available</span>
                            @elseif($room->status === 'occupied')
                                <span class="text-danger">Occupied</span>
                            @elseif($room->status === 'reserved')
                                <span class="text-warning">Reserved</span>
                            @elseif($room->status === 'cleaning')
                                <span class="text-info">Cleaning</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-6">
                        <p class="mb-1 text-muted">Price per Night</p>
                        <p class="fw-bold">₱{{ number_format($room->price_per_night, 2) }}</p>
                    </div>
                    @if($room->currentBooking)
                    <div class="col-12">
                        <hr>
                        <h6>Current Booking</h6>
                        <div class="row g-2">
                            <div class="col-6">
                                <p class="mb-1 text-muted">Guest</p>
                                <p class="fw-bold">{{ $room->currentBooking->user->name }}</p>
                            </div>
                            <div class="col-6">
                                <p class="mb-1 text-muted">Check-in</p>
                                <p class="fw-bold">{{ $room->currentBooking->check_in_date->format('M d, Y') }}</p>
                            </div>
                            <div class="col-6">
                                <p class="mb-1 text-muted">Check-out</p>
                                <p class="fw-bold">{{ $room->currentBooking->check_out_date->format('M d, Y') }}</p>
                            </div>
                            <div class="col-6">
                                <p class="mb-1 text-muted">Total Amount</p>
                                <p class="fw-bold">₱{{ number_format($room->currentBooking->total_amount, 2) }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                @if($room->status === 'available')
                    <a href="{{ route('receptionist.bookings.create', ['room' => $room->id]) }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>New Booking
                    </a>
                @endif
                @if($room->status === 'cleaning')
                    <form action="{{ route('receptionist.rooms.update-status', $room->id) }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="status" value="available">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check-circle me-1"></i>Mark as Available
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach

@push('styles')
<style>
    .badge {
        font-weight: 500;
        padding: 0.5em 0.75em;
    }
    
    .table > :not(caption) > * > * {
        padding: 1rem;
    }

    .room-number {
        font-size: 1.1rem;
        color: var(--primary-color);
    }

    .modal-body .text-muted {
        font-size: 0.875rem;
    }
    
    /* Custom Pagination Styles */
    .pagination-info {
        color: #6c757d;
        font-size: 0.875rem;
    }
    
    .pagination {
        margin-bottom: 0;
    }
    
    .page-item .page-link {
        color: #566a7f;
        border-radius: 0.25rem;
        margin: 0 2px;
        min-width: 2rem;
        text-align: center;
    }
    
    .page-item.active .page-link {
        background-color: #696cff;
        border-color: #696cff;
        box-shadow: 0 0.125rem 0.25rem rgba(105, 108, 255, 0.4);
        color: #fff;
    }
    
    .page-item.disabled .page-link {
        color: #c9cdd3;
    }
    
    .page-link:hover {
        background-color: #e9ecef;
        color: #566a7f;
    }
    
        .page-item:first-child .page-link,    .page-item:last-child .page-link {        padding: 0.25rem 0.5rem;    }        /* Filter Styles */    .filters-row {        background-color: #f8f9fa;        border-radius: 0.25rem;        padding: 0.75rem;        margin-top: 0.5rem;    }        .filters-row select {        border: 1px solid #dfe3e7;        background-color: white;        font-size: 0.85rem;    }        .filters-row .btn {        font-size: 0.85rem;        border-color: #dfe3e7;    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchRoom');
    const statusFilter = document.getElementById('statusFilter');
    const typeFilter = document.getElementById('typeFilter');
    const floorFilter = document.getElementById('floorFilter');
    const clearFiltersBtn = document.getElementById('clearFilters');
    const tableRows = document.querySelectorAll('tbody tr');
    
    // Function to apply all filters
    function applyFilters() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value;
        const typeValue = typeFilter.value;
        const floorValue = floorFilter.value;
        
        tableRows.forEach(row => {
            const roomNumber = row.querySelector('.room-number').textContent.toLowerCase();
            const roomType = row.cells[1].textContent.toLowerCase();
            const roomFloor = row.cells[2].textContent.trim();
            
            // Get status from badge class/text
            const statusBadge = row.cells[3].querySelector('.badge');
            const roomStatus = statusBadge ? statusBadge.textContent.toLowerCase() : '';
            
            // Check if row passes all filters
            const matchesSearch = roomNumber.includes(searchTerm) || roomType.includes(searchTerm);
            const matchesStatus = statusValue === 'all' || roomStatus.toLowerCase() === statusValue.toLowerCase();
            const matchesType = typeValue === 'all' || roomType.toLowerCase() === typeValue.toLowerCase();
            const matchesFloor = floorValue === 'all' || roomFloor === floorValue;
            
            // Show/hide row based on filter results
            if (matchesSearch && matchesStatus && matchesType && matchesFloor) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
        
        // Update visible count
        updateVisibleCount();
    }
    
    // Function to reset all filters
    function clearFilters() {
        searchInput.value = '';
        statusFilter.value = 'all';
        typeFilter.value = 'all';
        floorFilter.value = 'all';
        
        tableRows.forEach(row => {
            row.style.display = '';
        });
        
        updateVisibleCount();
    }
    
    // Function to update count of visible rooms
    function updateVisibleCount() {
        const visibleRows = document.querySelectorAll('tbody tr:not([style*="display: none"])');
        const totalRows = tableRows.length;
        
        // Find the pagination info element and update it
        const paginationInfo = document.querySelector('.pagination-info');
        if (paginationInfo) {
            paginationInfo.textContent = `Showing ${visibleRows.length} of ${totalRows} rooms (filtered)`;
        }
    }
    
    // Add event listeners
    searchInput.addEventListener('input', applyFilters);
    statusFilter.addEventListener('change', applyFilters);
    typeFilter.addEventListener('change', applyFilters);
    floorFilter.addEventListener('change', applyFilters);
    clearFiltersBtn.addEventListener('click', clearFilters);
});
</script>
@endpush

@endsection 