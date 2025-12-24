@extends('layouts.app')

@section('title', 'Edit Daily Session - Easy Ride')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-edit"></i> Edit Daily Session</h1>
    <a href="{{ route('daily-sessions.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Sessions
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Session Information</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('daily-sessions.update', $dailySession) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="user_id" class="form-label">Cashier *</label>
                        <select class="form-select @error('user_id') is-invalid @enderror"
                                id="user_id"
                                name="user_id" required>
                            <option value="">Select Cashier</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id', $dailySession->user_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="opening_balance" class="form-label">Opening Balance *</label>
                        <input type="number"
                               class="form-control @error('opening_balance') is-invalid @enderror"
                               id="opening_balance"
                               name="opening_balance"
                               step="0.01"
                               min="0"
                               value="{{ old('opening_balance', $dailySession->opening_balance) }}" required>
                        @error('opening_balance')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="closing_balance" class="form-label">Closing Balance</label>
                        <input type="number"
                               class="form-control @error('closing_balance') is-invalid @enderror"
                               id="closing_balance"
                               name="closing_balance"
                               step="0.01"
                               min="0"
                               value="{{ old('closing_balance', $dailySession->closing_balance) }}">
                        @error('closing_balance')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="opened_at" class="form-label">Opened At *</label>
                                <input type="datetime-local"
                                       class="form-control @error('opened_at') is-invalid @enderror"
                                       id="opened_at"
                                       name="opened_at"
                                       value="{{ old('opened_at', $dailySession->opened_at->format('Y-m-d\TH:i')) }}" required>
                                @error('opened_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="closed_at" class="form-label">Closed At</label>
                                <input type="datetime-local"
                                       class="form-control @error('closed_at') is-invalid @enderror"
                                       id="closed_at"
                                       name="closed_at"
                                       value="{{ old('closed_at', $dailySession->closed_at ? $dailySession->closed_at->format('Y-m-d\TH:i') : '') }}">
                                @error('closed_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status *</label>
                        <select class="form-select @error('status') is-invalid @enderror"
                                id="status"
                                name="status" required>
                            <option value="">Select Status</option>
                            <option value="OPEN" {{ old('status', $dailySession->status) == 'OPEN' ? 'selected' : '' }}>Open</option>
                            <option value="CLOSED" {{ old('status', $dailySession->status) == 'CLOSED' ? 'selected' : '' }}>Closed</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Session
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
