<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\SystemNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $vendorId = $request->user()->vendor_id;

        $notifications = SystemNotification::where('vendor_id', $vendorId)
            ->latest()
            ->get();

        return view('vendor.notifications.index', compact('notifications'));
    }
}


