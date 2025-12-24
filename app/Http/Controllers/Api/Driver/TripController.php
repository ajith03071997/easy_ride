<?php

namespace App\Http\Controllers\Api\Driver;

use App\Enums\TripStatus;
use App\Http\Controllers\Controller;
use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function today(Request $request)
    {
        $driver = $request->user()->driver;

        $trips = Trip::with(['route.points' => fn ($q) => $q->orderBy('sequence')])
            ->where('driver_id', $driver?->id)
            ->whereDate('schedule_at', today())
            ->orderBy('schedule_at')
            ->get();

        return response()->json($trips);
    }

    public function show(Trip $trip, Request $request)
    {
        $driver = $request->user()->driver;
        abort_unless($trip->driver_id === $driver?->id, 403);

        $trip->load(['route.points' => fn ($q) => $q->orderBy('sequence')]);

        return response()->json($trip);
    }

    public function accept(Trip $trip, Request $request)
    {
        $driver = $request->user()->driver;
        abort_unless($trip->driver_id === $driver?->id, 403);

        $trip->update(['status' => TripStatus::Accepted]);

        return response()->json(['message' => 'Trip accepted', 'status' => $trip->status->value]);
    }

    public function start(Trip $trip, Request $request)
    {
        $driver = $request->user()->driver;
        abort_unless($trip->driver_id === $driver?->id, 403);

        $trip->update(['status' => TripStatus::Started]);

        return response()->json(['message' => 'Trip started', 'status' => $trip->status->value]);
    }

    public function complete(Trip $trip, Request $request)
    {
        $driver = $request->user()->driver;
        abort_unless($trip->driver_id === $driver?->id, 403);

        $data = $request->validate([
            'distance_km' => ['nullable', 'numeric', 'min:0'],
            'completion_report' => ['nullable', 'array'],
        ]);

        $trip->update([
            'status' => TripStatus::Completed,
            'distance_km' => $data['distance_km'] ?? $trip->distance_km,
            'completion_report' => $data['completion_report'] ?? $trip->completion_report,
        ]);

        return response()->json(['message' => 'Trip completed', 'status' => $trip->status->value]);
    }

    public function updateLocation(Trip $trip, Request $request)
    {
        $driver = $request->user()->driver;
        abort_unless($trip->driver_id === $driver?->id, 403);

        $data = $request->validate([
            'lat' => ['required', 'numeric'],
            'lng' => ['required', 'numeric'],
        ]);

        $report = $trip->completion_report ?? [];
        $report['locations'][] = [
            'lat' => $data['lat'],
            'lng' => $data['lng'],
            'at' => now()->toIso8601String(),
        ];

        $trip->update([
            'completion_report' => $report,
        ]);

        return response()->json(['message' => 'Location updated']);
    }
}


