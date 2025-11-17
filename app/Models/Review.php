<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews'; 

    protected $fillable = [
        'user_id',
        'rating',
        'comment',
        'created_at',
    ];

    
    public $timestamps = false;

    /**
     * Relationship dengan User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}