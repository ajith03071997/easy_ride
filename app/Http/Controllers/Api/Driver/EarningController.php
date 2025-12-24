<?php

namespace App\Http\Controllers\Api\Driver;

use App\Enums\TripStatus;
use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\DriverPayment;
use Illuminate\Http\Request;

class EarningController extends Controller
{
    public function daily(Request $request)
    {
        $driver = $request->user()->driver;

        $trips = Trip::where('driver_id', $driver?->id)
            ->whereDate('schedule_at', today())
            ->where('status', TripStatus::Completed)
            ->get();

        $totalTripEarnings = $trips->sum('cost');

        $payments = DriverPayment::where('driver_id', $driver?->id)
            ->whereDate('payment_date', today())
            ->get();

        return response()->json([
            'date' => today()->toDateString(),
            'trip_earnings' => $totalTripEarnings,
            'payments' => $payments,
        ]);
    }

    public function weekly(Request $request)
    {
        $driver = $request->user()->driver;

        $from = now()->startOfWeek();
        $to = now()->endOfWeek();

        $trips = Trip::where('driver_id', $driver?->id)
            ->whereBetween('schedule_at', [$from, $to])
            ->where('status', TripStatus::Completed)
            ->get();

        $totalTripEarnings = $trips->sum('cost');

        $payments = DriverPayment::where('driver_id', $driver?->id)
            ->whereBetween('payment_date', [$from, $to])
            ->get();

        return response()->json([
            'from' => $from->toDateString(),
            'to' => $to->toDateString(),
            'trip_earnings' => $totalTripEarnings,
            'payments' => $payments,
        ]);
    }
}


