<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeviceSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'customer_id',
        'daily_session_id',
        'start_time',
        'end_time',
        'total_amount',
        'extension_amount',
        'discount_amount',
        'status'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'total_amount' => 'decimal:2',
        'extension_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2'
    ];

    /**
     * Get the device that owns the device session.
     */
    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    /**
     * Get the customer that owns the device session.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the daily session that owns the device session.
     */
    public function dailySession()
    {
        return $this->belongsTo(DailySession::class);
    }
}
