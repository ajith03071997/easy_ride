@extends('layouts.app')

@section('title', 'Devices - Easy Ride')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-desktop"></i> Devices</h1>
    <a href="{{ route('devices.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Device
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Price/Hour</th>
                        <th>Multiplayer</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($devices as $device)
                    <tr>
                        <td>{{ $device->id }}</td>
                        <td>{{ $device->name }}</td>
                        <td>
                            <span class="badge bg-info">{{ $device->device_type }}</span>
                        </td>
                        <td>{{ $device->single_price_per_hour }} EGP</td>
                        <td>
                            @if($device->supports_multiplayer)
                                <span class="badge bg-success">Yes</span>
                            @else
                                <span class="badge bg-secondary">No</span>
                            @endif
                        </td>
                        <td>
                            @if($device->device_status === 'Working')
                                <span class="badge bg-success">{{ $device->device_status }}</span>
                            @elseif($device->device_status === 'Maintenance')
                                <span class="badge bg-warning">{{ $device->device_status }}</span>
                            @else
                                <span class="badge bg-danger">{{ $device->device_status }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('devices.show', $device) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('devices.edit', $device) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('devices.destroy', $device) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
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
