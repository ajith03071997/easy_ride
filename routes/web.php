<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\VendorController as AdminVendorController;
use App\Http\Controllers\Admin\DriverController as AdminDriverController;
use App\Http\Controllers\Admin\RouteController as AdminRouteController;
use App\Http\Controllers\Admin\TripController as AdminTripController;
use App\Http\Controllers\Admin\BillingController as AdminBillingController;
use App\Http\Controllers\Admin\SupportController as AdminSupportController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Vendor\DashboardController as VendorDashboardController;
use App\Http\Controllers\Vendor\TripController as VendorTripController;
use App\Http\Controllers\Vendor\RouteController as VendorRouteController;
use App\Http\Controllers\Vendor\BillingController as VendorBillingController;
use App\Http\Controllers\Vendor\SupportController as VendorSupportController;
use App\Http\Controllers\Vendor\NotificationController as VendorNotificationController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Admin Routes
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Admin user management
        Route::resource('users', AdminUserController::class);

        // Admin vendor management
        Route::resource('vendors', AdminVendorController::class);

        // Driver management
        Route::resource('drivers', AdminDriverController::class);
        Route::post('drivers/{driver}/vehicle', [AdminDriverController::class, 'updateVehicle'])
            ->name('drivers.update-vehicle');
        Route::post('drivers/{driver}/documents', [AdminDriverController::class, 'uploadDocument'])
            ->name('drivers.upload-document');

        // Routes & trips
        Route::resource('routes', AdminRouteController::class);
        Route::resource('trips', AdminTripController::class)->only(['index', 'show', 'edit', 'update']);
        Route::post('trips/{trip}/approve', [AdminTripController::class, 'approve'])->name('trips.approve');
        Route::post('trips/{trip}/cancel', [AdminTripController::class, 'cancel'])->name('trips.cancel');
        Route::post('trips/{trip}/mark-delayed', [AdminTripController::class, 'markDelayed'])->name('trips.mark-delayed');

        // Billing & payments
        Route::get('billing', [AdminBillingController::class, 'index'])->name('billing.index');
        Route::post('billing/generate-vendor-invoice', [AdminBillingController::class, 'generateVendorInvoice'])
            ->name('billing.generate-vendor-invoice');
        Route::post('billing/invoices/{invoice}/send', [AdminBillingController::class, 'sendInvoice'])
            ->name('billing.invoices.send');
        Route::post('billing/invoices/{invoice}/mark-paid', [AdminBillingController::class, 'markInvoicePaid'])
            ->name('billing.invoices.mark-paid');
        Route::post('billing/driver-payments', [AdminBillingController::class, 'storeDriverPayment'])
            ->name('billing.driver-payments.store');
        Route::post('billing/expenses', [AdminBillingController::class, 'storeExpense'])
            ->name('billing.expenses.store');

        // Notifications
        Route::get('notifications', [AdminNotificationController::class, 'index'])->name('notifications.index');

        // Support / Helpdesk
        Route::resource('support-tickets', AdminSupportController::class)->only(['index', 'show', 'update']);

        // Reports
        Route::get('reports', [AdminReportController::class, 'index'])->name('reports.index');
    });

// Vendor Routes
Route::prefix('vendor')
    ->name('vendor.')
    ->middleware(['auth', 'role:vendor'])
    ->group(function () {
        Route::get('/dashboard', [VendorDashboardController::class, 'index'])->name('dashboard');

        // Trip booking
        Route::resource('trips', VendorTripController::class)->only(['index', 'create', 'store', 'show']);

        // Employee routes
        Route::resource('routes', VendorRouteController::class)->only(['index', 'create', 'store', 'show']);

        // Billing & expenses
        Route::get('billing', [VendorBillingController::class, 'index'])->name('billing.index');

        // Notifications
        Route::get('notifications', [VendorNotificationController::class, 'index'])->name('notifications.index');

        // Support
        Route::resource('support-tickets', VendorSupportController::class)->only(['index', 'create', 'store', 'show']);
    });
