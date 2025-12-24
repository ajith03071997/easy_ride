<?php

namespace App\Models;

use App\Enums\TripStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trip extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'vendor_id',
        'route_id',
        'driver_id',
        'vehicle_id',
        'trip_type',
        'special_type',
        'priority',
        'special_instructions',
        'schedule_at',
        'scheduled_date',
        'scheduled_time',
        'auto_assign',
        'manual_assign',
        'weekly_days',
        'weekly_start_date',
        'weekly_end_date',
        'live_tracking',
        'status',
        'distance_km',
        'cost',
        'estimated_cost',
        'completion_report',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'schedule_at' => 'datetime',
        'scheduled_date' => 'date',
        'weekly_start_date' => 'date',
        'weekly_end_date' => 'date',
        'auto_assign' => 'bool',
        'manual_assign' => 'bool',
        'live_tracking' => 'bool',
        'completion_report' => 'array',
        'weekly_days' => 'array',
        'status' => TripStatus::class,
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Check if trip is a weekly recurring trip
     */
    public function isWeekly(): bool
    {
        return $this->trip_type === 'weekly';
    }

    /**
     * Check if trip is a special request
     */
    public function isSpecialRequest(): bool
    {
        return $this->trip_type === 'special';
    }

    /**
     * Check if trip is high priority
     */
    public function isHighPriority(): bool
    {
        return in_array($this->priority, ['high', 'urgent']);
    }
}


