<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'vendor_id',
        'name',
        'mobile',
        'email',
        'status',
        'rating',
        'created_by',
        'updated_by',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function documents()
    {
        return $this->hasMany(DriverDocument::class);
    }

    public function vehicle()
    {
        return $this->hasOne(Vehicle::class);
    }

    public function complaints()
    {
        return $this->hasMany(DriverComplaint::class);
    }
}


