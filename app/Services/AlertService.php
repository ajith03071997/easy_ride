<?php

namespace App\Services;

use App\Models\SystemNotification;
use App\Models\Trip;
use App\Models\Driver;
use App\Models\VendorInvoice;
use App\Models\Vehicle;
use Carbon\Carbon;

class AlertService
{
    /**
     * Send a trip delay alert to driver and vendor
     */
    public function sendTripDelayAlert(Trip $trip, string $reason = null): void
    {
        $message = "Trip #{$trip->id} has been delayed.";
        if ($reason) {
            $message .= " Reason: {$reason}";
        }

        // Alert to Driver
        if ($trip->driver_id) {
            SystemNotification::create([
                'user_id' => $trip->driver->user_id ?? null,
                'type' => 'trip_delay',
                'title' => 'Trip Delayed',
                'message' => $message,
                'data' => json_encode(['trip_id' => $trip->id, 'reason' => $reason]),
            ]);
        }

        // Alert to Vendor users
        if ($trip->route && $trip->route->vendor_id) {
            $vendorUsers = \App\Models\User::where('vendor_id', $trip->route->vendor_id)->get();
            foreach ($vendorUsers as $user) {
                SystemNotification::create([
                    'user_id' => $user->id,
                    'type' => 'trip_delay',
                    'title' => 'Trip Delayed',
                    'message' => $message,
                    'data' => json_encode(['trip_id' => $trip->id, 'reason' => $reason]),
                ]);
            }
        }
    }

    /**
     * Send a vehicle change alert
     */
    public function sendVehicleChangeAlert(Trip $trip, Vehicle $oldVehicle, Vehicle $newVehicle): void
    {
        $message = "Vehicle changed for Trip #{$trip->id} from {$oldVehicle->vehicle_number} to {$newVehicle->vehicle_number}.";

        // Alert to Driver
        if ($trip->driver_id) {
            SystemNotification::create([
                'user_id' => $trip->driver->user_id ?? null,
                'type' => 'vehicle_change',
                'title' => 'Vehicle Changed',
                'message' => $message,
                'data' => json_encode([
                    'trip_id' => $trip->id,
                    'old_vehicle_id' => $oldVehicle->id,
                    'new_vehicle_id' => $newVehicle->id,
                ]),
            ]);
        }

        // Alert to Vendor users
        if ($trip->route && $trip->route->vendor_id) {
            $vendorUsers = \App\Models\User::where('vendor_id', $trip->route->vendor_id)->get();
            foreach ($vendorUsers as $user) {
                SystemNotification::create([
                    'user_id' => $user->id,
                    'type' => 'vehicle_change',
                    'title' => 'Vehicle Changed',
                    'message' => $message,
                    'data' => json_encode([
                        'trip_id' => $trip->id,
                        'old_vehicle_id' => $oldVehicle->id,
                        'new_vehicle_id' => $newVehicle->id,
                    ]),
                ]);
            }
        }
    }

    /**
     * Send payment due alert to vendor
     */
    public function sendPaymentDueAlert(VendorInvoice $invoice): void
    {
        $daysUntilDue = Carbon::today()->diffInDays($invoice->due_date, false);
        $message = "Invoice #{$invoice->invoice_number} for ₹{$invoice->total_amount} is due ";

        if ($daysUntilDue <= 0) {
            $message .= "today!";
        } else {
            $message .= "in {$daysUntilDue} day(s).";
        }

        // Alert to all vendor users
        $vendorUsers = \App\Models\User::where('vendor_id', $invoice->vendor_id)->get();
        foreach ($vendorUsers as $user) {
            SystemNotification::create([
                'user_id' => $user->id,
                'type' => 'payment_due',
                'title' => 'Payment Due Alert',
                'message' => $message,
                'data' => json_encode([
                    'invoice_id' => $invoice->id,
                    'invoice_number' => $invoice->invoice_number,
                    'amount' => $invoice->total_amount,
                    'due_date' => $invoice->due_date,
                ]),
            ]);
        }
    }

    /**
     * Send new trip assigned alert to driver
     */
    public function sendTripAssignedAlert(Trip $trip): void
    {
        if (!$trip->driver_id || !$trip->driver->user_id) {
            return;
        }

        $message = "New trip #{$trip->id} has been assigned to you for {$trip->scheduled_date}.";

        SystemNotification::create([
            'user_id' => $trip->driver->user_id,
            'type' => 'trip_assigned',
            'title' => 'New Trip Assigned',
            'message' => $message,
            'data' => json_encode([
                'trip_id' => $trip->id,
                'scheduled_date' => $trip->scheduled_date,
                'scheduled_time' => $trip->scheduled_time,
            ]),
        ]);
    }

    /**
     * Send pickup time reminder to driver
     */
    public function sendPickupReminder(Trip $trip): void
    {
        if (!$trip->driver_id || !$trip->driver->user_id) {
            return;
        }

        $message = "Reminder: Trip #{$trip->id} pickup is scheduled at {$trip->scheduled_time}.";

        SystemNotification::create([
            'user_id' => $trip->driver->user_id,
            'type' => 'pickup_reminder',
            'title' => 'Pickup Time Reminder',
            'message' => $message,
            'data' => json_encode([
                'trip_id' => $trip->id,
                'scheduled_time' => $trip->scheduled_time,
            ]),
        ]);
    }

    /**
     * Send route change alert to driver
     */
    public function sendRouteChangeAlert(Trip $trip, string $changeDescription): void
    {
        if (!$trip->driver_id || !$trip->driver->user_id) {
            return;
        }

        $message = "Route changed for Trip #{$trip->id}: {$changeDescription}";

        SystemNotification::create([
            'user_id' => $trip->driver->user_id,
            'type' => 'route_change',
            'title' => 'Route Changed',
            'message' => $message,
            'data' => json_encode([
                'trip_id' => $trip->id,
                'change_description' => $changeDescription,
            ]),
        ]);
    }

    /**
     * Send trip status update to vendor
     */
    public function sendTripStatusUpdateToVendor(Trip $trip): void
    {
        if (!$trip->route || !$trip->route->vendor_id) {
            return;
        }

        $message = "Trip #{$trip->id} status updated to: " . ucfirst($trip->status);

        $vendorUsers = \App\Models\User::where('vendor_id', $trip->route->vendor_id)->get();
        foreach ($vendorUsers as $user) {
            SystemNotification::create([
                'user_id' => $user->id,
                'type' => 'trip_status_update',
                'title' => 'Trip Status Update',
                'message' => $message,
                'data' => json_encode([
                    'trip_id' => $trip->id,
                    'status' => $trip->status,
                ]),
            ]);
        }
    }

    /**
     * Send document expiry alert to driver
     */
    public function sendDocumentExpiryAlert(Driver $driver, string $documentType, $expiryDate): void
    {
        if (!$driver->user_id) {
            return;
        }

        $daysUntilExpiry = Carbon::today()->diffInDays($expiryDate, false);
        $message = "Your {$documentType} document will expire ";

        if ($daysUntilExpiry <= 0) {
            $message .= "today! Please upload a new document.";
        } else {
            $message .= "in {$daysUntilExpiry} day(s). Please renew it soon.";
        }

        SystemNotification::create([
            'user_id' => $driver->user_id,
            'type' => 'document_expiry',
            'title' => 'Document Expiry Alert',
            'message' => $message,
            'data' => json_encode([
                'driver_id' => $driver->id,
                'document_type' => $documentType,
                'expiry_date' => $expiryDate,
            ]),
        ]);
    }
}

