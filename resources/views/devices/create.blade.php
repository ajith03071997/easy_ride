@extends('layouts.app')

@section('title', 'Add Device - Easy Ride')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-plus"></i> Add Device</h1>
    <a href="{{ route('devices.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Devices
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Device Information</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('devices.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Device Name *</label>
                        <input type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               id="name"
                               name="name"
                               value="{{ old('name') }}" referrerpolicy="no-referrer">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="single_price_per_hour" class="form-label">Single Price per Hour *</label>
                        <input type="number"
                               class="form-control @error('single_price_per_hour') is-invalid @enderror"
                               id="single_price_per_hour"
                               name="single_price_per_hour"
                               step="0.01"
                               min="0"
                               value="{{ old('single_price_per_hour') }}" required>
                        @error('single_price_per_hour')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="supports_multiplayer"
                                   name="supports_multiplayer"
                                   value="1"
                                   {{ old('supports_multiplayer') ? 'checked' : '' }}>
                            <label class="form-check-label" for="supports_multiplayer">
                                Support Multiplayer
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="device_type" class="form-label">Device Type *</label>
                        <select class="form-select @error('device_type') is-invalid @enderror"
                                id="device_type"
                                name="device_type" required>
                            <option value="">Select Device Type</option>
                            <option value="PlayStation" {{ old('device_type') == 'PlayStation' ? 'selected' : '' }}>PlayStation</option>
                            <option value="Room" {{ old('device_type') == 'Room' ? 'selected' : '' }}>Room</option>
                            <option value="Computer" {{ old('device_type') == 'Computer' ? 'selected' : '' }}>Computer</option>
                            <option value="Ping Pong" {{ old('device_type') == 'Ping Pong' ? 'selected' : '' }}>Ping Pong</option>
                            <option value="Billiards" {{ old('device_type') == 'Billiards' ? 'selected' : '' }}>Billiards</option>
                        </select>
                        @error('device_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="device_status" class="form-label">Device Status *</label>
                        <select class="form-select @error('device_status') is-invalid @enderror"
                                id="device_status"
                                name="device_status" required>
                            <option value="">Select Status</option>
                            <option value="Working" {{ old('device_status') == 'Working' ? 'selected' : '' }}>Working</option>
                            <option value="Maintenance" {{ old('device_status') == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                            <option value="Stopped" {{ old('device_status') == 'Stopped' ? 'selected' : '' }}>Stopped</option>
                        </select>
                        @error('device_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Device
                        </button>
                        <a href="{{ route('devices.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
