<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DailySession;
use App\Models\DeviceSession;
use App\Models\Expense;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth());

        $sessions = DailySession::whereBetween('opened_at', [$startDate, $endDate])
            ->with('user')
            ->orderBy('opened_at', 'desc')
            ->get();

        // Calculate totals for the dashboard cards
        $totalSessions = DeviceSession::count();
        $totalRevenue = DeviceSession::sum('total_amount');
        $totalExpenses = Expense::sum('amount');

        return view('reports.index', compact('sessions', 'startDate', 'endDate', 'totalSessions', 'totalRevenue', 'totalExpenses'));
    }
}
