@extends('layouts.app')

@section('title', 'Customer Details - Easy Ride')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-user"></i> Customer Details</h1>
    <a href="{{ route('customers.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Customers
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Customer Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Name:</strong> {{ $customer->name }}</p>
                        <p><strong>Phone Number:</strong> {{ $customer->phone_number ?? 'Not provided' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Email:</strong> {{ $customer->email ?? 'Not provided' }}</p>
                        <p><strong>Created:</strong> {{ $customer->created_at->format('d/m/Y h:i A') }}</p>
                    </div>
                </div>
                @if($customer->observations)
                <div class="mt-3">
                    <p><strong>Observations:</strong></p>
                    <p class="text-muted">{{ $customer->observations }}</p>
                </div>
                @endif
            </div>
            <div class="card-footer">
                <a href="{{ route('customers.edit', $customer) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit Customer
                </a>
                <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                        <i class="fas fa-trash"></i> Delete Customer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
