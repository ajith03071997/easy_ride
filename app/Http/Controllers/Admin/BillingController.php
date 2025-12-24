<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\Driver;
use App\Models\VendorInvoice;
use App\Models\VendorInvoiceItem;
use App\Models\Trip;
use App\Models\DriverPayment;
use App\Models\OperationExpense;
use App\Services\AlertService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BillingController extends Controller
{
    protected AlertService $alertService;

    public function __construct(AlertService $alertService)
    {
        $this->alertService = $alertService;
    }

    public function index()
    {
        $vendors = Vendor::orderBy('company_name')->get();
        $drivers = Driver::where('status', 'active')->orderBy('name')->get();
        $invoices = VendorInvoice::with('vendor')->latest()->limit(50)->get();
        $driverPayments = DriverPayment::with('driver')->latest()->limit(50)->get();
        $expenses = OperationExpense::latest()->limit(50)->get();

        // Summary stats
        $totalPendingInvoices = VendorInvoice::whereIn('status', ['pending', 'sent'])->sum('payable_amount');
        $totalDriverPaymentsThisMonth = DriverPayment::whereMonth('payment_date', now()->month)->sum('amount');
        $totalExpensesThisMonth = OperationExpense::whereMonth('expense_date', now()->month)->sum('amount');

        return view('admin.billing.index', compact(
            'vendors',
            'drivers',
            'invoices',
            'driverPayments',
            'expenses',
            'totalPendingInvoices',
            'totalDriverPaymentsThisMonth',
            'totalExpensesThisMonth'
        ));
    }

    public function generateVendorInvoice(Request $request)
    {
        $data = $request->validate([
            'vendor_id' => ['required', 'exists:vendors,id'],
            'period_start' => ['required', 'date'],
            'period_end' => ['required', 'date', 'after_or_equal:period_start'],
            'due_days' => ['nullable', 'integer', 'min:1', 'max:90'],
        ]);

        $trips = Trip::where('vendor_id', $data['vendor_id'])
            ->whereBetween('schedule_at', [$data['period_start'], $data['period_end']])
            ->where('status', 'completed')
            ->get();

        if ($trips->isEmpty()) {
            return back()->with('error', 'No completed trips found for this period.');
        }

        $total = $trips->sum('cost') ?: $trips->sum('estimated_cost');
        $tax = $total * 0.18;
        $payable = $total + $tax;
        $dueDays = $data['due_days'] ?? 30;

        $invoice = VendorInvoice::create([
            'vendor_id' => $data['vendor_id'],
            'invoice_number' => 'INV-' . now()->format('Ymd') . '-' . Str::upper(Str::random(4)),
            'invoice_date' => now(),
            'due_date' => now()->addDays($dueDays),
            'period_start' => $data['period_start'],
            'period_end' => $data['period_end'],
            'total_amount' => $total,
            'tax_amount' => $tax,
            'payable_amount' => $payable,
            'status' => 'pending',
            'created_by' => auth()->id(),
        ]);

        foreach ($trips as $trip) {
            VendorInvoiceItem::create([
                'vendor_invoice_id' => $invoice->id,
                'trip_id' => $trip->id,
                'description' => 'Trip #' . $trip->id . ' - ' . ($trip->route->name ?? 'Ad-hoc'),
                'amount' => $trip->cost ?? $trip->estimated_cost ?? 0,
            ]);
        }

        return back()->with('success', 'Vendor invoice generated successfully. Invoice #' . $invoice->invoice_number);
    }

    /**
     * Send invoice to vendor (marks as sent and sends notification)
     */
    public function sendInvoice(VendorInvoice $invoice)
    {
        if ($invoice->status !== 'pending') {
            return back()->with('error', 'Only pending invoices can be sent.');
        }

        $invoice->update(['status' => 'sent']);

        // Send payment due alert
        $this->alertService->sendPaymentDueAlert($invoice);

        return back()->with('success', 'Invoice sent to vendor and payment alert generated.');
    }

    /**
     * Mark invoice as paid
     */
    public function markInvoicePaid(Request $request, VendorInvoice $invoice)
    {
        $data = $request->validate([
            'payment_date' => ['nullable', 'date'],
            'payment_reference' => ['nullable', 'string', 'max:255'],
        ]);

        $invoice->update([
            'status' => 'paid',
            'paid_at' => $data['payment_date'] ?? now(),
            'payment_reference' => $data['payment_reference'] ?? null,
        ]);

        return back()->with('success', 'Invoice marked as paid.');
    }

    public function storeDriverPayment(Request $request)
    {
        $data = $request->validate([
            'driver_id' => ['required', 'exists:drivers,id'],
            'payment_date' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'min:0'],
            'frequency' => ['nullable', 'string'],
            'remarks' => ['nullable', 'string', 'max:500'],
        ]);

        $data['created_by'] = auth()->id();

        DriverPayment::create($data);

        return back()->with('success', 'Driver payment recorded.');
    }

    public function storeExpense(Request $request)
    {
        $data = $request->validate([
            'vendor_id' => ['nullable', 'exists:vendors,id'],
            'driver_id' => ['nullable', 'exists:drivers,id'],
            'type' => ['required', 'string', 'max:100'],
            'amount' => ['required', 'numeric', 'min:0'],
            'expense_date' => ['required', 'date'],
            'remarks' => ['nullable', 'string'],
        ]);

        $data['created_by'] = auth()->id();

        OperationExpense::create($data);

        return back()->with('success', 'Expense recorded.');
    }
}


