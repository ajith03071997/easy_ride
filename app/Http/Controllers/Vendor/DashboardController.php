<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\Route;
use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\VendorInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $vendorId = Auth::user()->vendor_id;
        $today = Carbon::today();

        // Total Trips Today for this vendor
        $totalTripsToday = Trip::whereHas('route', fn($q) => $q->where('vendor_id', $vendorId))
            ->whereDate('scheduled_date', $today)
            ->count();

        // Next Scheduled Trips (upcoming trips)
        $nextScheduledTrips = Trip::with(['route', 'driver', 'vehicle'])
            ->whereHas('route', fn($q) => $q->where('vendor_id', $vendorId))
            ->where(function($q) use ($today) {
                $q->whereDate('scheduled_date', '>', $today)
                  ->orWhere(function($q2) use ($today) {
                      $q2->whereDate('scheduled_date', $today)
                         ->whereIn('status', ['pending', 'approved', 'assigned', 'accepted']);
                  });
            })
            ->orderBy('scheduled_date')
            ->orderBy('scheduled_time')
            ->limit(5)
            ->get();

        // Live trips (started but not completed) for this vendor
        $liveTrips = Trip::with(['route', 'driver', 'vehicle'])
            ->whereHas('route', fn($q) => $q->where('vendor_id', $vendorId))
            ->whereIn('status', ['started', 'accepted', 'assigned'])
            ->whereDate('scheduled_date', $today)
            ->get();

        // Drivers assigned to this vendor
        $driversAssigned = Driver::where('vendor_id', $vendorId)
            ->where('status', 'active')
            ->with('vehicle')
            ->limit(5)
            ->get();

        // Vehicle details for this vendor
        $vehicleDetails = Vehicle::whereHas('driver', fn($q) => $q->where('vendor_id', $vendorId))
            ->where('status', 'active')
            ->limit(5)
            ->get();

        // Pending invoices / payment due alerts
        $pendingInvoices = VendorInvoice::where('vendor_id', $vendorId)
            ->where('status', 'sent')
            ->where('due_date', '<=', $today->copy()->addDays(7))
            ->orderBy('due_date')
            ->get();

        return view('vendor.dashboard', compact(
            'totalTripsToday',
            'nextScheduledTrips',
            'liveTrips',
            'driversAssigned',
            'vehicleDetails',
            'pendingInvoices'
        ));
    }
}


