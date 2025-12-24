<?php

namespace App\Console\Commands;

use App\Models\DriverDocument;
use App\Services\AlertService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendDocumentExpiryAlerts extends Command
{
    protected $signature = 'alerts:document-expiry';
    protected $description = 'Send document expiry alerts to drivers for documents expiring within 30 days';

    public function handle(AlertService $alertService): int
    {
        $today = Carbon::today();
        $expiresWithinMonth = $today->copy()->addDays(30);

        // Get documents expiring within 30 days
        $documents = DriverDocument::with('driver')
            ->whereBetween('expiry_date', [$today, $expiresWithinMonth])
            ->get();

        $count = 0;
        foreach ($documents as $document) {
            if ($document->driver) {
                $alertService->sendDocumentExpiryAlert(
                    $document->driver,
                    $document->document_type,
                    $document->expiry_date
                );
                $count++;
            }
        }

        $this->info("Sent {$count} document expiry alert(s).");

        return Command::SUCCESS;
    }
}

