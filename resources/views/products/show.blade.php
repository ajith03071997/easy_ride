@extends('layouts.app')

@section('title', 'Product Details - Easy Ride')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-box"></i> Product Details</h1>
    <a href="{{ route('products.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Products
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Product Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Product ID:</strong> #{{ $product->id }}</p>
                        <p><strong>Name:</strong> {{ $product->name }}</p>
                        <p><strong>Category:</strong> {{ $product->productCategory->name }}</p>
                        <p><strong>Cost Price:</strong> {{ $product->cost_price }} EGP</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Sell Price:</strong> {{ $product->sell_price }} EGP</p>
                        <p><strong>Has Stock:</strong>
                            @if($product->has_stock)
                                <span class="badge bg-success">Yes</span>
                            @else
                                <span class="badge bg-secondary">No</span>
                            @endif
                        </p>
                        @if($product->has_stock)
                            <p><strong>Opening Quantity:</strong> {{ $product->opening_quantity ?? 0 }}</p>
                            <p><strong>Current Quantity:</strong> {{ $product->current_quantity ?? 0 }}</p>
                        @endif
                        <p><strong>Created:</strong> {{ $product->created_at->format('d/m/Y h:i A') }}</p>
                    </div>
                </div>
                @if($product->has_stock)
                <div class="mt-3">
                    <div class="alert alert-info">
                        <strong>Stock Information:</strong><br>
                        Opening Quantity: {{ $product->opening_quantity ?? 0 }}<br>
                        Current Quantity: {{ $product->current_quantity ?? 0 }}<br>
                        @if($product->opening_quantity > 0 && $product->current_quantity !== null)
                            @php
                                $used = $product->opening_quantity - $product->current_quantity;
                                $percentage = $product->opening_quantity > 0 ? ($used / $product->opening_quantity) * 100 : 0;
                            @endphp
                            Used: {{ $used }} ({{ number_format($percentage, 1) }}%)
                        @endif
                    </div>
                </div>
                @endif
            </div>
            <div class="card-footer">
                <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit Product
                </a>
                <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                        <i class="fas fa-trash"></i> Delete Product
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
