@props(['room'])

<div class="card h-100 border-0 shadow-sm room-card position-relative" style="background: linear-gradient(135deg, #F8FAFC 60%, #E0E7EF 100%); border-radius: 24px; overflow: hidden; min-width: 340px; max-width: 420px; margin: 0 auto; border-left: 6px solid #D946EF; box-shadow: 0 4px 24px 0 rgba(37,99,235,0.10);">
    <!-- Accent Icon -->
    <span class="position-absolute top-0 end-0 m-3" style="z-index:2;">
        <i class="fas fa-heart" style="color: #D946EF; opacity: 0.85; font-size: 2rem; filter: drop-shadow(0 2px 8px #D946EF44);"></i>
    </span>
    <x-room-image 
        :image="$room->image_url"
        :alt="$room->type . ' - Room ' . $room->room_number"
        style="border-top-left-radius: 24px; border-top-right-radius: 24px; height: 260px; object-fit: cover;"
    />
    <div class="card-body d-flex flex-column" style="padding: 2rem 1.5rem 1.5rem 1.5rem;">
        <div class="d-flex justify-content-between align-items-start mb-2">
            <h4 class="card-title mb-0" style="color: #1E3A5F; font-size: 1.5rem; font-weight: 700; letter-spacing: 0.5px;">{{ $room->type }}</h4>
            <span class="badge" style="background-color: #5EEAD4; color: #1E3A5F; font-size: 1.05rem; padding: 0.6em 1em; border-radius: 12px;">Room {{ $room->room_number }}</span>
        </div>
        <p class="card-text small text-muted mb-3" style="font-size: 1.08rem;">{{ Str::limit($room->description, 100) }}</p>
        <div class="room-features small mb-3" style="font-size: 1.05rem;">
            <div class="d-flex align-items-center mb-2">
                <i class="fas fa-user-friends me-2" style="color: #3B82F6;"></i>
                <span>Up to {{ $room->capacity }} guests</span>
            </div>
            @if($room->has_view)
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-mountain me-2" style="color: #5EEAD4;"></i>
                    <span>Scenic View</span>
                </div>
            @endif
            @if(!$room->is_smoking)
                <div class="d-flex align-items-center">
                    <i class="fas fa-smoking-ban me-2" style="color: #D946EF;"></i>
                    <span>Non-smoking</span>
                </div>
            @endif
        </div>
        <div class="mt-auto">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <span class="h4 mb-0" style="color: #D946EF; font-weight: 800; font-size: 2rem;">₱{{ number_format($room->price_per_night, 2) }}</span>
                    <span class="small text-muted" style="font-size: 1.1rem;">/night</span>
                </div>
            </div>
            <a href="javascript:void(0);" 
               class="btn btn-book-now w-100 py-3 book-now-btn" 
               data-room-id="{{ $room->id }}"
               data-book-url="{{ route('rooms.book', $room) }}"
               style="background: linear-gradient(90deg, #5EEAD4 0%, #3B82F6 100%); color: #1E3A5F; font-weight: 800; border-radius: 12px; letter-spacing: 1px; font-size: 1.15rem; box-shadow: 0 2px 12px rgba(59,130,246,0.10);">
                BOOK NOW
                <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</div>

<style>
.room-card {
    min-width: 340px;
    max-width: 420px;
    margin-bottom: 2.5rem;
    border-radius: 24px;
    box-shadow: 0 4px 24px 0 rgba(37,99,235,0.10);
    background: linear-gradient(135deg, #F8FAFC 60%, #E0E7EF 100%);
    border-left: 6px solid #D946EF;
    transition: transform 0.28s cubic-bezier(.4,2,.3,1), box-shadow 0.28s cubic-bezier(.4,2,.3,1);
    position: relative;
}
.room-card:hover {
    transform: translateY(-16px) scale(1.04) rotate(-1deg);
    box-shadow: 0 12px 40px 0 rgba(217,70,239,0.16), 0 4px 24px 0 rgba(37,99,235,0.13);
    border-left: 8px solid #D946EF;
    background: linear-gradient(120deg, #F8FAFC 40%, #E0E7EF 80%, #5EEAD4 100%);
}
.btn-book-now {
    transition: all 0.3s cubic-bezier(.4,2,.3,1);
}
.btn-book-now:hover {
    background: linear-gradient(90deg, #D946EF 0%, #3B82F6 100%) !important;
    color: #fff !important;
    transform: translateY(-2px) scale(1.04);
    box-shadow: 0 6px 20px rgba(217,70,239,0.15);
}
</style> 