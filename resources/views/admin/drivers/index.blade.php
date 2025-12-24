@extends('layouts.admin')

@section('title', 'Drivers')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Drivers</h4>
    <a href="{{ route('admin.drivers.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> New Driver
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
                    <th>Mobile</th>
                    <th>Status</th>
                    <th>Vehicle</th>
                    <th>Rating</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($drivers as $driver)
                    <tr>
                        <td>{{ $driver->id }}</td>
                        <td>{{ $driver->name }}</td>
                        <td>{{ $driver->vendor?->company_name }}</td>
                        <td>{{ $driver->mobile }}</td>
                        <td>
                            <span class="badge bg-{{ $driver->status === 'active' ? 'success' : 'secondary' }}">
                                {{ ucfirst($driver->status) }}
                            </span>
                        </td>
                        <td>{{ $driver->vehicle?->vehicle_number ?? '-' }}</td>
                        <td>{{ number_format($driver->rating, 2) }}</td>
                        <td>
                            <a href="{{ route('admin.drivers.show', $driver) }}" class="btn btn-sm btn-outline-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.drivers.edit', $driver) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.drivers.destroy', $driver) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this driver?')">
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


