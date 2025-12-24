<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\Route;
use App\Services\AlertService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TripController extends Controller
{
    public function index(Request $request)
    {
        $vendorId = $request->user()->vendor_id;

        $trips = Trip::with(['route', 'driver', 'vehicle'])
            ->where('vendor_id', $vendorId)
            ->latest()
            ->get();

        return view('vendor.trips.index', compact('trips'));
    }

    public function create(Request $request)
    {
        $vendorId = $request->user()->vendor_id;
        $routes = Route::where('vendor_id', $vendorId)->get();

        return view('vendor.trips.create', compact('routes'));
    }

    public function store(Request $request)
    {
        $vendorId = $request->user()->vendor_id;
        $tripType = $request->input('trip_type', 'single');

        $rules = [
            'route_id' => ['nullable', 'exists:routes,id'],
            'trip_type' => ['required', 'in:single,weekly,special'],
            'auto_assign' => ['sometimes', 'boolean'],
            'manual_assign' => ['sometimes', 'boolean'],
        ];

        // Validation based on trip type
        if ($tripType === 'weekly') {
            $rules['weekly_days'] = ['required', 'array', 'min:1'];
            $rules['weekly_days.*'] = ['integer', 'between:1,7'];
            $rules['weekly_pickup_time'] = ['required', 'date_format:H:i'];
            $rules['weekly_start_date'] = ['required', 'date', 'after_or_equal:today'];
            $rules['weekly_end_date'] = ['required', 'date', 'after:weekly_start_date'];
        } else {
            $rules['schedule_at'] = ['required', 'date'];
        }

        if ($tripType === 'special') {
            $rules['special_type'] = ['required', 'in:late_night,emergency,airport,outstation'];
            $rules['priority'] = ['required', 'in:normal,high,urgent'];
            $rules['special_instructions'] = ['nullable', 'string', 'max:1000'];
        }

        $data = $request->validate($rules);

        if ($tripType === 'weekly') {
            // Create multiple trips for weekly schedule
            $tripsCreated = $this->createWeeklyTrips($vendorId, $data, $request);
            return redirect()->route('vendor.trips.index')
                ->with('success', "{$tripsCreated} weekly trip(s) scheduled successfully.");
        }

        // Single or Special trip
        $scheduleAt = Carbon::parse($data['schedule_at']);

        $tripData = [
            'vendor_id' => $vendorId,
            'route_id' => $data['route_id'] ?? null,
            'trip_type' => $tripType,
            'schedule_at' => $scheduleAt,
            'scheduled_date' => $scheduleAt->toDateString(),
            'scheduled_time' => $scheduleAt->toTimeString(),
            'auto_assign' => $request->boolean('auto_assign'),
            'manual_assign' => $request->boolean('manual_assign'),
            'status' => 'pending',
            'created_by' => $request->user()->id,
        ];

        if ($tripType === 'special') {
            $tripData['special_type'] = $data['special_type'];
            $tripData['priority'] = $data['priority'];
            $tripData['special_instructions'] = $data['special_instructions'] ?? null;
        }

        Trip::create($tripData);

        return redirect()->route('vendor.trips.index')
            ->with('success', 'Trip request created successfully.');
    }

    public function show(Trip $trip, Request $request)
    {
        abort_unless($trip->vendor_id === $request->user()->vendor_id, 403);

        $trip->load(['route.points', 'driver', 'vehicle']);

        return view('vendor.trips.show', compact('trip'));
    }

    /**
     * Create weekly recurring trips
     */
    private function createWeeklyTrips(int $vendorId, array $data, Request $request): int
    {
        $startDate = Carbon::parse($data['weekly_start_date']);
        $endDate = Carbon::parse($data['weekly_end_date']);
        $weeklyDays = $data['weekly_days'];
        $pickupTime = $data['weekly_pickup_time'];
        $tripsCreated = 0;

        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {
            // Check if current day of week is in the selected days
            // Laravel Carbon: 1 = Monday, 7 = Sunday
            if (in_array($currentDate->dayOfWeekIso, $weeklyDays)) {
                Trip::create([
                    'vendor_id' => $vendorId,
                    'route_id' => $data['route_id'] ?? null,
                    'trip_type' => 'weekly',
                    'schedule_at' => $currentDate->copy()->setTimeFromTimeString($pickupTime),
                    'scheduled_date' => $currentDate->toDateString(),
                    'scheduled_time' => $pickupTime,
                    'auto_assign' => $request->boolean('auto_assign'),
                    'manual_assign' => $request->boolean('manual_assign'),
                    'weekly_days' => $weeklyDays,
                    'weekly_start_date' => $data['weekly_start_date'],
                    'weekly_end_date' => $data['weekly_end_date'],
                    'status' => 'pending',
                    'created_by' => $request->user()->id,
                ]);
                $tripsCreated++;
            }

            $currentDate->addDay();
        }

        return $tripsCreated;
    }
}


