@extends('layouts.admin')

@section('title', 'Route Details')

@section('content')
<div class="card mb-3">
    <div class="card-header">
        <h5 class="mb-0">Route Details</h5>
    </div>
    <div class="card-body">
        <p><strong>Name:</strong> {{ $route->name }}</p>
        <p><strong>Vendor:</strong> {{ $route->vendor?->company_name }}</p>
        <p><strong>Pickup Time:</strong> {{ $route->pickup_time }}</p>
        <p><strong>Driver:</strong> {{ $route->driver?->name }}</p>
        <p><strong>Vehicle:</strong> {{ $route->vehicle?->vehicle_number }}</p>
        <p><strong>Weekly Fixed:</strong> {{ $route->weekly_fixed ? 'Yes' : 'No' }}</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Route Points</h5>
    </div>
    <div class="card-body">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Type</th>
                    <th>Location</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach($route->points as $point)
                    <tr>
                        <td>{{ $point->sequence + 1 }}</td>
                        <td>{{ ucfirst($point->type) }}</td>
                        <td>{{ $point->location }}</td>
                        <td>{{ $point->time }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection


