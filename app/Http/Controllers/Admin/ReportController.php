<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\Vendor;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $vendors = Vendor::orderBy('company_name')->get();

        $query = Trip::with(['vendor', 'driver', 'vehicle']);

        if ($request->filled('vendor_id')) {
            $query->where('vendor_id', $request->vendor_id);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('schedule_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('schedule_at', '<=', $request->to_date);
        }

        $trips = $query->latest()->limit(200)->get();

        $vendorSummary = $trips
            ->groupBy('vendor_id')
            ->map(function ($items) {
                return [
                    'vendor' => optional($items->first()->vendor)->company_name,
                    'trip_count' => $items->count(),
                    'total_cost' => $items->sum('cost'),
                ];
            });

        return view('admin.reports.index', compact('vendors', 'trips', 'vendorSummary'));
    }
}


