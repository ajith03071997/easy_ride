@extends('layouts.admin')

@section('title', 'Ticket #'.$ticket->id)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">{{ $ticket->subject }}</h5>
            </div>
            <div class="card-body">
                <p><strong>Vendor:</strong> {{ $ticket->vendor?->company_name }}</p>
                <p><strong>Driver:</strong> {{ $ticket->driver?->name }}</p>
                <p><strong>Status:</strong> {{ ucfirst($ticket->status) }}</p>
                <p><strong>Created By:</strong> {{ $ticket->creator?->name }}</p>
                <p><strong>Message:</strong></p>
                <p>{{ $ticket->message }}</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Chat</h6>
            </div>
            <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                @foreach($ticket->messages as $message)
                    <div class="mb-2">
                        <strong>{{ $message->user?->name ?? 'System' }}:</strong>
                        <div>{{ $message->message }}</div>
                        <small class="text-muted">{{ $message->created_at }}</small>
                    </div>
                    <hr class="my-1">
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Update Ticket</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.support-tickets.update', $ticket) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-2">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            @foreach(['open','in_progress','resolved','closed'] as $status)
                                <option value="{{ $status }}" @selected($ticket->status === $status)>
                                    {{ ucfirst(str_replace('_',' ',$status)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Reply</label>
                        <textarea name="admin_reply" class="form-control" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


