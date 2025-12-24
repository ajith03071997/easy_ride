@extends('layouts.vendor')

@section('title', 'New Employee Route')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">New Employee Route</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('vendor.routes.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Route Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Pickup Time</label>
                <input type="time" name="pickup_time" class="form-control" value="{{ old('pickup_time') }}">
            </div>

            <h6>Pickup / Drop Points</h6>
            <div id="points-wrapper">
                <div class="row g-2 mb-2 point-row">
                    <div class="col-md-3">
                        <select name="points[0][type]" class="form-select" required>
                            <option value="pickup">Pickup</option>
                            <option value="drop">Drop</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <input type="text" name="points[0][location]" class="form-control" placeholder="Location" required>
                    </div>
                    <div class="col-md-3">
                        <input type="time" name="points[0][time]" class="form-control">
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-sm btn-outline-secondary mb-3" id="add-point">
                <i class="fas fa-plus"></i> Add Point
            </button>

            <div>
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('vendor.routes.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    (function () {
        let index = 1;
        document.getElementById('add-point').addEventListener('click', function () {
            const wrapper = document.getElementById('points-wrapper');
            const row = document.createElement('div');
            row.className = 'row g-2 mb-2 point-row';
            row.innerHTML = `
                <div class="col-md-3">
                    <select name="points[${index}][type]" class="form-select" required>
                        <option value="pickup">Pickup</option>
                        <option value="drop">Drop</option>
                    </select>
                </div>
                <div class="col-md-5">
                    <input type="text" name="points[${index}][location]" class="form-control" placeholder="Location" required>
                </div>
                <div class="col-md-3">
                    <input type="time" name="points[${index}][time]" class="form-control">
                </div>
            `;
            wrapper.appendChild(row);
            index++;
        });
    })();
</script>
@endsection


