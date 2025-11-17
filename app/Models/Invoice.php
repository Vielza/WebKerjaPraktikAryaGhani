<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'invoice_number',
        'total_amount',
        'status'
    ];

    public function booking()
    {
        return $this->belongsTo(ServiceBooking::class, 'booking_id');
    }
}
