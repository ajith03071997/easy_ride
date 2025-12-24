<?php

namespace App\Http\Controllers\Api\Driver;

use App\Http\Controllers\Controller;
use App\Models\SystemNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $notifications = SystemNotification::where('user_id', $user->id)
            ->latest()
            ->limit(50)
            ->get();

        return response()->json($notifications);
    }

    public function markAsRead(Request $request, SystemNotification $notification)
    {
        abort_unless($notification->user_id === $request->user()->id, 403);

        $notification->update(['read' => true]);

        return response()->json(['message' => 'Notification marked as read']);
    }
}


