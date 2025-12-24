@extends('layouts.vendor')

@section('title', 'Vendor Dashboard')

@section('content')
<h4 class="mb-4">Dashboard</h4>

<div class="row">
    <div class="col-md-4 mb-3">
        <div class="card border-left-primary shadow h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-car fa-2x text-primary"></i>
                    </div>
                    <div>
                        <h6 class="card-title text-muted mb-1">Total Trips Today</h6>
                        <h3 class="mb-0">{{ $totalTripsToday }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card border-left-info shadow h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-route fa-2x text-info"></i>
                    </div>
                    <div>
                        <h6 class="card-title text-muted mb-1">Live Trips</h6>
                        <h3 class="mb-0">{{ $liveTrips->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card border-left-success shadow h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-id-card fa-2x text-success"></i>
                    </div>
                    <div>
                        <h6 class="card-title text-muted mb-1">Active Drivers</h6>
                        <h3 class="mb-0">{{ $driversAssigned->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment Due Alerts -->
@if($pendingInvoices->count() > 0)
<div class="row">
    <div class="col-12 mb-3">
        <div class="alert alert-warning d-flex align-items-center" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <div>
                <strong>Payment Due!</strong> You have {{ $pendingInvoices->count() }} invoice(s) due within 7 days.
                <a href="{{ route('vendor.billing.index') }}" class="alert-link">View Invoices</a>
            </div>
        </div>
    </div>
</div>
@endif

<div class="row">
    <!-- Next Scheduled Trips -->
    <div class="col-md-6 mb-4">
        <div class="card shadow h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-calendar-alt text-primary"></i> Next Scheduled Trips</h5>
                <a href="{{ route('vendor.trips.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                @if($nextScheduledTrips->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Route</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($nextScheduledTrips as $trip)
                            <tr>
                                <td>{{ $trip->route->name ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($trip->scheduled_date)->format('d M') }}</td>
                                <td>{{ $trip->scheduled_time ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-{{ $trip->status == 'pending' ? 'warning' : 'info' }}">
                                        {{ ucfirst($trip->status) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center text-muted py-3">
                    <i class="fas fa-calendar-check fa-2x mb-2"></i>
                    <p class="mb-0">No upcoming trips scheduled.</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Live Trip Tracking -->
    <div class="col-md-6 mb-4">
        <div class="card shadow h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-map-marker-alt text-danger"></i> Live Trip Tracking</h5>
                <span class="badge bg-info">{{ $liveTrips->count() }} Active</span>
            </div>
            <div class="card-body">
                @if($liveTrips->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Route</th>
                                <th>Driver</th>
                                <th>Vehicle</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($liveTrips as $trip)
                            <tr>
                                <td>{{ $trip->route->name ?? 'N/A' }}</td>
                                <td>{{ $trip->driver->name ?? 'N/A' }}</td>
                                <td>{{ $trip->vehicle->vehicle_number ?? 'N/A' }}</td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'assigned' => 'secondary',
                                            'accepted' => 'info',
                                            'started' => 'primary',
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $statusColors[$trip->status] ?? 'dark' }}">
                                        {{ ucfirst($trip->status) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center text-muted py-3">
                    <i class="fas fa-check-circle fa-2x mb-2"></i>
                    <p class="mb-0">No live trips at the moment.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Driver Assigned -->
    <div class="col-md-6 mb-4">
        <div class="card shadow h-100">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-users text-success"></i> Drivers Assigned</h5>
            </div>
            <div class="card-body">
                @if($driversAssigned->count() > 0)
                <ul class="list-group list-group-flush">
                    @foreach($driversAssigned as $driver)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $driver->name }}</strong>
                            <small class="text-muted d-block">{{ $driver->mobile }}</small>
                        </div>
                        <span class="badge bg-success">Active</span>
                    </li>
                    @endforeach
                </ul>
                @else
                <div class="text-center text-muted py-3">
                    <i class="fas fa-user-slash fa-2x mb-2"></i>
                    <p class="mb-0">No drivers assigned.</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Vehicle Details -->
    <div class="col-md-6 mb-4">
        <div class="card shadow h-100">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-truck text-info"></i> Vehicle Details</h5>
            </div>
            <div class="card-body">
                @if($vehicleDetails->count() > 0)
                <ul class="list-group list-group-flush">
                    @foreach($vehicleDetails as $vehicle)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $vehicle->vehicle_number }}</strong>
                            <small class="text-muted d-block">{{ $vehicle->vehicle_type }} - {{ $vehicle->vehicle_model ?? 'N/A' }}</small>
                        </div>
                        <span class="badge bg-success">Active</span>
                    </li>
                    @endforeach
                </ul>
                @else
                <div class="text-center text-muted py-3">
                    <i class="fas fa-car-side fa-2x mb-2"></i>
                    <p class="mb-0">No vehicles assigned.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
    .border-left-primary { border-left: 4px solid #4e73df !important; }
    .border-left-success { border-left: 4px solid #1cc88a !important; }
    .border-left-info { border-left: 4px solid #36b9cc !important; }
    .border-left-warning { border-left: 4px solid #f6c23e !important; }
</style>
@endsection


