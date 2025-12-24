@extends('layouts.app')

@section('title', 'Daily Sessions - Easy Ride')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-calendar-day"></i> Daily Sessions</h1>
    <a href="{{ route('daily-sessions.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Start New Session
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped data-table">
                <thead>
                    <tr>
                        <th>Session</th>
                        <th>Cashier</th>
                        <th>Opened At</th>
                        <th>Status</th>
                        <th>Opening Balance</th>
                        <th>Closing Balance</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sessions as $session)
                    <tr>
                        <td>
                            <strong>Daily #{{ $session->id }}</strong>
                        </td>
                        <td>{{ $session->user->name }}</td>
                        <td>{{ $session->opened_at->format('d/m/Y h:i A') }}</td>
                        <td>
                            @if($session->status === 'OPEN')
                                <span class="badge bg-success">{{ $session->status }}</span>
                            @else
                                <span class="badge bg-secondary">{{ $session->status }}</span>
                            @endif
                        </td>
                        <td>{{ $session->opening_balance }} EGP</td>
                        <td>
                            @if($session->closing_balance)
                                {{ $session->closing_balance }} EGP
                            @else
                                ---
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('daily-sessions.details', $session) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Details
                                </a>
                                @if($session->status === 'OPEN')
                                    <a href="{{ route('daily-sessions.edit', $session) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                @endif
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
