<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemNotification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = SystemNotification::latest()->limit(100)->get();

        return view('admin.notifications.index', compact('notifications'));
    }
}


