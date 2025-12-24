<?php

namespace App\Http\Controllers\Api\Driver;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\SupportMessage;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function contact()
    {
        return response()->json([
            'phone' => config('app.support_phone', null),
            'email' => config('mail.from.address'),
        ]);
    }

    public function reportVehicleIssue(Request $request)
    {
        $driverModel = $request->user()->driver;

        $data = $request->validate([
            'message' => ['required', 'string'],
        ]);

        $ticket = SupportTicket::create([
            'driver_id' => $driverModel?->id,
            'subject' => 'Vehicle Issue',
            'message' => $data['message'],
            'status' => 'open',
            'created_by_user_id' => $request->user()->id,
        ]);

        SupportMessage::create([
            'support_ticket_id' => $ticket->id,
            'user_id' => $request->user()->id,
            'message' => $data['message'],
        ]);

        return response()->json(['message' => 'Vehicle issue reported', 'ticket_id' => $ticket->id], 201);
    }

    public function emergency(Request $request)
    {
        $driverModel = $request->user()->driver;

        $data = $request->validate([
            'message' => ['nullable', 'string'],
        ]);

        $message = $data['message'] ?? 'Emergency button pressed from driver app';

        $ticket = SupportTicket::create([
            'driver_id' => $driverModel?->id,
            'subject' => 'EMERGENCY',
            'message' => $message,
            'status' => 'open',
            'created_by_user_id' => $request->user()->id,
        ]);

        SupportMessage::create([
            'support_ticket_id' => $ticket->id,
            'user_id' => $request->user()->id,
            'message' => $message,
        ]);

        return response()->json(['message' => 'Emergency raised', 'ticket_id' => $ticket->id], 201);
    }
}


