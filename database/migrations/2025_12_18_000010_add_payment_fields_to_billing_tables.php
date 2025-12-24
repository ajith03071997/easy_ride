<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vendor_invoices', function (Blueprint $table) {
            $table->date('due_date')->nullable()->after('period_end');
            $table->timestamp('paid_at')->nullable()->after('status');
            $table->string('payment_reference')->nullable()->after('paid_at');
        });

        Schema::table('driver_payments', function (Blueprint $table) {
            $table->text('remarks')->nullable()->after('frequency');
        });

        Schema::table('operation_expenses', function (Blueprint $table) {
            $table->unsignedBigInteger('driver_id')->nullable()->after('vendor_id')->index();
        });
    }

    public function down(): void
    {
        Schema::table('vendor_invoices', function (Blueprint $table) {
            $table->dropColumn(['due_date', 'paid_at', 'payment_reference']);
        });

        Schema::table('driver_payments', function (Blueprint $table) {
            $table->dropColumn('remarks');
        });

        Schema::table('operation_expenses', function (Blueprint $table) {
            $table->dropColumn('driver_id');
        });
    }
};

