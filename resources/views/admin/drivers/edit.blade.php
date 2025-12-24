@extends('layouts.admin')

@section('title', 'Edit Driver')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Edit Driver</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.drivers.update', $driver) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Vendor</label>
                <select name="vendor_id" class="form-select" required>
                    @foreach($vendors as $vendor)
                        <option value="{{ $vendor->id }}" @selected(old('vendor_id', $driver->vendor_id) == $vendor->id)>
                            {{ $vendor->company_name }}
                        </option>
                    @endforeach
                </select>
                @error('vendor_id')<small class="text-danger">{{ $message }}</small>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Linked User (optional)</label>
                <select name="user_id" class="form-select">
                    <option value="">-- None --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" @selected(old('user_id', $driver->user_id) == $user->id)>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @error('user_id')<small class="text-danger">{{ $message }}</small>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" value="{{ old('name', $driver->name) }}" class="form-control" required>
                @error('name')<small class="text-danger">{{ $message }}</small>@enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Mobile</label>
                    <input type="text" name="mobile" value="{{ old('mobile', $driver->mobile) }}" class="form-control">
                    @error('mobile')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email', $driver->email) }}" class="form-control">
                    @error('email')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="active" @selected(old('status', $driver->status) === 'active')>Active</option>
                    <option value="inactive" @selected(old('status', $driver->status) === 'inactive')>Inactive</option>
                </select>
                @error('status')<small class="text-danger">{{ $message }}</small>@enderror
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.drivers.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection


