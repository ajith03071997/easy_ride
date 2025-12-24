<?php

namespace App\Console\Commands;

use App\Models\VendorInvoice;
use App\Services\AlertService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendPaymentDueAlerts extends Command
{
    protected $signature = 'alerts:payment-due';
    protected $description = 'Send payment due alerts to vendors for invoices due within 7 days';

    public function handle(AlertService $alertService): int
    {
        $today = Carbon::today();
        $dueWithinWeek = $today->copy()->addDays(7);

        // Get invoices that are sent but not paid and due within 7 days
        $invoices = VendorInvoice::where('status', 'sent')
            ->whereBetween('due_date', [$today, $dueWithinWeek])
            ->get();

        $count = 0;
        foreach ($invoices as $invoice) {
            $alertService->sendPaymentDueAlert($invoice);
            $count++;
        }

        $this->info("Sent {$count} payment due alert(s).");

        return Command::SUCCESS;
    }
}

