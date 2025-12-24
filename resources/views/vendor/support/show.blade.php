@extends('layouts.vendor')

@section('title', 'Ticket #'.$ticket->id)

@section('content')
<div class="card mb-3">
    <div class="card-header">
        <h5 class="mb-0">{{ $ticket->subject }}</h5>
    </div>
    <div class="card-body">
        <p><strong>Status:</strong> {{ ucfirst($ticket->status) }}</p>
        <p><strong>Message:</strong></p>
        <p>{{ $ticket->message }}</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h6 class="mb-0">Conversation</h6>
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
@endsection


