<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'service_bookings';

    protected $fillable = [
        'user_id',
        'booking_date',
        'status',
    ];

    public $timestamps = false;

    protected $dates = [
        'booking_date',
        'created_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function review()
    {
        return $this->hasOne(\App\Models\Review::class, 'service_id');
    }
}