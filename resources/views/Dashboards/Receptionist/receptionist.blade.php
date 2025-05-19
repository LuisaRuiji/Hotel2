@extends('layouts.app')

@section('styles')
    <!-- <link rel="stylesheet" href="{{ asset('style.css') }}"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css">
@endsection

@section('sidebar')
    @include('partials.sidebar')
@endsection

@section('content')
<div class="container mt-4">
    <h1 class="text-2xl font-semibold mb-3">Manage Receptionists</h1>
    <p class="mb-4">Here you can manage all the receptionists in the hotel.</p>

    <!-- Button to trigger modal -->
    <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#addReceptionistModal">
        Add Receptionist
    </button>

    <!-- Receptionist List -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Receptionist List</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example Receptionist Data -->
                    <tr>
                        <td>John Doe</td>
                        <td>john.doe@example.com</td>
                        <td><span class="badge bg-success">Active</span></td>
                        <td>
                            <button class="btn btn-sm btn-info">Edit</button>
                            <button class="btn btn-sm btn-danger">Deactivate</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Jane Smith</td>
                        <td>jane.smith@example.com</td>
                        <td><span class="badge bg-danger">Inactive</span></td>
                        <td>
                            <button class="btn btn-sm btn-info">Edit</button>
                            <button class="btn btn-sm btn-success">Activate</button>
                        </td>
                    </tr>
                    <!-- Add more receptionist rows as needed -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal for Adding Receptionist -->
<div class="modal fade" id="addReceptionistModal" tabindex="-1" aria-labelledby="addReceptionistModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addReceptionistModalLabel">Add New Receptionist</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/admin/receptionists/add" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="receptionistName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="receptionistName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="receptionistEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="receptionistEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="receptionistStatus" class="form-label">Status</label>
                        <select class="form-control" id="receptionistStatus" name="status" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Receptionist</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection