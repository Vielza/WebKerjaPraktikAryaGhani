<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    // DISABLE TIMESTAMPS karena tabel tidak memiliki created_at/updated_at
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'sparepart_id',
        'quantity',
        'subtotal'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'quantity' => 'integer'
    ];

    // RELATIONSHIP KE ORDER
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // RELATIONSHIP KE SPAREPART
    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class);
    }

    // Accessor untuk format subtotal
    public function getFormattedSubtotalAttribute()
    {
        return 'Rp' . number_format($this->subtotal, 0, ',', '.');
    }
}