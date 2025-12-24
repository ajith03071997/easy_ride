<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $devices = Device::all();
        return view('devices.index', compact('devices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('devices.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'single_price_per_hour' => 'required|numeric|min:0',
            'supports_multiplayer' => 'boolean',
            'device_type' => 'required|in:PlayStation,Room,Computer,Ping Pong,Billiards',
            'device_status' => 'required|in:Working,Maintenance,Stopped'
        ]);

        $data = $request->all();
        $data['supports_multiplayer'] = $request->has('supports_multiplayer') ? true : false;
        
        Device::create($data);

        return redirect()->route('devices.index')->with('success', 'Device created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Device $device)
    {
        return view('devices.show', compact('device'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Device $device)
    {
        return view('devices.edit', compact('device'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Device $device)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'single_price_per_hour' => 'required|numeric|min:0',
            'supports_multiplayer' => 'boolean',
            'device_type' => 'required|in:PlayStation,Room,Computer,Ping Pong,Billiards',
            'device_status' => 'required|in:Working,Maintenance,Stopped'
        ]);

        $data = $request->all();
        $data['supports_multiplayer'] = $request->has('supports_multiplayer') ? true : false;
        
        $device->update($data);

        return redirect()->route('devices.index')->with('success', 'Device updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Device $device)
    {
        $device->delete();

        return redirect()->route('devices.index')->with('success', 'Device deleted successfully.');
    }
}
