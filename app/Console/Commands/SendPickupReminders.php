<?php

namespace App\Console\Commands;

use App\Models\Trip;
use App\Services\AlertService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendPickupReminders extends Command
{
    protected $signature = 'alerts:pickup-reminders';
    protected $description = 'Send pickup time reminders to drivers for trips starting within 1 hour';

    public function handle(AlertService $alertService): int
    {
        $now = Carbon::now();
        $oneHourLater = $now->copy()->addHour();

        // Get trips scheduled within the next hour that are assigned/accepted
        $trips = Trip::with('driver')
            ->whereIn('status', ['assigned', 'accepted'])
            ->whereDate('scheduled_date', $now->toDateString())
            ->whereTime('scheduled_time', '>=', $now->toTimeString())
            ->whereTime('scheduled_time', '<=', $oneHourLater->toTimeString())
            ->get();

        $count = 0;
        foreach ($trips as $trip) {
            if ($trip->driver) {
                $alertService->sendPickupReminder($trip);
                $count++;
            }
        }

        $this->info("Sent {$count} pickup reminder(s).");

        return Command::SUCCESS;
    }
}

