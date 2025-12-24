<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\VendorInvoice;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function index(Request $request)
    {
        $vendorId = $request->user()->vendor_id;

        $invoices = VendorInvoice::where('vendor_id', $vendorId)
            ->with('items')
            ->latest()
            ->get();

        return view('vendor.billing.index', compact('invoices'));
    }
}


