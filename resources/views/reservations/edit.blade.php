@extends('layouts.app')

@section('title', 'Edit Reservation - Easy Ride')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-edit"></i> Edit Reservation</h1>
    <a href="{{ route('reservations.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Reservations
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Reservation Information</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('reservations.update', $reservation) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="customer_id" class="form-label">Customer *</label>
                        <select class="form-select @error('customer_id') is-invalid @enderror"
                                id="customer_id"
                                name="customer_id" required>
                            <option value="">Select Customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id', $reservation->customer_id) == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('customer_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="device_id" class="form-label">Device *</label>
                        <select class="form-select @error('device_id') is-invalid @enderror"
                                id="device_id"
                                name="device_id" required>
                            <option value="">Select Device</option>
                            @foreach($devices as $device)
                                <option value="{{ $device->id }}" {{ old('device_id', $reservation->device_id) == $device->id ? 'selected' : '' }}>
                                    {{ $device->name }} ({{ $device->device_type }})
                                </option>
                            @endforeach
                        </select>
                        @error('device_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="session_type" class="form-label">Session Type *</label>
                        <select class="form-select @error('session_type') is-invalid @enderror"
                                id="session_type"
                                name="session_type" required>
                            <option value="">Select Session Type</option>
                            <option value="Single" {{ old('session_type', $reservation->session_type) == 'Single' ? 'selected' : '' }}>Single</option>
                            <option value="Multi" {{ old('session_type', $reservation->session_type) == 'Multi' ? 'selected' : '' }}>Multi</option>
                        </select>
                        @error('session_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="start_time" class="form-label">Start Time</label>
                        <input type="datetime-local"
                               class="form-control @error('start_time') is-invalid @enderror"
                               id="start_time"
                               name="start_time"
                               value="{{ old('start_time', $reservation->start_time ? $reservation->start_time->format('Y-m-d\TH:i') : '') }}">
                        @error('start_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="end_time" class="form-label">End Time</label>
                        <input type="datetime-local"
                               class="form-control @error('end_time') is-invalid @enderror"
                               id="end_time"
                               name="end_time"
                               value="{{ old('end_time', $reservation->end_time ? $reservation->end_time->format('Y-m-d\TH:i') : '') }}">
                        @error('end_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status *</label>
                        <select class="form-select @error('status') is-invalid @enderror"
                                id="status"
                                name="status" required>
                            <option value="">Select Status</option>
                            <option value="Pending" {{ old('status', $reservation->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Active" {{ old('status', $reservation->status) == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Completed" {{ old('status', $reservation->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                            <option value="Cancelled" {{ old('status', $reservation->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="activation_is_automatic"
                                   name="activation_is_automatic"
                                   value="1"
                                   {{ old('activation_is_automatic', $reservation->activation_is_automatic) ? 'checked' : '' }}>
                            <label class="form-check-label" for="activation_is_automatic">
                                Activation is Automatic
                            </label>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Reservation
                        </button>
                        <a href="{{ route('reservations.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
