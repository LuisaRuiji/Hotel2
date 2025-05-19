<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'duration',
        'is_available',
        'image_url'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_available' => 'boolean'
    ];

    // Categories of services
    public const CATEGORIES = [
        'spa' => 'Spa & Wellness',
        'dining' => 'Dining & Restaurant',
        'transport' => 'Transportation',
        'laundry' => 'Laundry',
        'activities' => 'Activities & Recreation',
        'business' => 'Business Services'
    ];

    public function bookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_services')
            ->withPivot('quantity', 'scheduled_at', 'notes')
            ->withTimestamps();
    }
} 