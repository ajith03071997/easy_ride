@extends('layouts.admin')

@section('title', 'Billing & Payments')

@section('content')
<h4 class="mb-3">Billing & Payments</h4>

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-left-warning shadow h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-file-invoice fa-2x text-warning"></i>
                    </div>
                    <div>
                        <h6 class="card-title text-muted mb-1">Pending Invoices</h6>
                        <h4 class="mb-0">₹{{ number_format($totalPendingInvoices, 2) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-left-success shadow h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-wallet fa-2x text-success"></i>
                    </div>
                    <div>
                        <h6 class="card-title text-muted mb-1">Driver Payments (This Month)</h6>
                        <h4 class="mb-0">₹{{ number_format($totalDriverPaymentsThisMonth, 2) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-left-danger shadow h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-receipt fa-2x text-danger"></i>
                    </div>
                    <div>
                        <h6 class="card-title text-muted mb-1">Expenses (This Month)</h6>
                        <h4 class="mb-0">₹{{ number_format($totalExpensesThisMonth, 2) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-file-invoice-dollar"></i> Generate Vendor Invoice</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.billing.generate-vendor-invoice') }}">
                    @csrf
                    <div class="mb-2">
                        <label class="form-label">Vendor</label>
                        <select name="vendor_id" class="form-select" required>
                            <option value="">Select Vendor</option>
                            @foreach($vendors as $vendor)
                                <option value="{{ $vendor->id }}">{{ $vendor->company_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label class="form-label">Period From</label>
                            <input type="date" name="period_start" class="form-control" required>
                        </div>
                        <div class="col">
                            <label class="form-label">Period To</label>
                            <input type="date" name="period_end" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Payment Due (Days)</label>
                        <select name="due_days" class="form-select">
                            <option value="15">15 Days</option>
                            <option value="30" selected>30 Days</option>
                            <option value="45">45 Days</option>
                            <option value="60">60 Days</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Generate Invoice
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-money-bill-wave"></i> Record Driver Payment</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.billing.driver-payments.store') }}">
                    @csrf
                    <div class="mb-2">
                        <label class="form-label">Driver</label>
                        <select name="driver_id" class="form-select" required>
                            <option value="">Select Driver</option>
                            @foreach($drivers as $driver)
                                <option value="{{ $driver->id }}">{{ $driver->name }} ({{ $driver->mobile }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label class="form-label">Date</label>
                            <input type="date" name="payment_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col">
                            <label class="form-label">Amount (₹)</label>
                            <input type="number" step="0.01" name="amount" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label class="form-label">Frequency</label>
                            <select name="frequency" class="form-select">
                                <option value="daily">Daily</option>
                                <option value="weekly">Weekly</option>
                            </select>
                        </div>
                        <div class="col">
                            <label class="form-label">Remarks</label>
                            <input type="text" name="remarks" class="form-control" placeholder="Optional">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Record Payment
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Invoices Table -->
<div class="card mb-3">
    <div class="card-header">
        <h6 class="mb-0"><i class="fas fa-list"></i> Vendor Invoices</h6>
    </div>
    <div class="card-body">
        <table class="table table-striped table-bordered data-table">
            <thead>
                <tr>
                    <th>Invoice #</th>
                    <th>Vendor</th>
                    <th>Period</th>
                    <th>Amount</th>
                    <th>Due Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoices as $invoice)
                    <tr>
                        <td>{{ $invoice->invoice_number }}</td>
                        <td>{{ $invoice->vendor?->company_name ?? '-' }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($invoice->period_start)->format('d M') }} -
                            {{ \Carbon\Carbon::parse($invoice->period_end)->format('d M Y') }}
                        </td>
                        <td>₹{{ number_format($invoice->payable_amount, 2) }}</td>
                        <td>
                            @if($invoice->due_date)
                                @php
                                    $dueDate = \Carbon\Carbon::parse($invoice->due_date);
                                    $isOverdue = $dueDate->isPast() && $invoice->status !== 'paid';
                                @endphp
                                <span class="{{ $isOverdue ? 'text-danger fw-bold' : '' }}">
                                    {{ $dueDate->format('d M Y') }}
                                    @if($isOverdue)
                                        <i class="fas fa-exclamation-triangle"></i>
                                    @endif
                                </span>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @php
                                $statusColors = [
                                    'pending' => 'secondary',
                                    'sent' => 'warning',
                                    'paid' => 'success',
                                    'cancelled' => 'danger',
                                ];
                            @endphp
                            <span class="badge bg-{{ $statusColors[$invoice->status] ?? 'dark' }}">
                                {{ ucfirst($invoice->status) }}
                            </span>
                        </td>
                        <td>
                            @if($invoice->status === 'pending')
                            <form action="{{ route('admin.billing.invoices.send', $invoice) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-primary" title="Send to Vendor">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </form>
                            @endif
                            @if(in_array($invoice->status, ['pending', 'sent']))
                            <form action="{{ route('admin.billing.invoices.mark-paid', $invoice) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-success" title="Mark as Paid">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-wallet"></i> Recent Driver Payments</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Driver</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Frequency</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($driverPayments as $payment)
                            <tr>
                                <td>{{ $payment->driver?->name ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</td>
                                <td>₹{{ number_format($payment->amount, 2) }}</td>
                                <td>{{ ucfirst($payment->frequency ?? '-') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="fas fa-receipt"></i> Expenses Tracker</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.billing.expenses.store') }}" class="row g-2 mb-3">
                    @csrf
                    <div class="col-md-3">
                        <select name="type" class="form-select form-select-sm" required>
                            <option value="">Type</option>
                            <option value="fuel">Fuel</option>
                            <option value="maintenance">Maintenance</option>
                            <option value="toll">Toll</option>
                            <option value="parking">Parking</option>
                            <option value="insurance">Insurance</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="number" step="0.01" name="amount" class="form-control form-control-sm" placeholder="Amount" required>
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="expense_date" class="form-control form-control-sm" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="remarks" class="form-control form-control-sm" placeholder="Remarks">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-sm btn-primary w-100">Add</button>
                    </div>
                </form>

                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($expenses->take(10) as $expense)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($expense->expense_date)->format('d M') }}</td>
                                <td>{{ ucfirst($expense->type) }}</td>
                                <td>₹{{ number_format($expense->amount, 2) }}</td>
                                <td>{{ Str::limit($expense->remarks, 20) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .border-left-warning { border-left: 4px solid #f6c23e !important; }
    .border-left-success { border-left: 4px solid #1cc88a !important; }
    .border-left-danger { border-left: 4px solid #e74a3b !important; }
</style>
@endsection


