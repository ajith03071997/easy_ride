@extends('layouts.app')

@section('title', 'Reservations - Easy Ride')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-calendar-check"></i> Reservations</h1>
    <a href="{{ route('reservations.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Reservation
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">All Reservations</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="reservationsTable" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Device</th>
                        <th>Session Type</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Auto Activation</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->id }}</td>
                        <td>{{ $reservation->customer->name }}</td>
                        <td>{{ $reservation->device->name }}</td>
                        <td>
                            <span class="badge bg-info">{{ $reservation->session_type }}</span>
                        </td>
                        <td>
                            @if($reservation->start_time)
                                {{ $reservation->start_time->format('d/m/Y h:i A') }}
                            @else
                                <span class="text-muted">Not set</span>
                            @endif
                        </td>
                        <td>
                            @if($reservation->end_time)
                                {{ $reservation->end_time->format('d/m/Y h:i A') }}
                            @else
                                <span class="text-muted">Not set</span>
                            @endif
                        </td>
                        <td>
                            @if($reservation->activation_is_automatic)
                                <span class="badge bg-success">Yes</span>
                            @else
                                <span class="badge bg-secondary">No</span>
                            @endif
                        </td>
                        <td>
                            @if($reservation->status === 'Pending')
                                <span class="badge bg-warning">{{ $reservation->status }}</span>
                            @elseif($reservation->status === 'Active')
                                <span class="badge bg-success">{{ $reservation->status }}</span>
                            @elseif($reservation->status === 'Completed')
                                <span class="badge bg-info">{{ $reservation->status }}</span>
                            @else
                                <span class="badge bg-danger">{{ $reservation->status }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('reservations.show', $reservation) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('reservations.edit', $reservation) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('#reservationsTable').DataTable({
        responsive: true,
        pageLength: 25,
        order: [[0, 'desc']]
    });
});
</script>
@endsection
