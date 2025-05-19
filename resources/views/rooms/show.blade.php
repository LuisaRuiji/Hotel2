@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Room Images -->
        <div class="col-lg-7 mb-4 mb-lg-0">
            <x-room-image 
                :image="$room->image_url"
                :alt="$room->type . ' - Room ' . $room->room_number"
                style="height: 400px; width: 100%; object-fit: cover;"
            />
        </div>

        <!-- Room Details -->
        <div class="col-lg-5">
            <div class="sticky-top" style="top: 2rem;">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h1 class="h2 mb-3" style="color: var(--primary-color);">{{ $room->type }}</h1>
                        <p class="lead mb-4">{{ $room->description }}</p>
                        
                        <div class="mb-4">
                            <h5 class="mb-3">Room Features</h5>
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-users me-2"></i>
                                        <span>Up to {{ $room->capacity }} guests</span>
                                    </div>
                                </div>
                                @if($room->has_view)
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-mountain me-2"></i>
                                        <span>Scenic View</span>
                                    </div>
                                </div>
                                @endif
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-smoking{{ $room->is_smoking ? '' : '-ban' }} me-2"></i>
                                        <span>{{ $room->is_smoking ? 'Smoking' : 'Non-smoking' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h5 class="mb-3">Amenities</h5>
                            <div class="row g-2">
                                @foreach(json_decode($room->amenities) as $amenity)
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-check me-2 text-success"></i>
                                        <span>{{ $amenity }}</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <span class="h3 mb-0" style="color: var(--accent-color);">₱{{ number_format($room->price_per_night, 2) }}</span>
                                <span class="text-muted">/night</span>
                            </div>
                            <span class="badge" style="background-color: var(--accent-color);">Room {{ $room->room_number }}</span>
                        </div>

                        <a href="javascript:void(0);" 
                           class="btn btn-lg w-100 book-now-btn" 
                           data-room-id="{{ $room->id }}"
                           data-book-url="{{ route('rooms.book', $room) }}"
                           style="background-color: var(--primary-color); color: white;">
                            Book Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 