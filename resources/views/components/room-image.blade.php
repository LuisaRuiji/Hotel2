<div class="room-image-container">
    <img src="{{ Str::startsWith($image, 'http') ? $image : asset($image) }}" 
         alt="{{ $alt ?? 'Room image' }}"
         class="{{ $class ?? 'img-fluid rounded' }}"
         style="{{ $style ?? 'height: 250px; width: 100%; object-fit: cover;' }}"
         onerror="this.onerror=null; this.src='https://picsum.photos/800/600?random=0'"
    >
</div> 