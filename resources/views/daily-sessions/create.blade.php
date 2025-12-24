@extends('layouts.app')

@section('title', 'Start New Session - Easy Ride')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-plus"></i> Start New Daily Session</h1>
    <a href="{{ route('daily-sessions.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Sessions
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Session Information</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('daily-sessions.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="opening_balance" class="form-label">Opening Balance *</label>
                        <input type="number"
                               class="form-control @error('opening_balance') is-invalid @enderror"
                               id="opening_balance"
                               name="opening_balance"
                               step="0.01"
                               min="0"
                               value="{{ old('opening_balance') }}"
                               required>
                        @error('opening_balance')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Enter the opening cash balance for this session.</div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-play"></i> Start Session
                        </button>
                        <a href="{{ route('daily-sessions.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
