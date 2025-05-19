@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-11">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="h4 mb-0">Transaction History</h2>
                    <div>
                        <button class="btn btn-outline-primary me-2" id="exportCSV">
                            <i class="fas fa-file-csv me-2"></i>Export CSV
                        </button>
                        <button class="btn btn-outline-danger" id="exportPDF">
                            <i class="fas fa-file-pdf me-2"></i>Export PDF
                        </button>
                    </div>
                </div>

                <!-- Transaction Filters -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="dateFilter" class="form-label small">Date Range</label>
                                <select class="form-select" id="dateFilter">
                                    <option value="all">All Time</option>
                                    <option value="today">Today</option>
                                    <option value="week">This Week</option>
                                    <option value="month" selected>This Month</option>
                                    <option value="custom">Custom Range</option>
                                </select>
                            </div>
                            <div class="col-md-6" id="customDateContainer" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="startDate" class="form-label small">Start Date</label>
                                        <input type="date" class="form-control" id="startDate">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="endDate" class="form-label small">End Date</label>
                                        <input type="date" class="form-control" id="endDate">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="transactionType" class="form-label small">Transaction Type</label>
                                <select class="form-select" id="transactionType">
                                    <option value="all">All Types</option>
                                    <option value="payment">Payment</option>
                                    <option value="refund">Refund</option>
                                    <option value="deposit">Deposit</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="paymentMethod" class="form-label small">Payment Method</label>
                                <select class="form-select" id="paymentMethod">
                                    <option value="all">All Methods</option>
                                    <option value="cash">Cash</option>
                                    <option value="credit_card">Credit Card</option>
                                    <option value="debit_card">Debit Card</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="receptionist" class="form-label small">Receptionist</label>
                                <select class="form-select" id="receptionist">
                                    <option value="all">All Receptionists</option>
                                    @foreach($receptionists ?? [] as $receptionist)
                                        <option value="{{ $receptionist->id }}">{{ $receptionist->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="searchTransaction" class="form-label small">Search</label>
                                <input type="text" class="form-control" id="searchTransaction"
                                    placeholder="Search by invoice #, guest name or room">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transaction Summary -->
                <div class="row g-4 mb-4">
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="text-muted mb-1">Total Revenue</h6>
                                        <h3 class="mb-0">₱{{ number_format($totalRevenue ?? 0, 2) }}</h3>
                                    </div>
                                    <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                        <i class="fas fa-money-bill-wave text-success"></i>
                                    </div>
                                </div>
                                <small class="text-muted">For selected period</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="text-muted mb-1">Total Transactions</h6>
                                        <h3 class="mb-0">{{ $totalTransactions ?? 0 }}</h3>
                                    </div>
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                        <i class="fas fa-receipt text-primary"></i>
                                    </div>
                                </div>
                                <small class="text-muted">For selected period</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="text-muted mb-1">Average Transaction</h6>
                                        <h3 class="mb-0">₱{{ number_format($averageTransaction ?? 0, 2) }}</h3>
                                    </div>
                                    <div class="bg-info bg-opacity-10 rounded-circle p-3">
                                        <i class="fas fa-chart-line text-info"></i>
                                    </div>
                                </div>
                                <small class="text-muted">For selected period</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="text-muted mb-1">Refunds</h6>
                                        <h3 class="mb-0">₱{{ number_format($totalRefunds ?? 0, 2) }}</h3>
                                    </div>
                                    <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                                        <i class="fas fa-undo-alt text-danger"></i>
                                    </div>
                                </div>
                                <small class="text-muted">For selected period</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transactions Table -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" id="transactionsTable">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0">Invoice #</th>
                                        <th class="border-0">Date & Time</th>
                                        <th class="border-0">Guest</th>
                                        <th class="border-0">Room</th>
                                        <th class="border-0">Method</th>
                                        <th class="border-0">Amount</th>
                                        <th class="border-0 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transactions ?? [] as $transaction)
                                        <tr class="transaction-row" data-invoice="{{ $transaction->invoice_number }}"
                                            data-guest="{{ $transaction->guest_name }}"
                                            data-room="{{ $transaction->room_number }}"
                                            data-method="{{ $transaction->payment_method }}"
                                            data-receptionist="{{ $transaction->receptionist_id }}">
                                            <td>
                                                <span class="fw-medium">{{ $transaction->invoice_number }}</span>
                                            </td>
                                            <td>
                                                <div>
                                                    <p class="mb-0">
                                                        {{ \Carbon\Carbon::parse($transaction->created_at)->format('M d, Y') }}
                                                    </p>
                                                    <small
                                                        class="text-muted">{{ \Carbon\Carbon::parse($transaction->created_at)->format('h:i A') }}</small>
                                                </div>
                                            </td>
                                            <td>{{ $transaction->guest_name }}</td>
                                            <td>{{ $transaction->room_number }}</td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $transaction->payment_method === 'cash' ? 'success' : ($transaction->payment_method === 'credit' ? 'danger' : 'info') }}">
                                                    {{ ucfirst($transaction->payment_method) }}
                                                </span>
                                            </td>
                                            <!-- <td>
                                                                                <span
                                                                                    class="text-capitalize">{{ str_replace('_', ' ', $transaction->payment_method) }}</span>
                                                                            </td> -->
                                            <td>
                                                <span
                                                    class="fw-medium {{ $transaction->payment_method === 'credit' ? 'text-danger' : '' }}">
                                                    {{ $transaction->payment_method === 'refund' ? '-' : '' }}₱{{ number_format($transaction->amount, 2) }}
                                                </span>
                                            </td>
                                            <!-- <td>{{ $transaction->receptionist_name }}</td> -->
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-outline-primary view-transaction"
                                                    data-bs-toggle="modal" data-bs-target="#viewTransactionModal"
                                                    data-id="{{ $transaction->id }}"
                                                    data-invoice="{{ $transaction->invoice_number }}"
                                                    data-date="{{ \Carbon\Carbon::parse($transaction->created_at)->format('M d, Y h:i A') }}"
                                                    data-guest="{{ $transaction->guest_name }}"
                                                    data-room="{{ $transaction->room_number }}"
                                                    data-method="{{ $transaction->payment_method }}"
                                                    data-amount="{{ $transaction->amount }}"
                                                    data-receptionist="{{ $transaction->receptionist_name }}"
                                                    data-description="{{ $transaction->description }}"
                                                    data-reference="{{ $transaction->reference_number }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <a href="{{ route('admin.transactions.print', $transaction->id) }}"
                                                    class="btn btn-sm btn-outline-secondary" target="_blank">
                                                    <i class="fas fa-print"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-4 text-muted">
                                                <i class="fas fa-receipt me-2"></i>
                                                No transactions found
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-0 text-muted small">Showing <span
                                        id="shownTransactions">{{ count($transactions ?? []) }}</span> of <span
                                        id="totalTransactionsCount">{{ $totalTransactions ?? 0 }}</span> transactions</p>
                            </div>
                            <div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- View Transaction Modal -->
    <div class="modal fade" id="viewTransactionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Transaction Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h4 class="mb-1">Invoice <span id="view_invoice" class="fw-medium"></span></h4>
                                <p id="view_date" class="text-muted mb-3"></p>

                                <div class="mb-3">
                                    <p class="mb-1 text-muted small">Guest</p>
                                    <p id="view_guest" class="mb-0 fw-medium"></p>
                                </div>

                                <div class="mb-3">
                                    <p class="mb-1 text-muted small">Room</p>
                                    <p id="view_room" class="mb-0 fw-medium"></p>
                                </div>

                                <div class="mb-3">
                                    <p class="mb-1 text-muted small">Transaction Type</p>
                                    <p class="mb-0"><span class="badge" id="view_type"></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="bg-light p-3 rounded text-center mb-3">
                                    <p class="mb-1 text-muted small">Amount</p>
                                    <h3 class="mb-0" id="view_amount"></h3>
                                </div>

                                <div class="mb-3">
                                    <p class="mb-1 text-muted small">Payment Method</p>
                                    <p id="view_method" class="mb-0 fw-medium text-capitalize"></p>
                                </div>

                                <div class="mb-3">
                                    <p class="mb-1 text-muted small">Reference Number</p>
                                    <p id="view_reference" class="mb-0 fw-medium"></p>
                                </div>

                                <div class="mb-3">
                                    <p class="mb-1 text-muted small">Processed By</p>
                                    <p id="view_receptionist" class="mb-0 fw-medium"></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <hr class="my-3">
                            <div class="mb-3">
                                <p class="mb-1 text-muted small">Description</p>
                                <p id="view_description" class="mb-0"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="#" id="printTransactionBtn" class="btn btn-primary" target="_blank">
                        <i class="fas fa-print me-1"></i> Print Receipt
                    </a>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Date range filter
                const dateFilter = document.getElementById('dateFilter');
                const customDateContainer = document.getElementById('customDateContainer');

                if (dateFilter) {
                    dateFilter.addEventListener('change', function () {
                        if (this.value === 'custom') {
                            customDateContainer.style.display = 'block';
                        } else {
                            customDateContainer.style.display = 'none';
                        }

                        // Here you would typically trigger the filtering
                        applyFilters();
                    });
                }

                // Handle filter changes
                const transactionType = document.getElementById('transactionType');
                const paymentMethod = document.getElementById('paymentMethod');
                const receptionist = document.getElementById('receptionist');
                const searchTransaction = document.getElementById('searchTransaction');
                const startDate = document.getElementById('startDate');
                const endDate = document.getElementById('endDate');

                const filterElements = [transactionType, paymentMethod, receptionist, searchTransaction, startDate, endDate];

                filterElements.forEach(element => {
                    if (element) {
                        element.addEventListener(element.tagName === 'INPUT' ? 'input' : 'change', applyFilters);
                    }
                });

                function applyFilters() {
                    const searchTerm = searchTransaction ? searchTransaction.value.toLowerCase() : '';
                    const typeFilter = transactionType ? transactionType.value : 'all';
                    const methodFilter = paymentMethod ? paymentMethod.value : 'all';
                    const receptionistFilter = receptionist ? receptionist.value : 'all';

                    const rows = document.querySelectorAll('.transaction-row');
                    let visibleCount = 0;

                    rows.forEach(row => {
                        const invoice = row.getAttribute('data-invoice').toLowerCase();
                        const guest = row.getAttribute('data-guest').toLowerCase();
                        const room = row.getAttribute('data-room').toLowerCase();
                        const type = row.getAttribute('data-type');
                        const method = row.getAttribute('data-method');
                        const receptionistId = row.getAttribute('data-receptionist');

                        const matchesSearch = invoice.includes(searchTerm) ||
                            guest.includes(searchTerm) ||
                            room.includes(searchTerm);
                        const matchesType = typeFilter === 'all' || type === typeFilter;
                        const matchesMethod = methodFilter === 'all' || method === methodFilter;
                        const matchesReceptionist = receptionistFilter === 'all' || receptionistId === receptionistFilter;

                        // Date filtering would be handled here if required

                        if (matchesSearch && matchesType && matchesMethod && matchesReceptionist) {
                            row.style.display = '';
                            visibleCount++;
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    // Update visible count
                    const shownTransactions = document.getElementById('shownTransactions');
                    if (shownTransactions) {
                        shownTransactions.textContent = visibleCount;
                    }
                }

                // View transaction modal
                const viewTransactionModal = document.getElementById('viewTransactionModal');
                if (viewTransactionModal) {
                    viewTransactionModal.addEventListener('show.bs.modal', function (event) {
                        const button = event.relatedTarget;
                        const id = button.getAttribute('data-id');
                        const invoice = button.getAttribute('data-invoice');
                        const date = button.getAttribute('data-date');
                        const guest = button.getAttribute('data-guest');
                        const room = button.getAttribute('data-room');
                        const type = button.getAttribute('data-type');
                        const method = button.getAttribute('data-method');
                        const amount = button.getAttribute('data-amount');
                        const receptionist = button.getAttribute('data-receptionist');
                        const description = button.getAttribute('data-description');
                        const reference = button.getAttribute('data-reference');

                        // Set transaction data in view modal
                        document.getElementById('view_invoice').textContent = invoice;
                        document.getElementById('view_date').textContent = date;
                        document.getElementById('view_guest').textContent = guest;
                        document.getElementById('view_room').textContent = room;
                        document.getElementById('view_method').textContent = method.replace('_', ' ');
                        document.getElementById('view_receptionist').textContent = receptionist;
                        document.getElementById('view_description').textContent = description || 'No description provided';
                        document.getElementById('view_reference').textContent = reference || 'N/A';

                        // Format the amount with negative sign for refunds
                        const formattedAmount = type === 'refund' ?
                            '-₱' + parseFloat(amount).toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) :
                            '₱' + parseFloat(amount).toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

                        document.getElementById('view_amount').textContent = formattedAmount;
                        document.getElementById('view_amount').className = type === 'refund' ? 'mb-0 text-danger' : 'mb-0';

                        // Set type badge
                        const typeBadge = document.getElementById('view_type');
                        typeBadge.textContent = type.charAt(0).toUpperCase() + type.slice(1);
                        typeBadge.className = 'badge';

                        if (type === 'payment') {
                            typeBadge.classList.add('bg-success');
                        } else if (type === 'refund') {
                            typeBadge.classList.add('bg-danger');
                        } else {
                            typeBadge.classList.add('bg-info');
                        }

                        // Update print button URL
                        document.getElementById('printTransactionBtn').href = `/admin/transactions/${id}/print`;
                    });
                }

                // Export buttons
                const exportCSV = document.getElementById('exportCSV');
                const exportPDF = document.getElementById('exportPDF');

                if (exportCSV) {
                    exportCSV.addEventListener('click', function () {
                        // Construct URL with current filters
                        let url = '/admin/transactions/export/csv';
                        url = appendFiltersToURL(url);
                        window.location.href = url;
                    });
                }

                if (exportPDF) {
                    exportPDF.addEventListener('click', function () {
                        // Construct URL with current filters
                        let url = '/admin/transactions/export/pdf';
                        url = appendFiltersToURL(url);
                        window.location.href = url;
                    });
                }

                // Helper function to append filters to export URLs
                function appendFiltersToURL(url) {
                    const params = new URLSearchParams();

                    if (dateFilter && dateFilter.value) {
                        params.append('date_filter', dateFilter.value);

                        if (dateFilter.value === 'custom') {
                            if (startDate && startDate.value) params.append('start_date', startDate.value);
                            if (endDate && endDate.value) params.append('end_date', endDate.value);
                        }
                    }

                    if (transactionType && transactionType.value !== 'all') {
                        params.append('type', transactionType.value);
                    }

                    if (paymentMethod && paymentMethod.value !== 'all') {
                        params.append('method', paymentMethod.value);
                    }

                    if (receptionist && receptionist.value !== 'all') {
                        params.append('receptionist', receptionist.value);
                    }

                    if (searchTransaction && searchTransaction.value) {
                        params.append('search', searchTransaction.value);
                    }

                    const queryString = params.toString();
                    return queryString ? `${url}?${queryString}` : url;
                }
            });
        </script>
    @endpush
@endsection