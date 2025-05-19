<x-app-layout>
    @section('content')
    <div class="container py-4">
        <div class="row">
            <!-- User Info Card -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm rounded">
                    <div class="card-body text-center">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3B82F6&color=fff&size=128"
                             alt="Profile Avatar" class="rounded-circle mb-3" style="width: 100px; height: 100px;">
                        <h4 class="mb-1">{{ Auth::user()->name }}</h4>
                        <p class="text-muted mb-1">{{ Auth::user()->email }}</p>
                        <div class="mb-3">
                            <span class="badge bg-primary">{{ ucfirst(Auth::user()->role) }}</span>
                        </div>
                        <div class="small text-muted">
                            <p class="mb-1"><i class="fas fa-calendar-alt me-2"></i> Joined {{ Auth::user()->created_at->format('M d, Y') }}</p>
                            <p class="mb-0"><i class="fas fa-clock me-2"></i> Last updated {{ Auth::user()->updated_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Profile Forms -->
            <div class="col-md-8">
                <!-- Update Profile Information -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0"><i class="fas fa-user-edit me-2"></i>Profile Information</h5>
                    </div>
                    <div class="card-body">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Update Password -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0"><i class="fas fa-lock me-2"></i>Update Password</h5>
                    </div>
                    <div class="card-body">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Delete Account -->
                <div class="card shadow-sm border-danger">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 text-danger"><i class="fas fa-trash-alt me-2"></i>Delete Account</h5>
                    </div>
                    <div class="card-body">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Button Styling -->
    <style>
        /* Primary button styling (Save buttons) */
        .btn-save {
            background-color: #3B82F6 !important; /* Bootstrap primary blue */
            color: white !important;
            font-weight: 500;
            padding: 0.5rem 1.5rem;
            border-radius: 0.375rem;
            border: none;
            transition: all 0.2s;
            box-shadow: 0 2px 5px rgba(59, 130, 246, 0.3);
        }
        
        .btn-save:hover {
            background-color: #2563eb !important; /* Darker blue on hover */
            box-shadow: 0 4px 10px rgba(59, 130, 246, 0.4);
            transform: translateY(-1px);
        }

        /* Danger button styling (Delete button) */
        .btn-danger {
            background-color: #DC2626 !important;
            color: white !important;
            font-weight: 500;
            padding: 0.5rem 1.5rem;
            border-radius: 0.375rem;
            border: none;
            transition: all 0.2s;
            box-shadow: 0 2px 5px rgba(220, 38, 38, 0.3);
        }
        
        .btn-danger:hover {
            background-color: #B91C1C !important;
            box-shadow: 0 4px 10px rgba(220, 38, 38, 0.4);
            transform: translateY(-1px);
        }

        /* General button styling to override any other buttons */
        button[type="submit"], input[type="submit"] {
            background-color: #3B82F6;
            color: white;
            font-weight: 500;
            padding: 0.5rem 1.5rem;
            border-radius: 0.375rem;
            border: none;
            transition: all 0.2s;
            box-shadow: 0 2px 5px rgba(59, 130, 246, 0.3);
            cursor: pointer;
        }
        
        button[type="submit"]:hover, input[type="submit"]:hover {
            background-color: #2563eb;
            box-shadow: 0 4px 10px rgba(59, 130, 246, 0.4);
            transform: translateY(-1px);
        }

        /* Exception for delete button to keep it red */
        #delete-account button[type="submit"] {
            background-color: #DC2626;
            box-shadow: 0 2px 5px rgba(220, 38, 38, 0.3);
        }
        
        #delete-account button[type="submit"]:hover {
            background-color: #B91C1C;
            box-shadow: 0 4px 10px rgba(220, 38, 38, 0.4);
        }
        
        /* Alert styling */
        .alert {
            padding: 0.75rem 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: 0.375rem;
        }
        
        .alert-danger {
            color: #842029;
            background-color: #F8D7DA;
            border-color: #F5C2C7;
        }
    </style>
    @endsection
</x-app-layout>
