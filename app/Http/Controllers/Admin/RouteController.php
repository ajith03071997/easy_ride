<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Models\RoutePoint;
use App\Models\Vendor;
use App\Models\Driver;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index()
    {
        $routes = Route::with(['vendor', 'driver', 'vehicle'])->get();

        return view('admin.routes.index', compact('routes'));
    }

    public function create()
    {
        $vendors = Vendor::orderBy('company_name')->get();
        $drivers = Driver::where('status', 'active')->get();
        $vehicles = Vehicle::where('status', 'active')->get();

        return view('admin.routes.create', compact('vendors', 'drivers', 'vehicles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'vendor_id' => ['required', 'exists:vendors,id'],
            'name' => ['nullable', 'string', 'max:255'],
            'pickup_time' => ['nullable'],
            'weekly_fixed' => ['sometimes', 'boolean'],
            'driver_id' => ['nullable', 'exists:drivers,id'],
            'vehicle_id' => ['nullable', 'exists:vehicles,id'],
            'points' => ['array'],
            'points.*.type' => ['required_with:points', 'in:pickup,drop'],
            'points.*.location' => ['required_with:points', 'string', 'max:255'],
            'points.*.time' => ['nullable'],
        ]);

        $route = Route::create([
            'vendor_id' => $data['vendor_id'],
            'name' => $data['name'] ?? null,
            'pickup_time' => $data['pickup_time'] ?? null,
            'weekly_fixed' => $request->boolean('weekly_fixed'),
            'driver_id' => $data['driver_id'] ?? null,
            'vehicle_id' => $data['vehicle_id'] ?? null,
        ]);

        if (! empty($data['points'])) {
            foreach ($data['points'] as $index => $point) {
                RoutePoint::create([
                    'route_id' => $route->id,
                    'type' => $point['type'],
                    'location' => $point['location'],
                    'time' => $point['time'] ?? null,
                    'sequence' => $index,
                ]);
            }
        }

        return redirect()->route('admin.routes.index')
            ->with('success', 'Route created successfully.');
    }

    public function show(Route $route)
    {
        $route->load(['vendor', 'driver', 'vehicle', 'points' => fn ($q) => $q->orderBy('sequence')]);

        return view('admin.routes.show', compact('route'));
    }

    public function edit(Route $route)
    {
        $route->load(['points' => fn ($q) => $q->orderBy('sequence')]);
        $vendors = Vendor::orderBy('company_name')->get();
        $drivers = Driver::where('status', 'active')->get();
        $vehicles = Vehicle::where('status', 'active')->get();

        return view('admin.routes.edit', compact('route', 'vendors', 'drivers', 'vehicles'));
    }

    public function update(Request $request, Route $route)
    {
        $data = $request->validate([
            'vendor_id' => ['required', 'exists:vendors,id'],
            'name' => ['nullable', 'string', 'max:255'],
            'pickup_time' => ['nullable'],
            'weekly_fixed' => ['sometimes', 'boolean'],
            'driver_id' => ['nullable', 'exists:drivers,id'],
            'vehicle_id' => ['nullable', 'exists:vehicles,id'],
        ]);

        $route->update([
            'vendor_id' => $data['vendor_id'],
            'name' => $data['name'] ?? null,
            'pickup_time' => $data['pickup_time'] ?? null,
            'weekly_fixed' => $request->boolean('weekly_fixed'),
            'driver_id' => $data['driver_id'] ?? null,
            'vehicle_id' => $data['vehicle_id'] ?? null,
        ]);

        return redirect()->route('admin.routes.index')
            ->with('success', 'Route updated successfully.');
    }

    public function destroy(Route $route)
    {
        $route->delete();

        return redirect()->route('admin.routes.index')
            ->with('success', 'Route deleted successfully.');
    }
}


