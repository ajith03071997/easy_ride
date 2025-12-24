<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'single_price_per_hour',
        'supports_multiplayer',
        'device_type',
        'device_status'
    ];

    protected $casts = [
        'supports_multiplayer' => 'boolean',
        'single_price_per_hour' => 'decimal:2'
    ];

    /**
     * Get the reservations for the device.
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Get the device sessions for the device.
     */
    public function deviceSessions()
    {
        return $this->hasMany(DeviceSession::class);
    }
}
