@extends('layouts.vendor')

@section('title', 'New Trip Request')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">New Trip Request</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('vendor.trips.store') }}">
            @csrf

            <!-- Trip Type Selection -->
            <div class="mb-4">
                <label class="form-label fw-bold">Trip Type</label>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-check card p-3 h-100">
                            <input class="form-check-input" type="radio" name="trip_type" id="type_single" value="single" checked>
                            <label class="form-check-label w-100" for="type_single">
                                <i class="fas fa-car text-primary"></i>
                                <strong class="d-block mt-2">Single Trip</strong>
                                <small class="text-muted">One-time trip request</small>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check card p-3 h-100">
                            <input class="form-check-input" type="radio" name="trip_type" id="type_weekly" value="weekly">
                            <label class="form-check-label w-100" for="type_weekly">
                                <i class="fas fa-calendar-week text-success"></i>
                                <strong class="d-block mt-2">Weekly Fixed Route</strong>
                                <small class="text-muted">Recurring weekly schedule</small>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check card p-3 h-100">
                            <input class="form-check-input" type="radio" name="trip_type" id="type_special" value="special">
                            <label class="form-check-label w-100" for="type_special">
                                <i class="fas fa-exclamation-circle text-danger"></i>
                                <strong class="d-block mt-2">Special Request</strong>
                                <small class="text-muted">Late Night / Emergency</small>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Route (optional)</label>
                <select name="route_id" class="form-select">
                    <option value="">Ad-hoc Trip</option>
                    @foreach($routes as $route)
                        <option value="{{ $route->id }}" @selected(old('route_id') == $route->id)>
                            {{ $route->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Single Trip / Special Request Schedule -->
            <div id="single_schedule" class="mb-3">
                <label class="form-label">Schedule At</label>
                <input type="datetime-local" name="schedule_at" class="form-control">
            </div>

            <!-- Weekly Fixed Route Options -->
            <div id="weekly_options" class="mb-3" style="display: none;">
                <label class="form-label fw-bold">Select Days of Week</label>
                <div class="row">
                    @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $index => $day)
                    <div class="col-auto">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="weekly_days[]" value="{{ $index + 1 }}" id="day_{{ $index }}">
                            <label class="form-check-label" for="day_{{ $index }}">{{ $day }}</label>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <label class="form-label">Pickup Time</label>
                        <input type="time" name="weekly_pickup_time" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Start Date</label>
                        <input type="date" name="weekly_start_date" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">End Date</label>
                        <input type="date" name="weekly_end_date" class="form-control">
                    </div>
                </div>
            </div>

            <!-- Special Request Options -->
            <div id="special_options" class="mb-3" style="display: none;">
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Special Request Type</label>
                        <select name="special_type" class="form-select">
                            <option value="late_night">Late Night Trip</option>
                            <option value="emergency">Emergency Trip</option>
                            <option value="airport">Airport Pickup/Drop</option>
                            <option value="outstation">Outstation Trip</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Priority</label>
                        <select name="priority" class="form-select">
                            <option value="normal">Normal</option>
                            <option value="high">High</option>
                            <option value="urgent">Urgent</option>
                        </select>
                    </div>
                </div>
                <div class="mt-3">
                    <label class="form-label">Special Instructions</label>
                    <textarea name="special_instructions" class="form-control" rows="3" placeholder="Enter any special instructions or requirements..."></textarea>
                </div>
            </div>

            <hr>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="auto_assign" value="1" id="auto_assign">
                        <label class="form-check-label" for="auto_assign">
                            <i class="fas fa-magic text-info"></i> Auto Assign Driver
                        </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="manual_assign" value="1" id="manual_assign">
                        <label class="form-check-label" for="manual_assign">
                            <i class="fas fa-hand-pointer text-secondary"></i> Manual Assign Later
                        </label>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane"></i> Submit Request
            </button>
            <a href="{{ route('vendor.trips.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('input[name="trip_type"]').change(function() {
        var type = $(this).val();
        
        $('#single_schedule').hide();
        $('#weekly_options').hide();
        $('#special_options').hide();
        
        if (type === 'single') {
            $('#single_schedule').show();
        } else if (type === 'weekly') {
            $('#weekly_options').show();
        } else if (type === 'special') {
            $('#single_schedule').show();
            $('#special_options').show();
        }
    });
});
</script>
@endsection


