<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Room extends Model
{
    use HasFactory;

    public const STATUS_AVAILABLE = 'available';
    public const STATUS_OCCUPIED = 'occupied';
    public const STATUS_RESERVED = 'reserved';
    public const STATUS_CLEANING = 'cleaning';
    public const STATUS_MAINTENANCE = 'maintenance';

    protected $fillable = [
        'room_number',
        'category_id',
        'type',
        'floor',
        'price',
        'price_per_night',
        'capacity',
        'description',
        'amenities',
        'status',
        'has_view',
        'is_smoking',
        'image',
        'image_url'
    ];

    protected $casts = [
        'amenities' => 'array',
        'has_view' => 'boolean',
        'is_smoking' => 'boolean',
        'price' => 'decimal:2',
        'price_per_night' => 'decimal:2'
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function currentBooking()
    {
        return $this->hasOne(Booking::class)
            ->where(function($query) {
                $query->where('status', 'checked_in')
                    ->orWhere(function($q) {
                        $q->where('status', 'approved')
                            ->whereDate('check_in_date', '<=', now())
                            ->whereDate('check_out_date', '>=', now());
                    });
            });
    }

    // Helper method to update room status based on booking
    public function updateStatusFromBooking($bookingStatus)
    {
        switch ($bookingStatus) {
            case 'checked_in':
                $this->status = self::STATUS_OCCUPIED;
                break;
            case 'approved':
                $this->status = self::STATUS_RESERVED;
                break;
            default:
                $this->status = self::STATUS_AVAILABLE;
        }
        $this->save();
    }
}
