@extends('layouts.app')

@section('title', 'Reservation Details - Easy Ride')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-calendar-check"></i> Reservation Details</h1>
    <a href="{{ route('reservations.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Reservations
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Reservation Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Reservation ID:</strong> #{{ $reservation->id }}</p>
                        <p><strong>Customer:</strong> {{ $reservation->customer->name }}</p>
                        <p><strong>Device:</strong> {{ $reservation->device->name }}</p>
                        <p><strong>Session Type:</strong>
                            <span class="badge bg-info">{{ $reservation->session_type }}</span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Start Time:</strong>
                            @if($reservation->start_time)
                                {{ $reservation->start_time->format('d/m/Y h:i A') }}
                            @else
                                <span class="text-muted">Not set</span>
                            @endif
                        </p>
                        <p><strong>End Time:</strong>
                            @if($reservation->end_time)
                                {{ $reservation->end_time->format('d/m/Y h:i A') }}
                            @else
                                <span class="text-muted">Not set</span>
                            @endif
                        </p>
                        <p><strong>Auto Activation:</strong>
                            @if($reservation->activation_is_automatic)
                                <span class="badge bg-success">Yes</span>
                            @else
                                <span class="badge bg-secondary">No</span>
                            @endif
                        </p>
                        <p><strong>Status:</strong>
                            @if($reservation->status === 'Pending')
                                <span class="badge bg-warning">{{ $reservation->status }}</span>
                            @elseif($reservation->status === 'Active')
                                <span class="badge bg-success">{{ $reservation->status }}</span>
                            @elseif($reservation->status === 'Completed')
                                <span class="badge bg-info">{{ $reservation->status }}</span>
                            @else
                                <span class="badge bg-danger">{{ $reservation->status }}</span>
                            @endif
                        </p>
                    </div>
                </div>
                <div class="mt-3">
                    <p><strong>Created:</strong> {{ $reservation->created_at->format('d/m/Y h:i A') }}</p>
                    @if($reservation->updated_at != $reservation->created_at)
                        <p><strong>Last Updated:</strong> {{ $reservation->updated_at->format('d/m/Y h:i A') }}</p>
                    @endif
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('reservations.edit', $reservation) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit Reservation
                </a>
                <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                        <i class="fas fa-trash"></i> Delete Reservation
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
