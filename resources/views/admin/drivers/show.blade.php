@extends('layouts.admin')

@section('title', 'Driver Details')

@section('content')
<div class="row mb-3">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Driver Profile</h5>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ $driver->name }}</p>
                <p><strong>Vendor:</strong> {{ $driver->vendor?->company_name }}</p>
                <p><strong>Mobile:</strong> {{ $driver->mobile }}</p>
                <p><strong>Email:</strong> {{ $driver->email }}</p>
                <p><strong>Status:</strong> {{ ucfirst($driver->status) }}</p>
                <p><strong>Rating:</strong> {{ number_format($driver->rating, 2) }}</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">KYC Documents</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.drivers.upload-document', $driver) }}" enctype="multipart/form-data" class="row g-2 mb-3">
                    @csrf
                    <div class="col-md-3">
                        <select name="type" class="form-select" required>
                            <option value="DL">DL</option>
                            <option value="RC">RC</option>
                            <option value="Insurance">Insurance</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="file" name="file" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="expiry_date" class="form-control" placeholder="Expiry date">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Upload</button>
                    </div>
                </form>

                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>File</th>
                            <th>Expiry</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($driver->documents as $doc)
                            <tr>
                                <td>{{ $doc->type }}</td>
                                <td><a href="{{ asset('storage/'.$doc->file_path) }}" target="_blank">View</a></td>
                                <td>{{ $doc->expiry_date }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Vehicle</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.drivers.update-vehicle', $driver) }}">
                    @csrf
                    <div class="mb-2">
                        <label class="form-label">Vehicle Number</label>
                        <input type="text" name="vehicle_number" class="form-control"
                               value="{{ old('vehicle_number', $driver->vehicle?->vehicle_number) }}">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Vehicle Type</label>
                        <input type="text" name="vehicle_type" class="form-control"
                               value="{{ old('vehicle_type', $driver->vehicle?->vehicle_type) }}">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Insurance Expiry</label>
                        <input type="date" name="insurance_expiry" class="form-control"
                               value="{{ old('insurance_expiry', optional($driver->vehicle?->insurance_expiry)->format('Y-m-d')) }}">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="active" @selected(optional($driver->vehicle)->status === 'active')>Active</option>
                            <option value="inactive" @selected(optional($driver->vehicle)->status === 'inactive')>Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Save Vehicle</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


