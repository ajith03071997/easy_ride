@extends('layouts.vendor')

@section('title', 'Employee Routes')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Employee Routes</h4>
    <a href="{{ route('vendor.routes.create') }}" class="btn btn-primary">
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
                    <th>Pickup Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($routes as $route)
                    <tr>
                        <td>{{ $route->id }}</td>
                        <td>{{ $route->name }}</td>
                        <td>{{ $route->pickup_time }}</td>
                        <td>
                            <a href="{{ route('vendor.routes.show', $route) }}" class="btn btn-sm btn-outline-info">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection


