@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-11">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="h4 mb-0">User Management</h2>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        <i class="fas fa-plus me-2"></i>Add New User
                    </button>
                </div>

                <!-- User Filters -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-3 align-items-center">
                            <div class="flex-grow-1">
                                <input type="text" class="form-control" id="searchUser"
                                    placeholder="Search by name or email...">
                            </div>
                            <div>
                                <select class="form-select" id="filterRole">
                                    <option value="all">All Roles</option>
                                    <option value="admin">Admin</option>
                                    <option value="receptionist">Receptionist</option>
                                    <option value="customer">Customer</option>
                                </select>
                            </div>
                            <div>
                                <select class="form-select" id="filterStatus">
                                    <option value="all">All Status</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Users Table -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0">User</th>
                                        <th class="border-0">Role</th>
                                        <th class="border-0">Email</th>
                                        <th class="border-0">Created</th>
                                        <th class="border-0 text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="usersTable">
                                    @forelse($users ?? [] as $user)
                                        <tr class="user-row" data-name="{{ $user->name }}" data-email="{{ $user->email }}"
                                            data-role="{{ $user->role }}" data-status="{{ $user->status }}">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div
                                                        class="avatar avatar-sm me-2 bg-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'receptionist' ? 'primary' : 'success') }} bg-opacity-10 rounded-circle">
                                                        <span
                                                            class="avatar-text text-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'receptionist' ? 'primary' : 'success') }}">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                                    </div>
                                                    <div>
                                                        <p class="mb-0 fw-medium">{{ $user->name }}</p>
                                                        <small class="text-muted">@if($user->employee_id)
                                                            ID: {{ $user->employee_id }}
                                                        @else

                                                            @endif</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'receptionist' ? 'primary' : 'success') }} bg-opacity-10 text-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'receptionist' ? 'primary' : 'success') }}">
                                                    {{ ucfirst($user->role) }}
                                                </span>
                                            </td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ \Carbon\Carbon::parse($user->created_at)->format('M d, Y') }}</td>
                                            <td class="text-end">
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-outline-success edit-user" data-bs-toggle="modal"
                                                        data-bs-target="#editUserModal" data-id="{{ $user->id }}"
                                                        data-name="{{ $user->name }}" data-email="{{ $user->email }}"
                                                        data-role="{{ $user->role }}" data-phone="{{ $user->phone ?? '' }}"
                                                        data-address="{{ $user->address ?? '' }}"
                                                        data-status="{{ $user->status }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>

                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4 text-muted">
                                                <i class="fas fa-users me-2"></i>
                                                No users found
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if(isset($users) && $users->hasPages())
                        <div class="card-footer bg-white border-0 py-3">
                            {{ $users->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password <span
                                            class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                                    <select class="form-select" id="role" name="role" required>
                                        <option value="">Select Role</option>
                                        <option value="admin">Admin</option>
                                        <option value="receptionist">Receptionist</option>
                                        <option value="customer">Customer</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.users.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_user_id" name="id">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_name" class="form-label">Full Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit_name" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_email" class="form-label">Email <span
                                            class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="edit_email" name="email" required>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_role" class="form-label">Role <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="edit_role" name="role" required>
                                        <option value="admin">Admin</option>
                                        <option value="receptionist">Receptionist</option>
                                        <option value="customer">Customer</option>
                                    </select>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success">Update User</button>
                            </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View User Modal -->
    <div class="modal fade" id="viewUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">User Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 text-center mb-4">
                            <div class="avatar avatar-lg bg-primary bg-opacity-10 rounded-circle mx-auto mb-3">
                                <span class="avatar-text text-primary h3" id="view_user_initials"></span>
                            </div>
                            <h4 id="view_user_name" class="mb-1"></h4>
                            <p id="view_user_email" class="text-muted"></p>
                            <span class="badge" id="view_user_role_badge"></span>
                            <span class="badge ms-2" id="view_user_status_badge"></span>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <p class="mb-1 text-muted small">Phone</p>
                                <p class="mb-0 fw-medium" id="view_user_phone"></p>
                            </div>
                            <div class="mb-3">
                                <p class="mb-1 text-muted small">Address</p>
                                <p class="mb-0 fw-medium" id="view_user_address"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <p class="mb-1 text-muted small">Account Created</p>
                                <p class="mb-0 fw-medium" id="view_user_created"></p>
                            </div>
                            <div class="mb-3">
                                <p class="mb-1 text-muted small">Last Login</p>
                                <p class="mb-0 fw-medium" id="view_user_last_login"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success edit-from-view" data-bs-dismiss="modal">Edit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reset Password Modal -->
    <div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reset Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.users.reset-password') }}" method="POST">
                    @csrf
                    <input type="hidden" id="reset_user_id" name="id">
                    <div class="modal-body">
                        <p>You are about to reset the password for <span id="reset_user_name" class="fw-bold"></span>.</p>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password <span
                                    class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="new_password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password <span
                                    class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="confirm_password" name="password_confirmation"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Reset Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Deactivate User Modal -->
    <div class="modal fade" id="deactivateUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Deactivate User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.users.deactivate') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="deactivate_user_id" name="id">
                    <div class="modal-body">
                        <p>Are you sure you want to deactivate <span id="deactivate_user_name" class="fw-bold"></span>?</p>
                        <p class="text-danger">This will prevent them from logging into the system.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Deactivate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Activate User Modal -->
    <div class="modal fade" id="activateUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Activate User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.users.activate') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="activate_user_id" name="id">
                    <div class="modal-body">
                        <p>Are you sure you want to activate <span id="activate_user_name" class="fw-bold"></span>?</p>
                        <p class="text-success">This will allow them to log into the system again.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Activate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Search and filter functionality
                const searchInput = document.getElementById('searchUser');
                const filterRole = document.getElementById('filterRole');
                const filterStatus = document.getElementById('filterStatus');
                const rows = document.querySelectorAll('.user-row');

                const filterRows = () => {
                    const searchTerm = searchInput.value.toLowerCase();
                    const roleFilter = filterRole.value.toLowerCase();
                    const statusFilter = filterStatus.value.toLowerCase();

                    rows.forEach(row => {
                        const name = row.getAttribute('data-name').toLowerCase();
                        const email = row.getAttribute('data-email').toLowerCase();
                        const role = row.getAttribute('data-role').toLowerCase();
                        const status = row.getAttribute('data-status').toLowerCase();

                        const matchesSearch = name.includes(searchTerm) || email.includes(searchTerm);
                        const matchesRole = roleFilter === 'all' || role === roleFilter;
                        const matchesStatus = statusFilter === 'all' || status === statusFilter;

                        if (matchesSearch && matchesRole && matchesStatus) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                };

                if (searchInput) searchInput.addEventListener('input', filterRows);
                if (filterRole) filterRole.addEventListener('change', filterRows);
                if (filterStatus) filterStatus.addEventListener('change', filterRows);

                // View user modal functionality
                const viewUserButtons = document.querySelectorAll('.view-user');
                viewUserButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        const name = this.getAttribute('data-name');
                        const email = this.getAttribute('data-email');
                        const role = this.getAttribute('data-role');
                        const phone = this.getAttribute('data-phone');
                        const address = this.getAttribute('data-address');
                        const created = this.getAttribute('data-created');
                        const lastLogin = this.getAttribute('data-last-login');
                        const status = this.getAttribute('data-status');

                        // Set user data in view modal
                        document.getElementById('view_user_name').textContent = name;
                        document.getElementById('view_user_initials').textContent = name.charAt(0).toUpperCase();
                        document.getElementById('view_user_email').textContent = email;
                        document.getElementById('view_user_phone').textContent = phone || 'Not provided';
                        document.getElementById('view_user_address').textContent = address || 'Not provided';
                        document.getElementById('view_user_created').textContent = created;
                        document.getElementById('view_user_last_login').textContent = lastLogin;

                        // Set role badge
                        const roleBadge = document.getElementById('view_user_role_badge');
                        roleBadge.textContent = role.charAt(0).toUpperCase() + role.slice(1);
                        roleBadge.className = 'badge';

                        if (role === 'admin') {
                            roleBadge.classList.add('bg-danger');
                        } else if (role === 'receptionist') {
                            roleBadge.classList.add('bg-primary');
                        } else {
                            roleBadge.classList.add('bg-success');
                        }

                        // Set status badge
                        const statusBadge = document.getElementById('view_user_status_badge');
                        statusBadge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
                        statusBadge.className = 'badge';
                        statusBadge.classList.add(status === 'active' ? 'bg-success' : 'bg-danger');

                        // Store ID for the edit button in view modal
                        document.querySelector('.edit-from-view').setAttribute('data-id', this.getAttribute('data-id'));
                    });
                });

                // Edit from view modal button
                const editFromViewButton = document.querySelector('.edit-from-view');
                if (editFromViewButton) {
                    editFromViewButton.addEventListener('click', function () {
                        const userId = this.getAttribute('data-id');
                        const editButton = document.querySelector(`.edit-user[data-id="${userId}"]`);
                        if (editButton) {
                            editButton.click();
                        }
                    });
                }

                // Edit user modal functionality
                const editUserButtons = document.querySelectorAll('.edit-user');
                editUserButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        const id = this.getAttribute('data-id');
                        const name = this.getAttribute('data-name');
                        const email = this.getAttribute('data-email');
                        const role = this.getAttribute('data-role');
                        const phone = this.getAttribute('data-phone');
                        const address = this.getAttribute('data-address');
                        const status = this.getAttribute('data-status');

                        // Set user data in edit modal
                        document.getElementById('edit_user_id').value = id;
                        document.getElementById('edit_name').value = name;
                        document.getElementById('edit_email').value = email;
                        document.getElementById('edit_role').value = role;
                        document.getElementById('edit_phone').value = phone;
                        document.getElementById('edit_address').value = address;
                        document.getElementById('edit_status').value = status;
                    });
                });

                // Reset password modal
                const resetPasswordModal = document.getElementById('resetPasswordModal');
                if (resetPasswordModal) {
                    resetPasswordModal.addEventListener('show.bs.modal', function (event) {
                        const button = event.relatedTarget;
                        const id = button.getAttribute('data-id');
                        const name = button.getAttribute('data-name');

                        document.getElementById('reset_user_id').value = id;
                        document.getElementById('reset_user_name').textContent = name;
                    });
                }

                // Deactivate user modal
                const deactivateModal = document.getElementById('deactivateUserModal');
                if (deactivateModal) {
                    deactivateModal.addEventListener('show.bs.modal', function (event) {
                        const button = event.relatedTarget;
                        const id = button.getAttribute('data-id');
                        const name = button.getAttribute('data-name');

                        document.getElementById('deactivate_user_id').value = id;
                        document.getElementById('deactivate_user_name').textContent = name;
                    });
                }

                // Activate user modal
                const activateModal = document.getElementById('activateUserModal');
                if (activateModal) {
                    activateModal.addEventListener('show.bs.modal', function (event) {
                        const button = event.relatedTarget;
                        const id = button.getAttribute('data-id');
                        const name = button.getAttribute('data-name');

                        document.getElementById('activate_user_id').value = id;
                        document.getElementById('activate_user_name').textContent = name;
                    });
                }

                // Password confirmation validation
                const newPassword = document.getElementById('new_password');
                const confirmPassword = document.getElementById('confirm_password');

                if (confirmPassword) {
                    confirmPassword.addEventListener('input', function () {
                        if (this.value !== newPassword.value) {
                            this.setCustomValidity('Passwords do not match');
                        } else {
                            this.setCustomValidity('');
                        }
                    });
                }

                if (newPassword) {
                    newPassword.addEventListener('input', function () {
                        if (confirmPassword.value !== '' && confirmPassword.value !== this.value) {
                            confirmPassword.setCustomValidity('Passwords do not match');
                        } else {
                            confirmPassword.setCustomValidity('');
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection