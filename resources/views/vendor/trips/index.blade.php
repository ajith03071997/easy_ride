@extends('layouts.vendor')

@section('title', 'Trips')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Trips</h4>
    <a href="{{ route('vendor.trips.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> New Trip Request
    </a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped table-bordered data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Route</th>
                    <th>Schedule</th>
                    <th>Status</th>
                    <th>Driver</th>
                    <th>Vehicle</th>
                    <th>Cost</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($trips as $trip)
                    <tr>
                        <td>{{ $trip->id }}</td>
                        <td>{{ $trip->route?->name }}</td>
                        <td>{{ $trip->schedule_at }}</td>
                        <td>{{ ucfirst($trip->status->value ?? $trip->status) }}</td>
                        <td>{{ $trip->driver?->name }}</td>
                        <td>{{ $trip->vehicle?->vehicle_number }}</td>
                        <td>{{ $trip->cost }}</td>
                        <td>
                            <a href="{{ route('vendor.trips.show', $trip) }}" class="btn btn-sm btn-outline-info">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection


