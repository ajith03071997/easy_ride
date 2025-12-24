<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->string('trip_type')->default('single')->after('vehicle_id'); // single, weekly, special
            $table->date('scheduled_date')->nullable()->after('schedule_at');
            $table->time('scheduled_time')->nullable()->after('scheduled_date');
            $table->string('special_type')->nullable()->after('trip_type'); // late_night, emergency, airport, outstation
            $table->string('priority')->default('normal')->after('special_type'); // normal, high, urgent
            $table->text('special_instructions')->nullable()->after('priority');
            $table->decimal('estimated_cost', 10, 2)->nullable()->after('cost');
            $table->json('weekly_days')->nullable()->after('manual_assign'); // [1,2,3,4,5] for Mon-Fri
            $table->date('weekly_start_date')->nullable()->after('weekly_days');
            $table->date('weekly_end_date')->nullable()->after('weekly_start_date');
        });
    }

    public function down(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->dropColumn([
                'trip_type',
                'scheduled_date',
                'scheduled_time',
                'special_type',
                'priority',
                'special_instructions',
                'estimated_cost',
                'weekly_days',
                'weekly_start_date',
                'weekly_end_date',
            ]);
        });
    }
};

