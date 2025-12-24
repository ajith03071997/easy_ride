@extends('layouts.app')

@section('title', 'Daily Session Details - Easy Ride')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-calendar-day"></i> Daily Session Details</h1>
    <a href="{{ route('daily-sessions.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Sessions
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Session Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Session ID:</strong> #{{ $dailySession->id }}</p>
                        <p><strong>Cashier:</strong> {{ $dailySession->user->name }}</p>
                        <p><strong>Opening Balance:</strong> {{ $dailySession->opening_balance }} EGP</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Status:</strong>
                            @if($dailySession->status === 'OPEN')
                                <span class="badge bg-success">{{ $dailySession->status }}</span>
                            @else
                                <span class="badge bg-danger">{{ $dailySession->status }}</span>
                            @endif
                        </p>
                        <p><strong>Opened At:</strong> {{ $dailySession->opened_at->format('d/m/Y h:i A') }}</p>
                        @if($dailySession->closed_at)
                            <p><strong>Closed At:</strong> {{ $dailySession->closed_at->format('d/m/Y h:i A') }}</p>
                        @endif
                    </div>
                </div>

                @if($dailySession->closing_balance !== null)
                <div class="mt-3">
                    <p><strong>Closing Balance:</strong> {{ $dailySession->closing_balance }} EGP</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Session Count</h6>
                                <h4 class="mb-0">{{ $deviceSessions->count() }}</h4>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-play fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Total Sales</h6>
                                <h4 class="mb-0">{{ $deviceSessions->sum('total_amount') }} EGP</h4>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-dollar-sign fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Total Expenses</h6>
                                <h4 class="mb-0">{{ $expenses->sum('amount') }} EGP</h4>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-receipt fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Net Profit</h6>
                                <h4 class="mb-0">{{ $deviceSessions->sum('total_amount') - $expenses->sum('amount') }} EGP</h4>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-chart-line fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Expenses List -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">Expenses for This Session</h5>
            </div>
            <div class="card-body">
                @if($expenses->count() > 0)
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
                                @foreach($expenses as $expense)
                                <tr>
                                    <td>{{ $expense->expenseCategory->name }}</td>
                                    <td>{{ $expense->amount }} EGP</td>
                                    <td>{{ $expense->note ?? 'No note' }}</td>
                                    <td>{{ $expense->created_at->format('d/m/Y h:i A') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">No expenses recorded for this session.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
