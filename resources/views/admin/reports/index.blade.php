@extends('layouts.admin')

@section('title', 'Reports')

@section('content')
<h4 class="mb-3">Trip & Vendor Reports</h4>

<form method="GET" class="row g-2 mb-3">
    <div class="col-md-3">
        <select name="vendor_id" class="form-select">
            <option value="">All Vendors</option>
            @foreach($vendors as $vendor)
                <option value="{{ $vendor->id }}" @selected(request('vendor_id') == $vendor->id)>
                    {{ $vendor->company_name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}" placeholder="From date">
    </div>
    <div class="col-md-3">
        <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}" placeholder="To date">
    </div>
    <div class="col-md-3">
        <button type="submit" class="btn btn-primary w-100">Filter</button>
    </div>
</form>

<div class="row">
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Vendor-wise Summary</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Vendor</th>
                            <th>Trips</th>
                            <th>Total Cost</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vendorSummary as $summary)
                            <tr>
                                <td>{{ $summary['vendor'] }}</td>
                                <td>{{ $summary['trip_count'] }}</td>
                                <td>{{ $summary['total_cost'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Trip-wise Report</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Vendor</th>
                            <th>Schedule</th>
                            <th>Status</th>
                            <th>Cost</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trips as $trip)
                            <tr>
                                <td>{{ $trip->id }}</td>
                                <td>{{ $trip->vendor?->company_name }}</td>
                                <td>{{ $trip->schedule_at }}</td>
                                <td>{{ ucfirst($trip->status->value ?? $trip->status) }}</td>
                                <td>{{ $trip->cost }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection


