@extends('Dashboards.rooms')

@section('content')
<div class="container mt-4">
    <h1 class="text-2xl font-semibold mb-3">Rooms Dashboard</h1>
    <p class="mb-4">Manage all the rooms in the hotel.</p>

    <!-- Room Statistics -->
    <div class="row mb-4">
        <div class="col-sm-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Rooms</h5>
                    <p class="card-text">50</p>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Available Rooms</h5>
                    <p class="card-text">30</p>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Occupied Rooms</h5>
                    <p class="card-text">15</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Room List -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Room List</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>Room Number</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>101</td>
                        <td>Single</td>
                        <td>$100</td>
                        <td><span class="badge bg-success">Available</span></td>
                        <td>
                            <button class="btn btn-sm btn-info">Edit</button>
                            <button class="btn btn-sm btn-warning">Mark as Unavailable</button>
                        </td>
                    </tr>
                    {{-- Add more room rows as needed --}}
                </tbody>
            </table>
        </div>
    </div>

    <!-- Button to trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRoomModal">
        Add Room
    </button>
</div>

<!-- Modal for Adding Room -->
<div class="modal fade" id="addRoomModal" tabindex="-1" aria-labelledby="addRoomModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addRoomModalLabel">Add New Room</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="/admin/rooms/add" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="mb-3">
            <label for="roomNumber" class="form-label">Room Number</label>
            <input type="text" class="form-control" id="roomNumber" name="roomNumber" required>
          </div>
          <div class="mb-3">
            <label for="roomType" class="form-label">Room Type</label>
            <select class="form-control" id="roomType" name="roomType" required>
              <option value="single">Single</option>
              <option value="double">Double</option>
              <option value="suite">Suite</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="price" class="form-label">Price per Night</label>
            <input type="number" class="form-control" id="price" name="price" required>
          </div>
          <div class="mb-3">
            <label for="roomImage" class="form-label">Room Image</label>
            <input type="file" class="form-control" id="roomImage" name="roomImage" accept="image/*" required>
          </div>
          <button type="submit" class="btn btn-primary">Add Room</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection