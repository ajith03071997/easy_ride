<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorBillingSetting extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'vendor_id',
        'rate_per_km',
        'monthly_pass',
        'fixed_pricing',
        'tax_percentage',
        'billing_cycle',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'monthly_pass' => 'bool',
        'fixed_pricing' => 'bool',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}


