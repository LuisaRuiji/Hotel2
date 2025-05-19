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
    <h1 class="text-2xl font-semibold mb-3">Manage Services</h1>
    <p class="mb-4">Here you can manage all the services offered by the hotel.</p>

    <!-- Button to trigger modal -->
    <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#addServiceModal">
        Add Service
    </button>

    <!-- Services List -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Service List</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>Service Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example Service Data -->
                    <tr>
                        <td>Spa Treatment</td>
                        <td>Relaxing full-body massage</td>
                        <td>P100.00</td>
                        <td>
                            <button class="btn btn-sm btn-info">Edit</button>
                            <button class="btn btn-sm btn-danger">Remove</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Room Service</td>
                        <td>24/7 room service available</td>
                        <td>P20.00</td>
                        <td>
                            <button class="btn btn-sm btn-info">Edit</button>
                            <button class="btn btn-sm btn-danger">Remove</button>
                        </td>
                    </tr>
                    <!-- Add more service rows as needed -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal for Adding Service -->
<div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addServiceModalLabel">Add New Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/admin/services/add" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="serviceName" class="form-label">Service Name</label>
                        <input type="text" class="form-control" id="serviceName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="serviceDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="serviceDescription" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="servicePrice" class="form-label">Price</label>
                        <input type="number" class="form-control" id="servicePrice" name="price" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Service</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection