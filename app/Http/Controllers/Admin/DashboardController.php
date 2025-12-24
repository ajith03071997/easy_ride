<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\Driver;
use App\Models\Trip;
use App\Models\VendorInvoice;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $totalVendorsActive = Vendor::where('status', 'active')->count();
        $totalDriversActive = Driver::where('status', 'active')->count();

        // Total Trips Today
        $totalTripsToday = Trip::whereDate('scheduled_date', $today)->count();

        // Pending Trip Approvals
        $pendingTripApprovals = Trip::where('status', 'pending')->count();

        // Daily Revenue Summary (sum of completed trip costs today)
        $dailyRevenue = Trip::whereDate('scheduled_date', $today)
            ->where('status', 'completed')
            ->sum('estimated_cost');

        // Live trips (started but not completed)
        $liveTrips = Trip::with(['route', 'driver', 'vehicle'])
            ->whereIn('status', ['started', 'accepted', 'assigned'])
            ->whereDate('scheduled_date', $today)
            ->get();

        return view('admin.dashboard', compact(
            'totalVendorsActive',
            'totalDriversActive',
            'totalTripsToday',
            'pendingTripApprovals',
            'dailyRevenue',
            'liveTrips'
        ));
    }
}


