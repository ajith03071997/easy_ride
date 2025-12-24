<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\Route;
use App\Services\AlertService;
use Illuminate\Http\Request;

class TripController extends Controller
{
    protected AlertService $alertService;

    public function __construct(AlertService $alertService)
    {
        $this->alertService = $alertService;
    }

    public function index(Request $request)
    {
        $query = Trip::with(['vendor', 'route', 'driver', 'vehicle']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by trip type
        if ($request->filled('trip_type')) {
            $query->where('trip_type', $request->trip_type);
        }

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('scheduled_date', $request->date);
        }

        $trips = $query->latest()->get();

        return view('admin.trips.index', compact('trips'));
    }

    public function show(Trip $trip)
    {
        $trip->load(['vendor', 'route.points', 'driver', 'vehicle']);

        return view('admin.trips.show', compact('trip'));
    }

    public function edit(Trip $trip)
    {
        $drivers = Driver::where('status', 'active')->get();
        $vehicles = Vehicle::where('status', 'active')->get();
        $routes = Route::where('vendor_id', $trip->vendor_id)->get();

        return view('admin.trips.edit', compact('trip', 'drivers', 'vehicles', 'routes'));
    }

    public function update(Request $request, Trip $trip)
    {
        $data = $request->validate([
            'driver_id' => ['nullable', 'exists:drivers,id'],
            'vehicle_id' => ['nullable', 'exists:vehicles,id'],
            'route_id' => ['nullable', 'exists:routes,id'],
            'status' => ['required', 'string'],
            'estimated_cost' => ['nullable', 'numeric', 'min:0'],
        ]);

        $oldDriverId = $trip->driver_id;
        $oldVehicleId = $trip->vehicle_id;
        $oldStatus = $trip->status;

        $trip->update($data);
        $trip->refresh();

        // Send alerts based on changes
        // Driver assigned
        if ($data['driver_id'] && $oldDriverId != $data['driver_id']) {
            $this->alertService->sendTripAssignedAlert($trip);
        }

        // Vehicle changed
        if ($oldVehicleId && $data['vehicle_id'] && $oldVehicleId != $data['vehicle_id']) {
            $oldVehicle = Vehicle::find($oldVehicleId);
            $newVehicle = Vehicle::find($data['vehicle_id']);
            if ($oldVehicle && $newVehicle) {
                $this->alertService->sendVehicleChangeAlert($trip, $oldVehicle, $newVehicle);
            }
        }

        // Status changed - notify vendor
        if ($oldStatus != $trip->status) {
            $this->alertService->sendTripStatusUpdateToVendor($trip);

            // If delayed, send delay alert
            if ($trip->status === 'delayed') {
                $this->alertService->sendTripDelayAlert($trip, 'Trip has been marked as delayed by admin.');
            }
        }

        return redirect()->route('admin.trips.show', $trip)
            ->with('success', 'Trip updated successfully.');
    }

    /**
     * Approve a pending trip
     */
    public function approve(Trip $trip)
    {
        if ($trip->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending trips can be approved.');
        }

        $trip->update(['status' => 'approved']);

        $this->alertService->sendTripStatusUpdateToVendor($trip);

        return redirect()->route('admin.trips.show', $trip)
            ->with('success', 'Trip approved successfully.');
    }

    /**
     * Cancel a trip
     */
    public function cancel(Request $request, Trip $trip)
    {
        if (in_array($trip->status, ['completed', 'cancelled'])) {
            return redirect()->back()->with('error', 'This trip cannot be cancelled.');
        }

        $reason = $request->input('reason', 'Cancelled by admin');

        $trip->update([
            'status' => 'cancelled',
            'completion_report' => array_merge($trip->completion_report ?? [], [
                'cancellation_reason' => $reason,
                'cancelled_at' => now()->toIso8601String(),
            ]),
        ]);

        $this->alertService->sendTripStatusUpdateToVendor($trip);

        return redirect()->route('admin.trips.index')
            ->with('success', 'Trip cancelled.');
    }

    /**
     * Mark trip as delayed
     */
    public function markDelayed(Request $request, Trip $trip)
    {
        $reason = $request->input('reason', 'Delayed');

        $trip->update(['status' => 'delayed']);

        $this->alertService->sendTripDelayAlert($trip, $reason);

        return redirect()->route('admin.trips.show', $trip)
            ->with('success', 'Trip marked as delayed and alerts sent.');
    }
}


