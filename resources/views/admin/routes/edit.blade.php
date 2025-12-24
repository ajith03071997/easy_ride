@extends('layouts.admin')

@section('title', 'Edit Route')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Edit Route</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.routes.update', $route) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Vendor</label>
                <select name="vendor_id" class="form-select" required>
                    @foreach($vendors as $vendor)
                        <option value="{{ $vendor->id }}" @selected(old('vendor_id', $route->vendor_id) == $vendor->id)>
                            {{ $vendor->company_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Route Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $route->name) }}">
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Pickup Time</label>
                    <input type="time" name="pickup_time" class="form-control" value="{{ old('pickup_time', $route->pickup_time) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Driver</label>
                    <select name="driver_id" class="form-select">
                        <option value="">-- None --</option>
                        @foreach($drivers as $driver)
                            <option value="{{ $driver->id }}" @selected(old('driver_id', $route->driver_id) == $driver->id)>
                                {{ $driver->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Vehicle</label>
                    <select name="vehicle_id" class="form-select">
                        <option value="">-- None --</option>
                        @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}" @selected(old('vehicle_id', $route->vehicle_id) == $vehicle->id)>
                                {{ $vehicle->vehicle_number }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="weekly_fixed" value="1" id="weekly_fixed"
                       {{ old('weekly_fixed', $route->weekly_fixed) ? 'checked' : '' }}>
                <label class="form-check-label" for="weekly_fixed">
                    Weekly Fixed Route
                </label>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.routes.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection


