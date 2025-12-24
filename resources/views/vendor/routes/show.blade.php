@extends('layouts.vendor')

@section('title', 'Route Details')

@section('content')
<div class="card mb-3">
    <div class="card-header">
        <h5 class="mb-0">Route Details</h5>
    </div>
    <div class="card-body">
        <p><strong>Name:</strong> {{ $route->name }}</p>
        <p><strong>Pickup Time:</strong> {{ $route->pickup_time }}</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h6 class="mb-0">Pickup / Drop Points</h6>
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


