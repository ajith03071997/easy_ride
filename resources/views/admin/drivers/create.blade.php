@extends('layouts.admin')

@section('title', 'Create Driver')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Create Driver</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.drivers.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Vendor</label>
                <select name="vendor_id" class="form-select" required>
                    <option value="">Select vendor</option>
                    @foreach($vendors as $vendor)
                        <option value="{{ $vendor->id }}" @selected(old('vendor_id') == $vendor->id)>
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
                        <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @error('user_id')<small class="text-danger">{{ $message }}</small>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                @error('name')<small class="text-danger">{{ $message }}</small>@enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Mobile</label>
                    <input type="text" name="mobile" value="{{ old('mobile') }}" class="form-control">
                    @error('mobile')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control">
                    @error('email')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="active" @selected(old('status','active') === 'active')>Active</option>
                    <option value="inactive" @selected(old('status') === 'inactive')>Inactive</option>
                </select>
                @error('status')<small class="text-danger">{{ $message }}</small>@enderror
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('admin.drivers.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection


