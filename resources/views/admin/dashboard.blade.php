@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<h4 class="mb-4">Dashboard Overview</h4>

<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card border-left-primary shadow h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-building fa-2x text-primary"></i>
                    </div>
                    <div>
                        <h6 class="card-title text-muted mb-1">Total Vendors Active</h6>
                        <h3 class="mb-0">{{ $totalVendorsActive }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-left-success shadow h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-id-card fa-2x text-success"></i>
                    </div>
                    <div>
                        <h6 class="card-title text-muted mb-1">Total Drivers Active</h6>
                        <h3 class="mb-0">{{ $totalDriversActive }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-left-info shadow h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-car fa-2x text-info"></i>
                    </div>
                    <div>
                        <h6 class="card-title text-muted mb-1">Total Trips Today</h6>
                        <h3 class="mb-0">{{ $totalTripsToday }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-left-warning shadow h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-clock fa-2x text-warning"></i>
                    </div>
                    <div>
                        <h6 class="card-title text-muted mb-1">Pending Trip Approvals</h6>
                        <h3 class="mb-0">{{ $pendingTripApprovals }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <div class="card border-left-success shadow h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-rupee-sign fa-2x text-success"></i>
                    </div>
                    <div>
                        <h6 class="card-title text-muted mb-1">Daily Revenue Summary</h6>
                        <h3 class="mb-0">₹{{ number_format($dailyRevenue, 2) }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Live Trip Status -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-map-marker-alt text-danger"></i> Live Trip Status</h5>
                <span class="badge bg-info">{{ $liveTrips->count() }} Active</span>
            </div>
            <div class="card-body">
                @if($liveTrips->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Trip #</th>
                                <th>Route</th>
                                <th>Driver</th>
                                <th>Vehicle</th>
                                <th>Status</th>
                                <th>Scheduled</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($liveTrips as $trip)
                            <tr>
                                <td><a href="{{ route('admin.trips.show', $trip) }}">#{{ $trip->id }}</a></td>
                                <td>{{ $trip->route->name ?? 'N/A' }}</td>
                                <td>{{ $trip->driver->name ?? 'Unassigned' }}</td>
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
                                <td>{{ $trip->scheduled_time ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center text-muted py-4">
                    <i class="fas fa-check-circle fa-3x mb-2"></i>
                    <p class="mb-0">No live trips at the moment.</p>
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


