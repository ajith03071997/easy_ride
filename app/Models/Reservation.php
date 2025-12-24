<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'device_id',
        'session_type',
        'start_time',
        'end_time',
        'activation_is_automatic',
        'status'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'activation_is_automatic' => 'boolean'
    ];

    /**
     * Get the customer that owns the reservation.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the device that owns the reservation.
     */
    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
