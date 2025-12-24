<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Vehicle;
use App\Models\DriverDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::with(['vendor', 'vehicle'])->get();

        return view('admin.drivers.index', compact('drivers'));
    }

    public function create()
    {
        $vendors = Vendor::orderBy('company_name')->get();
        $users = User::role('driver')->get();

        return view('admin.drivers.create', compact('vendors', 'users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'vendor_id' => ['required', 'exists:vendors,id'],
            'user_id' => ['nullable', 'exists:users,id'],
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'status' => ['required', 'string', 'in:active,inactive'],
        ]);

        Driver::create($data);

        return redirect()->route('admin.drivers.index')
            ->with('success', 'Driver created successfully.');
    }

    public function edit(Driver $driver)
    {
        $vendors = Vendor::orderBy('company_name')->get();
        $users = User::role('driver')->get();

        return view('admin.drivers.edit', compact('driver', 'vendors', 'users'));
    }

    public function update(Request $request, Driver $driver)
    {
        $data = $request->validate([
            'vendor_id' => ['required', 'exists:vendors,id'],
            'user_id' => ['nullable', 'exists:users,id'],
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'status' => ['required', 'string', 'in:active,inactive'],
        ]);

        $driver->update($data);

        return redirect()->route('admin.drivers.index')
            ->with('success', 'Driver updated successfully.');
    }

    public function destroy(Driver $driver)
    {
        $driver->delete();

        return redirect()->route('admin.drivers.index')
            ->with('success', 'Driver deleted successfully.');
    }

    public function show(Driver $driver)
    {
        $driver->load(['vendor', 'user', 'vehicle', 'documents']);

        return view('admin.drivers.show', compact('driver'));
    }

    public function updateVehicle(Request $request, Driver $driver)
    {
        $data = $request->validate([
            'vehicle_number' => ['required', 'string', 'max:50'],
            'vehicle_type' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'string', 'in:active,inactive'],
            'insurance_expiry' => ['nullable', 'date'],
        ]);

        Vehicle::updateOrCreate(
            ['driver_id' => $driver->id],
            array_merge($data, ['vendor_id' => $driver->vendor_id])
        );

        return back()->with('success', 'Vehicle details updated.');
    }

    public function uploadDocument(Request $request, Driver $driver)
    {
        $data = $request->validate([
            'type' => ['required', 'string', 'in:DL,RC,Insurance'],
            'file' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png'],
            'expiry_date' => ['nullable', 'date'],
        ]);

        $path = $request->file('file')->store('driver-documents', 'public');

        DriverDocument::create([
            'driver_id' => $driver->id,
            'type' => $data['type'],
            'file_path' => $path,
            'expiry_date' => $data['expiry_date'] ?? null,
        ]);

        return back()->with('success', 'Document uploaded successfully.');
    }
}


