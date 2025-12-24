@extends('layouts.admin')

@section('title', 'Trips')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Trips</h4>
</div>

<!-- Filters -->
<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.trips.index') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="pending" @selected(request('status') == 'pending')>Pending</option>
                    <option value="approved" @selected(request('status') == 'approved')>Approved</option>
                    <option value="assigned" @selected(request('status') == 'assigned')>Assigned</option>
                    <option value="accepted" @selected(request('status') == 'accepted')>Accepted</option>
                    <option value="started" @selected(request('status') == 'started')>Started</option>
                    <option value="completed" @selected(request('status') == 'completed')>Completed</option>
                    <option value="cancelled" @selected(request('status') == 'cancelled')>Cancelled</option>
                    <option value="delayed" @selected(request('status') == 'delayed')>Delayed</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Trip Type</label>
                <select name="trip_type" class="form-select">
                    <option value="">All Types</option>
                    <option value="single" @selected(request('trip_type') == 'single')>Single Trip</option>
                    <option value="weekly" @selected(request('trip_type') == 'weekly')>Weekly Fixed</option>
                    <option value="special" @selected(request('trip_type') == 'special')>Special Request</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Date</label>
                <input type="date" name="date" class="form-control" value="{{ request('date') }}">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="fas fa-filter"></i> Filter
                </button>
                <a href="{{ route('admin.trips.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Clear
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped table-bordered data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Type</th>
                    <th>Vendor</th>
                    <th>Route</th>
                    <th>Driver</th>
                    <th>Vehicle</th>
                    <th>Schedule</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($trips as $trip)
                    <tr>
                        <td>{{ $trip->id }}</td>
                        <td>
                            @if($trip->trip_type == 'weekly')
                                <span class="badge bg-success">Weekly</span>
                            @elseif($trip->trip_type == 'special')
                                <span class="badge bg-danger">Special</span>
                                @if($trip->priority == 'urgent')
                                    <span class="badge bg-warning">Urgent</span>
                                @endif
                            @else
                                <span class="badge bg-secondary">Single</span>
                            @endif
                        </td>
                        <td>{{ $trip->vendor?->company_name ?? '-' }}</td>
                        <td>{{ $trip->route?->name ?? 'Ad-hoc' }}</td>
                        <td>{{ $trip->driver?->name ?? '-' }}</td>
                        <td>{{ $trip->vehicle?->vehicle_number ?? '-' }}</td>
                        <td>
                            {{ $trip->scheduled_date ? \Carbon\Carbon::parse($trip->scheduled_date)->format('d M Y') : ($trip->schedule_at ? $trip->schedule_at->format('d M Y') : '-') }}
                            <br>
                            <small class="text-muted">{{ $trip->scheduled_time ?? ($trip->schedule_at ? $trip->schedule_at->format('H:i') : '') }}</small>
                        </td>
                        <td>
                            @php
                                $statusValue = is_object($trip->status) ? $trip->status->value : $trip->status;
                                $statusColors = [
                                    'pending' => 'warning',
                                    'approved' => 'info',
                                    'assigned' => 'secondary',
                                    'accepted' => 'primary',
                                    'started' => 'primary',
                                    'completed' => 'success',
                                    'cancelled' => 'danger',
                                    'delayed' => 'warning',
                                ];
                            @endphp
                            <span class="badge bg-{{ $statusColors[$statusValue] ?? 'dark' }}">
                                {{ ucfirst($statusValue) }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.trips.show', $trip) }}" class="btn btn-outline-info" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.trips.edit', $trip) }}" class="btn btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @php $statusValue = is_object($trip->status) ? $trip->status->value : $trip->status; @endphp
                                @if($statusValue == 'pending')
                                <form action="{{ route('admin.trips.approve', $trip) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-success" title="Approve">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                @endif
                                @if(!in_array($statusValue, ['completed', 'cancelled']))
                                <form action="{{ route('admin.trips.cancel', $trip) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to cancel this trip?');">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger" title="Cancel">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection


