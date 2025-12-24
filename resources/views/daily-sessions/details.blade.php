@extends('layouts.app')

@section('title', 'Session Details - Easy Ride')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-calendar-day"></i> Session Details #{{ $session->id }}</h1>
    <a href="{{ route('daily-sessions.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Sessions
    </a>
</div>

<!-- Session Info -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Session Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <strong>Cashier:</strong> {{ $session->user->name }}
                    </div>
                    <div class="col-md-3">
                        <strong>Opened at:</strong> {{ $session->opened_at->format('d/m/Y h:i A') }}
                    </div>
                    <div class="col-md-3">
                        <strong>Status:</strong>
                        <span class="badge bg-{{ $session->status === 'OPEN' ? 'success' : 'secondary' }}">
                            {{ $session->status }}
                        </span>
                    </div>
                    @if($session->closed_at)
                    <div class="col-md-3">
                        <strong>Closed at:</strong> {{ $session->closed_at->format('d/m/Y h:i A') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title text-primary">Session Count</h5>
                <h2 class="text-primary">{{ $sessionCount }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title text-warning">Ongoing Sessions</h5>
                <h2 class="text-warning">{{ $ongoingSessions }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title text-success">Ended Sessions</h5>
                <h2 class="text-success">{{ $endedSessions }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title text-info">Sessions Sales</h5>
                <h2 class="text-info">{{ $sessionsSales }} EGP</h2>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title text-primary">Extensions</h5>
                <h2 class="text-primary">{{ $extensions }} EGP</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title text-secondary">Extra Time</h5>
                <h2 class="text-secondary">0</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title text-success">Products</h5>
                <h2 class="text-success">{{ $products }} EGP</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title text-danger">Expenses</h5>
                <h2 class="text-danger">{{ $expensesTotal }} EGP</h2>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title text-warning">Discounts</h5>
                <h2 class="text-warning">{{ $discounts }} EGP</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title text-success">Total Sales</h5>
                <h2 class="text-success">{{ $totalSales }} EGP</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title text-primary">Net</h5>
                <h2 class="text-primary">{{ $net }} EGP</h2>
            </div>
        </div>
    </div>
</div>

<!-- Device Sessions -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Device Sessions</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Device</th>
                                <th>Customer</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($deviceSessions as $deviceSession)
                            <tr>
                                <td>{{ $deviceSession->device->name }}</td>
                                <td>{{ $deviceSession->customer->name }}</td>
                                <td>{{ $deviceSession->start_time->format('h:i A') }}</td>
                                <td>{{ $deviceSession->end_time ? $deviceSession->end_time->format('h:i A') : '-' }}</td>
                                <td>{{ $deviceSession->total_amount }} EGP</td>
                                <td>
                                    <span class="badge bg-{{ $deviceSession->status === 'Active' ? 'success' : 'secondary' }}">
                                        {{ $deviceSession->status }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No device sessions found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Expenses -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Expense List</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Amount</th>
                                <th>Note</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($expenses as $expense)
                            <tr>
                                <td>{{ $expense->expenseCategory->name }}</td>
                                <td>{{ $expense->amount }} EGP</td>
                                <td>{{ $expense->note ?? '-' }}</td>
                                <td>{{ $expense->created_at->format('d/m/Y h:i A') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No expenses found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
