<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('single_price_per_hour', 8, 2);
            $table->boolean('supports_multiplayer')->default(false);
            $table->enum('device_type', ['PlayStation', 'Room', 'Computer', 'Ping Pong', 'Billiards']);
            $table->enum('device_status', ['Working', 'Maintenance', 'Stopped'])->default('Working');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
