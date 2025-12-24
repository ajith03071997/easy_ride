<?php

namespace App\Http\Controllers\Api\Driver;

use App\Http\Controllers\Controller;
use App\Models\DriverDocument;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function show(Request $request)
    {
        $driver = $request->user()->driver;
        $vehicle = $driver?->vehicle;

        return response()->json([
            'vehicle' => $vehicle,
        ]);
    }

    public function uploadDocument(Request $request)
    {
        $driver = $request->user()->driver;

        $data = $request->validate([
            'type' => ['required', 'string', 'in:DL,RC,Insurance'],
            'file' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png'],
            'expiry_date' => ['nullable', 'date'],
        ]);

        $path = $request->file('file')->store('driver-documents', 'public');

        $doc = DriverDocument::create([
            'driver_id' => $driver?->id,
            'type' => $data['type'],
            'file_path' => $path,
            'expiry_date' => $data['expiry_date'] ?? null,
        ]);

        return response()->json($doc, 201);
    }

    public function documents(Request $request)
    {
        $driver = $request->user()->driver;

        $documents = $driver?->documents()->get() ?? [];

        return response()->json($documents);
    }
}


