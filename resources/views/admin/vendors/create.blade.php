@extends('layouts.admin')

@section('title', 'Create Vendor')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Create Vendor</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.vendors.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Company Name</label>
                <input type="text" name="company_name" value="{{ old('company_name') }}" class="form-control" required>
                @error('company_name')<small class="text-danger">{{ $message }}</small>@enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">GST Number</label>
                    <input type="text" name="gst_number" value="{{ old('gst_number') }}" class="form-control">
                    @error('gst_number')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Pincode</label>
                    <input type="text" name="pincode" value="{{ old('pincode') }}" class="form-control">
                    @error('pincode')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea>
                @error('address')<small class="text-danger">{{ $message }}</small>@enderror
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">City</label>
                    <input type="text" name="city" value="{{ old('city') }}" class="form-control">
                    @error('city')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">State</label>
                    <input type="text" name="state" value="{{ old('state') }}" class="form-control">
                    @error('state')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="active" @selected(old('status', 'active') === 'active')>Active</option>
                        <option value="inactive" @selected(old('status') === 'inactive')>Inactive</option>
                    </select>
                    @error('status')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
            </div>

            <hr>
            <h6>Contact Details</h6>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Contact Person</label>
                    <input type="text" name="contact_person" value="{{ old('contact_person') }}" class="form-control">
                    @error('contact_person')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Contact Email</label>
                    <input type="email" name="contact_email" value="{{ old('contact_email') }}" class="form-control">
                    @error('contact_email')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Contact Phone</label>
                    <input type="text" name="contact_phone" value="{{ old('contact_phone') }}" class="form-control">
                    @error('contact_phone')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('admin.vendors.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection


