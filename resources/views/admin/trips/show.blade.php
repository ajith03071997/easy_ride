@extends('layouts.admin')

@section('title', 'Trip Details')

@section('content')
<div class="card mb-3">
    <div class="card-header">
        <h5 class="mb-0">Trip Details</h5>
    </div>
    <div class="card-body">
        <p><strong>Vendor:</strong> {{ $trip->vendor?->company_name }}</p>
        <p><strong>Route:</strong> {{ $trip->route?->name }}</p>
        <p><strong>Driver:</strong> {{ $trip->driver?->name }}</p>
        <p><strong>Vehicle:</strong> {{ $trip->vehicle?->vehicle_number }}</p>
        <p><strong>Schedule:</strong> {{ $trip->schedule_at }}</p>
        <p><strong>Status:</strong> {{ ucfirst($trip->status->value ?? $trip->status) }}</p>
        <p><strong>Distance (km):</strong> {{ $trip->distance_km }}</p>
        <p><strong>Cost:</strong> {{ $trip->cost }}</p>
    </div>
</div>

@if($trip->completion_report)
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Completion Report</h5>
    </div>
    <div class="card-body">
        <pre class="mb-0">{{ json_encode($trip->completion_report, JSON_PRETTY_PRINT) }}</pre>
    </div>
</div>
@endif
@endsection


