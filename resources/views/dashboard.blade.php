@extends('layouts.app')

@section('title', 'Dashboard - Easy Ride')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
    <div class="d-flex gap-2">
        <button type="button" class="btn btn-info" onclick="window.location.href='{{ route('daily-sessions.index') }}'">
            <i class="fas fa-calendar-day"></i> Session Details
        </button>
        @if($currentSession)
            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#closeSessionModal">
                <i class="fas fa-times-circle"></i> Close Daily Session
            </button>
        @endif
    </div>
</div>

<!-- Device Summary Cards -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title text-primary">
                    <i class="fas fa-desktop"></i> Total Devices
                </h5>
                <h2 class="text-primary">{{ $totalDevices }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title text-success">
                    <i class="fas fa-play-circle"></i> Running
                </h5>
                <h2 class="text-success">{{ $runningDevices }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title text-info">
                    <i class="fas fa-pause-circle"></i> Available
                </h5>
                <h2 class="text-info">{{ $availableDevices }}</h2>
            </div>
        </div>
    </div>
</div>

<!-- Current Session Info -->
@if($currentSession)
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-calendar-day"></i> Current Daily Session
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <strong>Cashier:</strong> {{ $currentSession->user->name }}
                    </div>
                    <div class="col-md-3">
                        <strong>Opened at:</strong> {{ $currentSession->opened_at->format('d/m/Y h:i A') }}
                    </div>
                    <div class="col-md-3">
                        <strong>Opening Balance:</strong> {{ $currentSession->opening_balance }} EGP
                    </div>
                    <div class="col-md-3">
                        <strong>Status:</strong>
                        <span class="badge bg-success">{{ $currentSession->status }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="text-muted">No active session found</h5>
                <p class="text-muted">Start a new daily session to begin tracking.</p>
                <a href="{{ route('daily-sessions.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Start New Session
                </a>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Quick Stats -->
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-line"></i> Today's Summary
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <h6>Session Count</h6>
                        <h4 class="text-primary">0</h4>
                    </div>
                    <div class="col-6">
                        <h6>Ongoing Sessions</h6>
                        <h4 class="text-warning">0</h4>
                    </div>
                </div>
                <hr>
                <div class="row text-center">
                    <div class="col-6">
                        <h6>Sessions Sales</h6>
                        <h4 class="text-success">0 EGP</h4>
                    </div>
                    <div class="col-6">
                        <h6>Products Sales</h6>
                        <h4 class="text-info">0 EGP</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-calculator"></i> Financial Summary
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <h6>Total Sales</h6>
                        <h4 class="text-success">0 EGP</h4>
                    </div>
                    <div class="col-6">
                        <h6>Expenses</h6>
                        <h4 class="text-danger">0 EGP</h4>
                    </div>
                </div>
                <hr>
                <div class="row text-center">
                    <div class="col-12">
                        <h6>Net Profit</h6>
                        <h4 class="text-primary">0 EGP</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Close Session Modal -->
@if($currentSession)
<div class="modal fade" id="closeSessionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-times-circle"></i> Close Daily Session
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('dashboard.close-session') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="closing_balance" class="form-label">Closing Balance</label>
                        <input type="number"
                               class="form-control"
                               id="closing_balance"
                               name="closing_balance"
                               step="0.01"
                               required>
                        <div class="form-text">Enter the closing balance for this session.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Confirm Close Session</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection
