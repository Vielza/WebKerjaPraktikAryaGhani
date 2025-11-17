<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // SESUAI DB - HANYA ADA created_at
    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // Relasi dengan Orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Relasi dengan Service Bookings
    public function serviceBookings()
    {
        return $this->hasMany(ServiceBooking::class);
    }

    // Relasi dengan Reviews
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Check if user is admin
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Check if user is regular user
    public function isUser()
    {
        return $this->role === 'user';
    }
}
