@extends('layouts.admin')

@section('title', 'Routes')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Routes</h4>
    <a href="{{ route('admin.routes.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> New Route
    </a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped table-bordered data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Vendor</th>
                    <th>Pickup Time</th>
                    <th>Driver</th>
                    <th>Vehicle</th>
                    <th>Weekly Fixed</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($routes as $route)
                    <tr>
                        <td>{{ $route->id }}</td>
                        <td>{{ $route->name }}</td>
                        <td>{{ $route->vendor?->company_name }}</td>
                        <td>{{ $route->pickup_time }}</td>
                        <td>{{ $route->driver?->name }}</td>
                        <td>{{ $route->vehicle?->vehicle_number }}</td>
                        <td>{{ $route->weekly_fixed ? 'Yes' : 'No' }}</td>
                        <td>
                            <a href="{{ route('admin.routes.show', $route) }}" class="btn btn-sm btn-outline-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.routes.edit', $route) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.routes.destroy', $route) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this route?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection


