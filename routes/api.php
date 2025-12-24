<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Driver\AuthController as DriverAuthController;
use App\Http\Controllers\Api\Driver\TripController as DriverTripController;
use App\Http\Controllers\Api\Driver\EarningController as DriverEarningController;
use App\Http\Controllers\Api\Driver\VehicleController as DriverVehicleController;
use App\Http\Controllers\Api\Driver\SupportController as DriverSupportController;
use App\Http\Controllers\Api\Driver\NotificationController as DriverNotificationController;

Route::prefix('v1/driver')->group(function () {
    Route::post('login', [DriverAuthController::class, 'login']);

    Route::middleware(['auth:sanctum', 'role:driver'])->group(function () {
        Route::get('me', [DriverAuthController::class, 'me']);
        Route::post('logout', [DriverAuthController::class, 'logout']);

        // Trips
        Route::get('trips/today', [DriverTripController::class, 'today']);
        Route::get('trips/{trip}', [DriverTripController::class, 'show']);
        Route::post('trips/{trip}/accept', [DriverTripController::class, 'accept']);
        Route::post('trips/{trip}/start', [DriverTripController::class, 'start']);
        Route::post('trips/{trip}/complete', [DriverTripController::class, 'complete']);
        Route::post('trips/{trip}/location', [DriverTripController::class, 'updateLocation']);

        // Earnings
        Route::get('earnings/daily', [DriverEarningController::class, 'daily']);
        Route::get('earnings/weekly', [DriverEarningController::class, 'weekly']);

        // Vehicle & Documents
        Route::get('vehicle', [DriverVehicleController::class, 'show']);
        Route::post('vehicle/documents', [DriverVehicleController::class, 'uploadDocument']);
        Route::get('vehicle/documents', [DriverVehicleController::class, 'documents']);

        // Notifications
        Route::get('notifications', [DriverNotificationController::class, 'index']);
        Route::post('notifications/{notification}/read', [DriverNotificationController::class, 'markAsRead']);

        // Support
        Route::get('support/contact', [DriverSupportController::class, 'contact']);
        Route::post('support/vehicle-issue', [DriverSupportController::class, 'reportVehicleIssue']);
        Route::post('support/emergency', [DriverSupportController::class, 'emergency']);
    });
});


