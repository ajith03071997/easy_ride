@extends('layouts.vendor')

@section('title', 'Raise Support Ticket')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Raise Ticket</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('vendor.support-tickets.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Subject</label>
                <input type="text" name="subject" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Message</label>
                <textarea name="message" class="form-control" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="{{ route('vendor.support-tickets.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection


