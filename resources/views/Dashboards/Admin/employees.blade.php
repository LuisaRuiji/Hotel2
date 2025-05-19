@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h4 mb-0">Employee Management</h2>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
                    <i class="fas fa-plus me-2"></i>Add New Employee
                </button>
            </div>

            <!-- Employee Filters -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-3 align-items-center">
                        <div class="flex-grow-1">
                            <input type="text" class="form-control" id="searchEmployee" placeholder="Search employee name or role...">
                        </div>
                        <div>
                            <select class="form-select" id="filterRole">
                                <option value="">All Roles</option>
                                <option value="receptionist">Receptionist</option>
                                <option value="housekeeping">Housekeeping</option>
                                <option value="manager">Manager</option>
                                <option value="maintenance">Maintenance</option>
                                <option value="security">Security</option>
                            </select>
                        </div>
                        <div>
                            <select class="form-select" id="filterStatus">
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Employees Table -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0">ID</th>
                                    <th class="border-0">Name</th>
                                    <th class="border-0">Role</th>
                                    <th class="border-0">Contact</th>
                                    <th class="border-0">Status</th>
                                    <th class="border-0">Joined</th>
                                    <th class="border-0 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="employeesTable">
                                @forelse($employees ?? [] as $employee)
                                <tr class="employee-row" 
                                    data-name="{{ $employee->name }}" 
                                    data-role="{{ $employee->role }}" 
                                    data-status="{{ $employee->status }}">
                                    <td>{{ $employee->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-2 bg-primary bg-opacity-10 rounded-circle">
                                                <span class="avatar-text text-primary">{{ strtoupper(substr($employee->name, 0, 1)) }}</span>
                                            </div>
                                            <div>
                                                <p class="mb-0 fw-medium">{{ $employee->name }}</p>
                                                <small class="text-muted">{{ $employee->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-capitalize">{{ $employee->role }}</span>
                                    </td>
                                    <td>{{ $employee->phone }}</td>
                                    <td>
                                        <span class="badge bg-{{ $employee->status === 'active' ? 'success' : 'danger' }}">
                                            {{ ucfirst($employee->status) }}
                                        </span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($employee->created_at)->format('M d, Y') }}</td>
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary view-employee" data-bs-toggle="modal" data-bs-target="#viewEmployeeModal"
                                                    data-id="{{ $employee->id }}"
                                                    data-name="{{ $employee->name }}"
                                                    data-email="{{ $employee->email }}"
                                                    data-phone="{{ $employee->phone }}"
                                                    data-role="{{ $employee->role }}"
                                                    data-address="{{ $employee->address }}"
                                                    data-status="{{ $employee->status }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-outline-success edit-employee" data-bs-toggle="modal" data-bs-target="#editEmployeeModal"
                                                    data-id="{{ $employee->id }}"
                                                    data-name="{{ $employee->name }}"
                                                    data-email="{{ $employee->email }}"
                                                    data-phone="{{ $employee->phone }}"
                                                    data-role="{{ $employee->role }}"
                                                    data-address="{{ $employee->address }}"
                                                    data-status="{{ $employee->status }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            @if($employee->status === 'active')
                                            <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deactivateEmployeeModal"
                                                    data-id="{{ $employee->id }}"
                                                    data-name="{{ $employee->name }}">
                                                <i class="fas fa-user-slash"></i>
                                            </button>
                                            @else
                                            <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#activateEmployeeModal"
                                                    data-id="{{ $employee->id }}"
                                                    data-name="{{ $employee->name }}">
                                                <i class="fas fa-user-check"></i>
                                            </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        <i class="fas fa-users me-2"></i>
                                        No employees found
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Employee Modal -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.employees.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="phone" name="phone" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                                <select class="form-select" id="role" name="role" required>
                                    <option value="">Select Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="receptionist">Receptionist</option>
                                    <option value="manager">Manager</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Initial Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <small class="form-text text-muted">Employee can change this after first login.</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Employee</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Employee Modal -->
<div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.employees.update') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_employee_id" name="id">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="edit_email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_phone" name="phone" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_role" class="form-label">Role <span class="text-danger">*</span></label>
                                <select class="form-select" id="edit_role" name="role" required>
                                    <option value="">Select Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="receptionist">Receptionist</option>
                                    <option value="manager">Manager</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="edit_address" class="form-label">Address <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="edit_address" name="address" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="edit_status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select" id="edit_status" name="status" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Update Employee</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Employee Modal -->
<div class="modal fade" id="viewEmployeeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Employee Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-4 text-center">
                        <div class="avatar avatar-lg bg-primary bg-opacity-10 rounded-circle mx-auto mb-3">
                            <span class="avatar-text text-primary h3" id="view_employee_initials"></span>
                        </div>
                        <h4 id="view_employee_name" class="mb-1"></h4>
                        <p class="text-muted" id="view_employee_role"></p>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <p class="mb-1 text-muted small">Employee ID</p>
                            <p class="mb-0 fw-medium" id="view_employee_id_number"></p>
                        </div>
                        <div class="mb-3">
                            <p class="mb-1 text-muted small">Email</p>
                            <p class="mb-0 fw-medium" id="view_employee_email"></p>
                        </div>
                        <div class="mb-3">
                            <p class="mb-1 text-muted small">Phone</p>
                            <p class="mb-0 fw-medium" id="view_employee_phone"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <p class="mb-1 text-muted small">Status</p>
                            <p class="mb-0"><span class="badge" id="view_employee_status"></span></p>
                        </div>
                        <div class="mb-3">
                            <p class="mb-1 text-muted small">Joined Date</p>
                            <p class="mb-0 fw-medium" id="view_employee_joined_date"></p>
                        </div>
                        <div class="mb-3">
                            <p class="mb-1 text-muted small">Address</p>
                            <p class="mb-0 fw-medium" id="view_employee_address"></p>
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

<!-- Deactivate Employee Modal -->
<div class="modal fade" id="deactivateEmployeeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Deactivate Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.employees.deactivate') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="deactivate_employee_id" name="id">
                <div class="modal-body">
                    <p>Are you sure you want to deactivate <span id="deactivate_employee_name" class="fw-bold"></span>?</p>
                    <p class="text-danger">This will prevent them from accessing the system.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Deactivate</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Activate Employee Modal -->
<div class="modal fade" id="activateEmployeeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Activate Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.employees.activate') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="activate_employee_id" name="id">
                <div class="modal-body">
                    <p>Are you sure you want to activate <span id="activate_employee_name" class="fw-bold"></span>?</p>
                    <p class="text-success">This will allow them to access the system again.</p>
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
    // Search and filter functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchEmployee');
        const filterRole = document.getElementById('filterRole');
        const filterStatus = document.getElementById('filterStatus');
        const rows = document.querySelectorAll('.employee-row');
        
        const filterRows = () => {
            const searchTerm = searchInput.value.toLowerCase();
            const roleFilter = filterRole.value.toLowerCase();
            const statusFilter = filterStatus.value.toLowerCase();
            
            rows.forEach(row => {
                const name = row.getAttribute('data-name').toLowerCase();
                const role = row.getAttribute('data-role').toLowerCase();
                const status = row.getAttribute('data-status').toLowerCase();
                
                const matchesSearch = name.includes(searchTerm) || role.includes(searchTerm);
                const matchesRole = roleFilter === '' || role === roleFilter;
                const matchesStatus = statusFilter === '' || status === statusFilter;
                
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
        
        // View employee modal functionality
        const viewEmployeeButtons = document.querySelectorAll('.view-employee');
        viewEmployeeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const email = this.getAttribute('data-email');
                const phone = this.getAttribute('data-phone');
                const role = this.getAttribute('data-role');
                const address = this.getAttribute('data-address');
                const status = this.getAttribute('data-status');
                
                // Set employee data in view modal
                document.getElementById('view_employee_name').textContent = name;
                document.getElementById('view_employee_initials').textContent = name.charAt(0).toUpperCase();
                document.getElementById('view_employee_id_number').textContent = id;
                document.getElementById('view_employee_email').textContent = email;
                document.getElementById('view_employee_phone').textContent = phone;
                document.getElementById('view_employee_role').textContent = role.charAt(0).toUpperCase() + role.slice(1);
                document.getElementById('view_employee_address').textContent = address;
                document.getElementById('view_employee_joined_date').textContent = 'N/A';
                
                const statusBadge = document.getElementById('view_employee_status');
                statusBadge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
                statusBadge.className = 'badge';
                statusBadge.classList.add(status === 'active' ? 'bg-success' : 'bg-danger');
                
                // Store ID for the edit button in view modal
                document.querySelector('.edit-from-view').setAttribute('data-id', id);
            });
        });
        
        // Edit from view modal button
        const editFromViewButton = document.querySelector('.edit-from-view');
        if (editFromViewButton) {
            editFromViewButton.addEventListener('click', function() {
                const employeeId = this.getAttribute('data-id');
                const editButton = document.querySelector(`.edit-employee[data-id="${employeeId}"]`);
                if (editButton) {
                    editButton.click();
                }
            });
        }
        
        // Edit employee modal functionality
        const editEmployeeButtons = document.querySelectorAll('.edit-employee');
        editEmployeeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const email = this.getAttribute('data-email');
                const phone = this.getAttribute('data-phone');
                const role = this.getAttribute('data-role');
                const address = this.getAttribute('data-address');
                const status = this.getAttribute('data-status');
                
                // Set employee data in edit modal
                document.getElementById('edit_employee_id').value = id;
                document.getElementById('edit_name').value = name;
                document.getElementById('edit_email').value = email;
                document.getElementById('edit_phone').value = phone;
                document.getElementById('edit_role').value = role;
                document.getElementById('edit_address').value = address;
                document.getElementById('edit_status').value = status;
            });
        });
        
        // Deactivate employee modal
        const deactivateModal = document.getElementById('deactivateEmployeeModal');
        if (deactivateModal) {
            deactivateModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                
                document.getElementById('deactivate_employee_id').value = id;
                document.getElementById('deactivate_employee_name').textContent = name;
            });
        }
        
        // Activate employee modal
        const activateModal = document.getElementById('activateEmployeeModal');
        if (activateModal) {
            activateModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                
                document.getElementById('activate_employee_id').value = id;
                document.getElementById('activate_employee_name').textContent = name;
            });
        }
    });
</script>
@endpush
@endsection 