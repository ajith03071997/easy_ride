<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DailySession;
use App\Models\DeviceSession;
use App\Models\Expense;
use Carbon\Carbon;

class DailySessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sessions = DailySession::with('user')->orderBy('created_at', 'desc')->get();
        return view('daily-sessions.index', compact('sessions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('daily-sessions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'opening_balance' => 'required|numeric|min:0'
        ]);

        // Check if there's already an open session
        $existingSession = DailySession::where('status', 'OPEN')->first();
        if ($existingSession) {
            return redirect()->route('daily-sessions.index')->with('error', 'There is already an open session.');
        }

        DailySession::create([
            'user_id' => auth()->id(),
            'opening_balance' => $request->opening_balance,
            'opened_at' => now(),
            'status' => 'OPEN'
        ]);

        return redirect()->route('daily-sessions.index')->with('success', 'Daily session started successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DailySession $dailySession)
    {
        $deviceSessions = $dailySession->deviceSessions()->with(['device', 'customer'])->get();
        $expenses = $dailySession->expenses()->with('expenseCategory')->get();
        
        return view('daily-sessions.show', compact('dailySession', 'deviceSessions', 'expenses'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DailySession $dailySession)
    {
        $users = \App\Models\User::all();
        return view('daily-sessions.edit', compact('dailySession', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DailySession $dailySession)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'opening_balance' => 'required|numeric|min:0',
            'closing_balance' => 'nullable|numeric|min:0',
            'opened_at' => 'required|date',
            'closed_at' => 'nullable|date',
            'status' => 'required|in:OPEN,CLOSED'
        ]);

        $dailySession->update($request->all());

        return redirect()->route('daily-sessions.index')->with('success', 'Daily session updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DailySession $dailySession)
    {
        $dailySession->delete();

        return redirect()->route('daily-sessions.index')->with('success', 'Daily session deleted successfully.');
    }

    /**
     * Show session details.
     */
    public function details(DailySession $session)
    {
        $deviceSessions = $session->deviceSessions()->with(['device', 'customer'])->get();
        $expenses = $session->expenses()->with('expenseCategory')->get();
        
        // Calculate summary
        $sessionCount = $deviceSessions->count();
        $ongoingSessions = $deviceSessions->where('status', 'Active')->count();
        $endedSessions = $deviceSessions->where('status', 'Ended')->count();
        $sessionsSales = $deviceSessions->sum('total_amount');
        $extensions = $deviceSessions->sum('extension_amount');
        $discounts = $deviceSessions->sum('discount_amount');
        $products = 0; // This would be calculated from product sales
        $expensesTotal = $expenses->sum('amount');
        $totalSales = $sessionsSales + $products;
        $net = $totalSales - $expensesTotal;

        return view('daily-sessions.details', compact(
            'session',
            'deviceSessions',
            'expenses',
            'sessionCount',
            'ongoingSessions',
            'endedSessions',
            'sessionsSales',
            'extensions',
            'discounts',
            'products',
            'expensesTotal',
            'totalSales',
            'net'
        ));
    }
}
