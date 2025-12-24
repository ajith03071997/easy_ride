<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Models\RoutePoint;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index(Request $request)
    {
        $vendorId = $request->user()->vendor_id;

        $routes = Route::with('points')
            ->where('vendor_id', $vendorId)
            ->get();

        return view('vendor.routes.index', compact('routes'));
    }

    public function create()
    {
        return view('vendor.routes.create');
    }

    public function store(Request $request)
    {
        $vendorId = $request->user()->vendor_id;

        $data = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'pickup_time' => ['nullable'],
            'points' => ['array'],
            'points.*.type' => ['required_with:points', 'in:pickup,drop'],
            'points.*.location' => ['required_with:points', 'string', 'max:255'],
            'points.*.time' => ['nullable'],
        ]);

        $route = Route::create([
            'vendor_id' => $vendorId,
            'name' => $data['name'] ?? null,
            'pickup_time' => $data['pickup_time'] ?? null,
            'weekly_fixed' => true,
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

        return redirect()->route('vendor.routes.index')
            ->with('success', 'Employee route registered.');
    }

    public function show(Route $route, Request $request)
    {
        abort_unless($route->vendor_id === $request->user()->vendor_id, 403);

        $route->load(['points' => fn ($q) => $q->orderBy('sequence')]);

        return view('vendor.routes.show', compact('route'));
    }
}


