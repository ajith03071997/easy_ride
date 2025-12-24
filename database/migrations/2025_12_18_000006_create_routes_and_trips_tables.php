<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id')->index();
            $table->time('pickup_time')->nullable();
            $table->boolean('weekly_fixed')->default(false);
            $table->string('name')->nullable();
            $table->unsignedBigInteger('driver_id')->nullable()->index();
            $table->unsignedBigInteger('vehicle_id')->nullable()->index();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('route_points', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('route_id')->index();
            $table->string('type'); // pickup / drop
            $table->string('location');
            $table->time('time')->nullable();
            $table->integer('sequence')->default(0);
            $table->timestamps();
        });

        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id')->index();
            $table->unsignedBigInteger('route_id')->nullable()->index();
            $table->unsignedBigInteger('driver_id')->nullable()->index();
            $table->unsignedBigInteger('vehicle_id')->nullable()->index();
            $table->dateTime('schedule_at')->nullable();
            $table->boolean('auto_assign')->default(false);
            $table->boolean('manual_assign')->default(false);
            $table->boolean('live_tracking')->default(false);
            $table->string('status')->default('pending');
            $table->decimal('distance_km', 8, 2)->nullable();
            $table->decimal('cost', 10, 2)->nullable();
            $table->json('completion_report')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trips');
        Schema::dropIfExists('route_points');
        Schema::dropIfExists('routes');
    }
};


