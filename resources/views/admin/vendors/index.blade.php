@extends('layouts.admin')

@section('title', 'Vendors')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Vendors</h4>
    <a href="{{ route('admin.vendors.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> New Vendor
    </a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped table-bordered data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Company</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vendors as $vendor)
                    <tr>
                        <td>{{ $vendor->id }}</td>
                        <td>{{ $vendor->company_name }}</td>
                        <td>{{ $vendor->contact_person }}</td>
                        <td>{{ $vendor->contact_email }}</td>
                        <td>{{ $vendor->contact_phone }}</td>
                        <td>
                            <span class="badge bg-{{ $vendor->status === 'active' ? 'success' : 'secondary' }}">
                                {{ ucfirst($vendor->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.vendors.edit', $vendor) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.vendors.destroy', $vendor) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this vendor?')">
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


