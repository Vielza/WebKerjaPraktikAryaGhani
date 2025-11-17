<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Sparepart extends Model
{
    use HasFactory;

    // Jika tidak ada timestamps
    public $timestamps = false;

    protected $fillable = [
        'name',
        'description', 
        'price',
        'stock',
        'image'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer'
    ];

    // Relasi ke order details
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    // Relasi ke orders melalui order_details
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_details')
                    ->withPivot('quantity', 'subtotal');
    }

    // Scope untuk stok rendah
    public function scopeLowStock($query, $threshold = 5)
    {
        return $query->where('stock', '<=', $threshold);
    }

    // Scope untuk stok tersedia
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Return a usable URL for the image (handles spareparts / sparepart folders and variants).
     */
    public function getImageUrlAttribute()
    {
        $raw = $this->image;
        if (! $raw) {
            return null;
        }

        // absolute url
        if (Str::startsWith($raw, ['http://', 'https://'])) {
            return $raw;
        }

        // already "storage/..."
        if (Str::startsWith($raw, 'storage/')) {
            return asset($raw);
        }

        // "public/..." prefix
        if (Str::startsWith($raw, 'public/')) {
            $candidate = Str::after($raw, 'public/');
            if (Storage::disk('public')->exists($candidate)) {
                return Storage::url($candidate);
            }
        }

        // try candidates on public disk: raw, singular/plural folder variants
        $candidates = [
            $raw,
            Str::replaceFirst('spareparts/', 'sparepart/', $raw),
            Str::replaceFirst('sparepart/', 'spareparts/', $raw),
        ];

        foreach ($candidates as $c) {
            if ($c && Storage::disk('public')->exists($c)) {
                return Storage::url($c);
            }
        }

        // fallback: file directly in public/ folder
        if (file_exists(public_path($raw))) {
            return asset($raw);
        }

        return null;
    }
}
