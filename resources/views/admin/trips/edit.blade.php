@extends('layouts.admin')

@section('title', 'Edit Trip')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Edit Trip</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.trips.update', $trip) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Route</label>
                <select name="route_id" class="form-select">
                    <option value="">-- None --</option>
                    @foreach($routes as $route)
                        <option value="{{ $route->id }}" @selected(old('route_id', $trip->route_id) == $route->id)>
                            {{ $route->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Driver</label>
                    <select name="driver_id" class="form-select">
                        <option value="">-- None --</option>
                        @foreach($drivers as $driver)
                            <option value="{{ $driver->id }}" @selected(old('driver_id', $trip->driver_id) == $driver->id)>
                                {{ $driver->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Vehicle</label>
                    <select name="vehicle_id" class="form-select">
                        <option value="">-- None --</option>
                        @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}" @selected(old('vehicle_id', $trip->vehicle_id) == $vehicle->id)>
                                {{ $vehicle->vehicle_number }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    @foreach(['pending','approved','assigned','accepted','started','completed','cancelled','delayed'] as $status)
                        <option value="{{ $status }}" @selected(old('status', $trip->status->value ?? $trip->status) == $status)>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.trips.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection


