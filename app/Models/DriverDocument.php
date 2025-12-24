<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DriverDocument extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'driver_id',
        'type',
        'file_path',
        'expiry_date',
        'created_by',
        'updated_by',
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}


