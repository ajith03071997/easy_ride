<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DailySession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'opening_balance',
        'closing_balance',
        'opened_at',
        'closed_at',
        'status'
    ];

    protected $casts = [
        'opened_at' => 'datetime',
        'closed_at' => 'datetime',
        'opening_balance' => 'decimal:2',
        'closing_balance' => 'decimal:2'
    ];

    /**
     * Get the user that owns the daily session.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the device sessions for the daily session.
     */
    public function deviceSessions()
    {
        return $this->hasMany(DeviceSession::class);
    }

    /**
     * Get the expenses for the daily session.
     */
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
