<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\SupportMessage;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function index(Request $request)
    {
        $vendorId = $request->user()->vendor_id;

        $tickets = SupportTicket::where('vendor_id', $vendorId)
            ->with('messages')
            ->latest()
            ->get();

        return view('vendor.support.index', compact('tickets'));
    }

    public function create()
    {
        return view('vendor.support.create');
    }

    public function store(Request $request)
    {
        $vendorId = $request->user()->vendor_id;

        $data = $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ]);

        $ticket = SupportTicket::create([
            'vendor_id' => $vendorId,
            'subject' => $data['subject'],
            'message' => $data['message'],
            'status' => 'open',
            'created_by_user_id' => $request->user()->id,
        ]);

        SupportMessage::create([
            'support_ticket_id' => $ticket->id,
            'user_id' => $request->user()->id,
            'message' => $data['message'],
        ]);

        return redirect()->route('vendor.support-tickets.index')
            ->with('success', 'Support ticket created.');
    }

    public function show(SupportTicket $support_ticket, Request $request)
    {
        abort_unless($support_ticket->vendor_id === $request->user()->vendor_id, 403);

        $support_ticket->load(['messages.user']);

        return view('vendor.support.show', ['ticket' => $support_ticket]);
    }
}


