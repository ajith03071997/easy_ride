@extends('layouts.admin')

@section('title', 'Support Tickets')

@section('content')
<h4 class="mb-3">Support / Helpdesk</h4>

<div class="card">
    <div class="card-body">
        <table class="table table-striped table-bordered data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Subject</th>
                    <th>Vendor</th>
                    <th>Driver</th>
                    <th>Status</th>
                    <th>Created By</th>
                    <th>Assigned To</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->id }}</td>
                        <td>{{ $ticket->subject }}</td>
                        <td>{{ $ticket->vendor?->company_name }}</td>
                        <td>{{ $ticket->driver?->name }}</td>
                        <td>{{ ucfirst($ticket->status) }}</td>
                        <td>{{ $ticket->creator?->name }}</td>
                        <td>{{ $ticket->assignee?->name }}</td>
                        <td>{{ $ticket->created_at }}</td>
                        <td>
                            <a href="{{ route('admin.support-tickets.show', $ticket) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-comments"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection


