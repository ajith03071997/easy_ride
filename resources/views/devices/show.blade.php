@extends('layouts.app')

@section('title', 'Device Details - Easy Ride')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-desktop"></i> Device Details</h1>
    <a href="{{ route('devices.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Devices
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Device Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Name:</strong> {{ $device->name }}</p>
                        <p><strong>Type:</strong> <span class="badge bg-info">{{ $device->device_type }}</span></p>
                        <p><strong>Price per Hour:</strong> {{ $device->single_price_per_hour }} EGP</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Multiplayer Support:</strong>
                            @if($device->supports_multiplayer)
                                <span class="badge bg-success">Yes</span>
                            @else
                                <span class="badge bg-secondary">No</span>
                            @endif
                        </p>
                        <p><strong>Status:</strong>
                            @if($device->device_status === 'Working')
                                <span class="badge bg-success">{{ $device->device_status }}</span>
                            @elseif($device->device_status === 'Maintenance')
                                <span class="badge bg-warning">{{ $device->device_status }}</span>
                            @else
                                <span class="badge bg-danger">{{ $device->device_status }}</span>
                            @endif
                        </p>
                        <p><strong>Created:</strong> {{ $device->created_at->format('d/m/Y h:i A') }}</p>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('devices.edit', $device) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit Device
                </a>
                <form action="{{ route('devices.destroy', $device) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                        <i class="fas fa-trash"></i> Delete Device
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
