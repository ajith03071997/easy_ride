@extends('layouts.admin')

@section('title', 'Create Route')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Create Route</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.routes.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Vendor</label>
                <select name="vendor_id" class="form-select" required>
                    @foreach($vendors as $vendor)
                        <option value="{{ $vendor->id }}" @selected(old('vendor_id') == $vendor->id)>
                            {{ $vendor->company_name }}
                        </option>
                    @endforeach
                </select>
                @error('vendor_id')<small class="text-danger">{{ $message }}</small>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Route Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Pickup Time</label>
                    <input type="time" name="pickup_time" class="form-control" value="{{ old('pickup_time') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Driver</label>
                    <select name="driver_id" class="form-select">
                        <option value="">-- None --</option>
                        @foreach($drivers as $driver)
                            <option value="{{ $driver->id }}" @selected(old('driver_id') == $driver->id)>
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
                            <option value="{{ $vehicle->id }}" @selected(old('vehicle_id') == $vehicle->id)>
                                {{ $vehicle->vehicle_number }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="weekly_fixed" value="1" id="weekly_fixed" {{ old('weekly_fixed') ? 'checked' : '' }}>
                <label class="form-check-label" for="weekly_fixed">
                    Weekly Fixed Route
                </label>
            </div>

            <hr>
            <h6>Route Points</h6>

            <div id="points-wrapper">
                <div class="row g-2 mb-2 point-row">
                    <div class="col-md-3">
                        <select name="points[0][type]" class="form-select" required>
                            <option value="pickup">Pickup</option>
                            <option value="drop">Drop</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <input type="text" name="points[0][location]" class="form-control" placeholder="Location" required>
                    </div>
                    <div class="col-md-3">
                        <input type="time" name="points[0][time]" class="form-control">
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-sm btn-outline-secondary mb-3" id="add-point">
                <i class="fas fa-plus"></i> Add Point
            </button>

            <div>
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('admin.routes.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    (function () {
        let index = 1;
        document.getElementById('add-point').addEventListener('click', function () {
            const wrapper = document.getElementById('points-wrapper');
            const row = document.createElement('div');
            row.className = 'row g-2 mb-2 point-row';
            row.innerHTML = `
                <div class="col-md-3">
                    <select name="points[${index}][type]" class="form-select" required>
                        <option value="pickup">Pickup</option>
                        <option value="drop">Drop</option>
                    </select>
                </div>
                <div class="col-md-5">
                    <input type="text" name="points[${index}][location]" class="form-control" placeholder="Location" required>
                </div>
                <div class="col-md-3">
                    <input type="time" name="points[${index}][time]" class="form-control">
                </div>
            `;
            wrapper.appendChild(row);
            index++;
        });
    })();
</script>
@endsection


