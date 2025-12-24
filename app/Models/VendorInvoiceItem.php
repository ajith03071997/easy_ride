<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorInvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_invoice_id',
        'trip_id',
        'description',
        'amount',
    ];

    public function invoice()
    {
        return $this->belongsTo(VendorInvoice::class, 'vendor_invoice_id');
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
}


