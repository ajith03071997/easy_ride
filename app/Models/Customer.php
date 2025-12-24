<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone_number',
        'email',
        'observations'
    ];

    /**
     * Get the reservations for the customer.
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Get the device sessions for the customer.
     */
    public function deviceSessions()
    {
        return $this->hasMany(DeviceSession::class);
    }
}
