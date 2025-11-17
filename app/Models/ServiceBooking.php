<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceBooking extends Model
{
    use HasFactory;

    protected $table = 'service_bookings'; // Nama tabel di database

    // SESUAIKAN dengan kolom yang ada di database
    protected $fillable = [
        'user_id',
        'booking_date',
        'status'
    ];

    protected $casts = [
        'booking_date' => 'datetime'
    ];

    // Nonaktifkan updated_at karena tidak ada di database
    public $timestamps = false;

    // Override created_at saja
    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function review()
    {
        return $this->hasOne(Review::class, 'service_id');
    }
}
