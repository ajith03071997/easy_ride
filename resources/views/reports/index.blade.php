@extends('layouts.app')

@section('title', 'Reports - Easy Ride')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-chart-bar"></i> Reports</h1>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Generate Reports</h5>
            </div>
            <div class="card-body">
                <form id="reportForm" class="row g-3">
                    <div class="col-md-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date">
                    </div>
                    <div class="col-md-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date">
                    </div>
                    <div class="col-md-3">
                        <label for="report_type" class="form-label">Report Type</label>
                        <select class="form-select" id="report_type" name="report_type">
                            <option value="">Select Report Type</option>
                            <option value="daily_sessions">Daily Sessions</option>
                            <option value="device_sessions">Device Sessions</option>
                            <option value="expenses">Expenses</option>
                            <option value="products">Products Sales</option>
                            <option value="customers">Customer Activity</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Generate Report
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Report Results</h5>
            </div>
            <div class="card-body">
                <div id="reportResults">
                    <div class="text-center text-muted">
                        <i class="fas fa-chart-bar fa-3x mb-3"></i>
                        <p>Select date range and report type to generate reports</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats Cards -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Total Sessions</h6>
                        <h4 class="mb-0">{{ $totalSessions ?? 0 }}</h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-play-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Total Revenue</h6>
                        <h4 class="mb-0">{{ $totalRevenue ?? 0 }} EGP</h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-dollar-sign fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Total Expenses</h6>
                        <h4 class="mb-0">{{ $totalExpenses ?? 0 }} EGP</h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-receipt fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Net Profit</h6>
                        <h4 class="mb-0">{{ ($totalRevenue ?? 0) - ($totalExpenses ?? 0) }} EGP</h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-chart-line fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Set default date range (last 30 days)
    const today = new Date();
    const thirtyDaysAgo = new Date(today.getTime() - (30 * 24 * 60 * 60 * 1000));

    $('#end_date').val(today.toISOString().split('T')[0]);
    $('#start_date').val(thirtyDaysAgo.toISOString().split('T')[0]);

    $('#reportForm').on('submit', function(e) {
        e.preventDefault();

        const startDate = $('#start_date').val();
        const endDate = $('#end_date').val();
        const reportType = $('#report_type').val();

        if (!startDate || !endDate || !reportType) {
            alert('Please fill in all fields');
            return;
        }

        // Here you would typically make an AJAX request to generate the report
        // For now, we'll show a placeholder message
        $('#reportResults').html(`
            <div class="alert alert-info">
                <h6>Report Generated</h6>
                <p>Report Type: ${reportType}</p>
                <p>Date Range: ${startDate} to ${endDate}</p>
                <p><em>Report data would be displayed here. This requires backend implementation.</em></p>
            </div>
        `);
    });
});
</script>
@endsection
