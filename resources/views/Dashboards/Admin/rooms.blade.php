@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-11">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="h4 mb-0">Room Management</h2>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRoomModal">
                        <i class="fas fa-plus me-2"></i>Add New Room
                    </button>
                </div>

                <!-- Room Categories Filter -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <h5 class="card-title mb-0 me-auto">Room Categories</h5>
                            <button class="btn btn-sm btn-outline-primary ms-2" data-bs-toggle="modal"
                                data-bs-target="#addCategoryModal">
                                <i class="fas fa-plus me-1"></i>Add Category
                            </button>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <button class="btn btn-sm btn-primary category-filter active" data-category="all">All
                                Rooms</button>
                            @foreach($categories ?? [] as $category)
                                <button class="btn btn-sm btn-outline-primary category-filter"
                                    data-category="{{ $category->id }}">
                                    {{ $category->name }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Rooms Grid -->
                <div class="row g-4 mb-4" id="roomsContainer">
                    @forelse($rooms ?? [] as $room)
                        <div class="col-md-4 col-lg-3 room-item" data-category="{{ $room->category_id }}">
                            <div class="card border-0 shadow-sm h-100">
                                <img src="{{ asset('storage/' . $room->image) }}" class="card-img-top"
                                    alt="{{ $room->room_number }}" style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h5 class="card-title mb-0">Room {{ $room->room_number }}</h5>
                                        <span
                                            class="badge bg-{{ $room->status === 'available' ? 'success' : ($room->status === 'occupied' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($room->status) }}
                                        </span>
                                    </div>
                                    <p class="text-muted small mb-2">{{ $room->type }}</p>
                                    <p class="mb-0"><strong>₱{{ number_format($room->price_per_night, 2) }}</strong> / night</p>
                                </div>
                                <div class="card-footer bg-white border-0">
                                    <div class="d-flex justify-content-between">
                                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#viewRoomModal" data-room-id="{{ $room->id }}"
                                            data-room-number="{{ $room->room_number }}"
                                            data-room-image="{{ asset('storage/' . $room->image) }}"
                                            data-room-category="{{ $room->category?->name ?? 'No Category' }}"
                                            data-room-price="{{ $room->price }}" data-room-capacity="{{ $room->capacity }}"
                                            data-room-status="{{ $room->status }}"
                                            data-room-description="{{ $room->description }}">
                                            <i class="fas fa-eye me-1"></i>View
                                        </button>
                                        <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal"
                                            data-bs-target="#editRoomModal" data-room-id="{{ $room->id }}"
                                            data-room-number="{{ $room->room_number }}"
                                            data-room-category="{{ $room->category_id }}" data-room-price="{{ $room->price }}"
                                            data-room-capacity="{{ $room->capacity }}" data-room-status="{{ $room->status }}"
                                            data-room-description="{{ $room->description }}">
                                            <i class="fas fa-edit me-1"></i>Edit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle me-2"></i>No rooms available
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Add Room Modal -->
    <div class="modal fade" id="addRoomModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="room_number" class="form-label">Room Number <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="room_number" name="room_number" required>
                                </div>
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Room Category <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="category_id" name="category_id" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories ?? [] as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price per Night (₱) <span
                                            class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                                </div>
                                <div class="mb-3">
                                    <label for="capacity" class="form-label">Capacity <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="capacity" name="capacity" required>
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="available">Available</option>
                                        <option value="maintenance">Maintenance</option>
                                        <option value="occupied">Occupied</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="image" class="form-label">Room Image <span
                                            class="text-danger">*</span></label>
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*"
                                        required>
                                    <div class="mt-2" id="imagePreviewContainer" style="display: none;">
                                        <img id="imagePreview" class="img-thumbnail" style="max-height: 200px;">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" id="description" name="description" rows="8"
                                        required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Room</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Room Modal -->
    <div class="modal fade" id="editRoomModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.rooms.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_room_id" name="room_id">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_room_number" class="form-label">Room Number <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit_room_number" name="room_number"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_category_id" class="form-label">Room Category <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="edit_category_id" name="category_id" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories ?? [] as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_price" class="form-label">Price per Night (₱) <span
                                            class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control" id="edit_price" name="price"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_capacity" class="form-label">Capacity <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="edit_capacity" name="capacity" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_status" class="form-label">Status <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="edit_status" name="status" required>
                                        <option value="available">Available</option>
                                        <option value="maintenance">Maintenance</option>
                                        <option value="occupied">Occupied</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_image" class="form-label">Room Image</label>
                                    <input type="file" class="form-control" id="edit_image" name="image" accept="image/*">
                                    <small class="form-text text-muted">Leave empty to keep the current image</small>
                                    <div class="mt-2" id="editImagePreviewContainer">
                                        <img id="editImagePreview" class="img-thumbnail" style="max-height: 200px;">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_description" class="form-label">Description <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" id="edit_description" name="description" rows="8"
                                        required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Update Room</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Room Modal -->
    <div class="modal fade" id="viewRoomModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Room Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img id="view_room_image" src="" class="img-fluid rounded mb-3" alt="Room Image">
                        </div>
                        <div class="col-md-6">
                            <h4 id="view_room_number" class="mb-2"></h4>
                            <p><span class="badge" id="view_room_status"></span></p>
                            <p class="text-muted mb-2" id="view_room_category"></p>
                            <p class="mb-2"><strong>Price:</strong> ₱<span id="view_room_price"></span> / night</p>
                            <p class="mb-2"><strong>Capacity:</strong> <span id="view_room_capacity"></span> guests</p>
                            <p class="mb-2"><strong>Description:</strong></p>
                            <p id="view_room_description"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Room Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="category_name" class="form-label">Category Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="category_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="category_description" class="form-label">Description <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control" id="category_description" name="description" rows="3"
                                required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Image preview for adding room
            const imageInput = document.getElementById('image');
            const imagePreview = document.getElementById('imagePreview');
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');

            if (imageInput) {
                imageInput.addEventListener('change', function () {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            imagePreview.src = e.target.result;
                            imagePreviewContainer.style.display = 'block';
                        }
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            }

            // Filter rooms by category
            const categoryFilters = document.querySelectorAll('.category-filter');
            const roomItems = document.querySelectorAll('.room-item');

            categoryFilters.forEach(filter => {
                filter.addEventListener('click', function () {
                    const category = this.getAttribute('data-category');

                    // Update active filter button
                    categoryFilters.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');

                    // Filter rooms
                    roomItems.forEach(room => {
                        if (category === 'all' || room.getAttribute('data-category') === category) {
                            room.style.display = 'block';
                        } else {
                            room.style.display = 'none';
                        }
                    });
                });
            });

            // Handle view room modal
            const viewRoomModal = document.getElementById('viewRoomModal');
            if (viewRoomModal) {
                viewRoomModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;

                    // Extract room info
                    const roomNumber = button.getAttribute('data-room-number');
                    const roomImage = button.getAttribute('data-room-image');
                    const roomCategory = button.getAttribute('data-room-category');
                    const roomPrice = button.getAttribute('data-room-price');
                    const roomCapacity = button.getAttribute('data-room-capacity');
                    const roomStatus = button.getAttribute('data-room-status');
                    const roomDescription = button.getAttribute('data-room-description');

                    // Update modal content
                    document.getElementById('view_room_number').textContent = 'Room ' + roomNumber;
                    document.getElementById('view_room_image').src = roomImage;
                    document.getElementById('view_room_category').textContent = roomCategory;
                    document.getElementById('view_room_price').textContent = parseFloat(roomPrice).toLocaleString('en-PH');
                    document.getElementById('view_room_capacity').textContent = roomCapacity;
                    document.getElementById('view_room_description').textContent = roomDescription;

                    const statusBadge = document.getElementById('view_room_status');
                    statusBadge.textContent = roomStatus.charAt(0).toUpperCase() + roomStatus.slice(1);
                    statusBadge.className = 'badge';

                    if (roomStatus === 'available') {
                        statusBadge.classList.add('bg-success');
                    } else if (roomStatus === 'occupied') {
                        statusBadge.classList.add('bg-danger');
                    } else {
                        statusBadge.classList.add('bg-warning');
                    }
                });
            }

            // Handle edit room modal
            const editRoomModal = document.getElementById('editRoomModal');
            if (editRoomModal) {
                editRoomModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;

                    // Extract room info
                    const roomId = button.getAttribute('data-room-id');
                    const roomNumber = button.getAttribute('data-room-number');
                    const roomCategory = button.getAttribute('data-room-category');
                    const roomPrice = button.getAttribute('data-room-price');
                    const roomCapacity = button.getAttribute('data-room-capacity');
                    const roomStatus = button.getAttribute('data-room-status');
                    const roomDescription = button.getAttribute('data-room-description');

                    // Update form values
                    document.getElementById('edit_room_id').value = roomId;
                    document.getElementById('edit_room_number').value = roomNumber;
                    document.getElementById('edit_category_id').value = roomCategory;
                    document.getElementById('edit_price').value = roomPrice;
                    document.getElementById('edit_capacity').value = roomCapacity;
                    document.getElementById('edit_status').value = roomStatus;
                    document.getElementById('edit_description').value = roomDescription;
                });
            }

            // Edit room image preview
            const editImageInput = document.getElementById('edit_image');
            const editImagePreview = document.getElementById('editImagePreview');

            if (editImageInput) {
                editImageInput.addEventListener('change', function () {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            editImagePreview.src = e.target.result;
                        }
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            }
        </script>
    @endpush
@endsection