@extends('layouts.vendor')

@section('title', 'Trip Details')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Trip #{{ $trip->id }}</h5>
    </div>
    <div class="card-body">
        <p><strong>Route:</strong> {{ $trip->route?->name ?? 'Ad-hoc' }}</p>
        <p><strong>Schedule:</strong> {{ $trip->schedule_at }}</p>
        <p><strong>Status:</strong> {{ ucfirst($trip->status->value ?? $trip->status) }}</p>
        <p><strong>Driver:</strong> {{ $trip->driver?->name ?? '-' }}</p>
        <p><strong>Vehicle:</strong> {{ $trip->vehicle?->vehicle_number ?? '-' }}</p>
        <p><strong>Cost:</strong> {{ $trip->cost ?? '-' }}</p>
    </div>
</div>
@endsection


