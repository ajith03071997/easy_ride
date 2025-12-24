<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoutePoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'route_id',
        'type',
        'location',
        'time',
        'sequence',
    ];

    public function route()
    {
        return $this->belongsTo(Route::class);
    }
}


