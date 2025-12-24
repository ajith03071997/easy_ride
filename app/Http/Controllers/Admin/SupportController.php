<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\SupportMessage;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function index()
    {
        $tickets = SupportTicket::with(['vendor', 'driver', 'creator', 'assignee'])
            ->latest()
            ->get();

        return view('admin.support.index', compact('tickets'));
    }

    public function show(SupportTicket $support_ticket)
    {
        $support_ticket->load(['vendor', 'driver', 'creator', 'assignee', 'messages.user']);

        return view('admin.support.show', ['ticket' => $support_ticket]);
    }

    public function update(Request $request, SupportTicket $support_ticket)
    {
        $data = $request->validate([
            'status' => ['required', 'string'],
            'admin_reply' => ['nullable', 'string'],
        ]);

        $support_ticket->update([
            'status' => $data['status'],
            'assigned_to_user_id' => $request->user()->id,
        ]);

        if (! empty($data['admin_reply'])) {
            SupportMessage::create([
                'support_ticket_id' => $support_ticket->id,
                'user_id' => $request->user()->id,
                'message' => $data['admin_reply'],
            ]);
        }

        return back()->with('success', 'Ticket updated.');
    }
}


