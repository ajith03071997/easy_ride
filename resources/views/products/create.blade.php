@extends('layouts.app')

@section('title', 'Add Product - Easy Ride')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-plus"></i> Add Product</h1>
    <a href="{{ route('products.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Products
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Product Information</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('products.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name *</label>
                        <input type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               id="name"
                               name="name"
                               value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="product_category_id" class="form-label">Category *</label>
                        <select class="form-select @error('product_category_id') is-invalid @enderror"
                                id="product_category_id"
                                name="product_category_id" required>
                            <option value="">Select Category</option>
                            @foreach($productCategories as $category)
                                <option value="{{ $category->id }}" {{ old('product_category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('product_category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cost_price" class="form-label">Cost Price *</label>
                                <input type="number"
                                       class="form-control @error('cost_price') is-invalid @enderror"
                                       id="cost_price"
                                       name="cost_price"
                                       step="0.01"
                                       min="0"
                                       value="{{ old('cost_price') }}" required>
                                @error('cost_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sell_price" class="form-label">Sell Price *</label>
                                <input type="number"
                                       class="form-control @error('sell_price') is-invalid @enderror"
                                       id="sell_price"
                                       name="sell_price"
                                       step="0.01"
                                       min="0"
                                       value="{{ old('sell_price') }}" required>
                                @error('sell_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="has_stock"
                                   name="has_stock"
                                   value="1"
                                   {{ old('has_stock') ? 'checked' : '' }}>
                            <label class="form-check-label" for="has_stock">
                                Has Stock
                            </label>
                        </div>
                    </div>

                    <div class="mb-3" id="opening_quantity_div" style="display: none;">
                        <label for="opening_quantity" class="form-label">Opening Quantity</label>
                        <input type="number"
                               class="form-control @error('opening_quantity') is-invalid @enderror"
                               id="opening_quantity"
                               name="opening_quantity"
                               min="0"
                               value="{{ old('opening_quantity') }}">
                        @error('opening_quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Product
                        </button>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Show/hide opening quantity field based on has_stock checkbox
    $('#has_stock').change(function() {
        if ($(this).is(':checked')) {
            $('#opening_quantity_div').show();
            $('#opening_quantity').prop('required', true);
        } else {
            $('#opening_quantity_div').hide();
            $('#opening_quantity').prop('required', false);
        }
    });

    // Trigger change event on page load if checkbox is already checked
    if ($('#has_stock').is(':checked')) {
        $('#has_stock').trigger('change');
    }
});
</script>
@endsection
