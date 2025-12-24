<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Customer;
use App\Models\Device;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['customer', 'device'])->latest()->get();
        return view('reservations.index', compact('reservations'));
    }

    public function create()
    {
        $customers = Customer::all();
        $devices = Device::all();
        return view('reservations.create', compact('customers', 'devices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'device_id' => 'required|exists:devices,id',
            'session_type' => 'required|in:Single,Multi',
            'start_time' => 'nullable|date',
            'end_time' => 'nullable|date|after:start_time',
            'activation_is_automatic' => 'boolean'
        ]);

        $data = $request->all();
        $data['activation_is_automatic'] = $request->has('activation_is_automatic') ? true : false;
        
        Reservation::create($data);
        return redirect()->route('reservations.index')->with('success', 'Reservation created successfully.');
    }

    public function show(Reservation $reservation)
    {
        return view('reservations.show', compact('reservation'));
    }

    public function edit(Reservation $reservation)
    {
        $customers = Customer::all();
        $devices = Device::all();
        return view('reservations.edit', compact('reservation', 'customers', 'devices'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'device_id' => 'required|exists:devices,id',
            'session_type' => 'required|in:Single,Multi',
            'start_time' => 'nullable|date',
            'end_time' => 'nullable|date|after:start_time',
            'activation_is_automatic' => 'boolean',
            'status' => 'required|in:Pending,Active,Completed,Cancelled'
        ]);

        $data = $request->all();
        $data['activation_is_automatic'] = $request->has('activation_is_automatic') ? true : false;
        
        $reservation->update($data);
        return redirect()->route('reservations.index')->with('success', 'Reservation updated successfully.');
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect()->route('reservations.index')->with('success', 'Reservation deleted successfully.');
    }
}
