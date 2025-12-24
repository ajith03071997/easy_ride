<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\DailySession;
use App\Models\DeviceSession;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        $devices = Device::all();
        $totalDevices = $devices->count();
        $runningDevices = $devices->where('device_status', 'Working')->count();
        $availableDevices = $totalDevices - $runningDevices;

        // Get current session
        $currentSession = DailySession::where('status', 'OPEN')->first();

        return view('dashboard', compact(
            'totalDevices',
            'runningDevices',
            'availableDevices',
            'currentSession'
        ));
    }

    /**
     * Close the current daily session.
     */
    public function closeSession(Request $request)
    {
        $request->validate([
            'closing_balance' => 'required|numeric|min:0'
        ]);

        $currentSession = DailySession::where('status', 'OPEN')->first();

        if ($currentSession) {
            $currentSession->update([
                'closing_balance' => $request->closing_balance,
                'closed_at' => now(),
                'status' => 'CLOSED'
            ]);

            return redirect()->route('dashboard')->with('success', 'Daily session closed successfully.');
        }

        return redirect()->route('dashboard')->with('error', 'No active session found.');
    }
}
