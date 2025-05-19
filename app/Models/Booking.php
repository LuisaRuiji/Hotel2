<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_id',
        'check_in_date',
        'check_out_date',
        'guests',
        'special_requests',
        'total_amount',
        'status',
        'checked_in_at',
        'checked_in_by',
        'notes',
        'payment_method',
        'payment_amount',
        'discount_type',
        'discount_id',
        'payment_date',
        'card_last_four',
        'approved_at',
        'approved_by',
        'cancelled_at',
        'cancelled_by',
        'checked_out_at',
        'checked_out_by',
        'cancellation_date',
        'refund_amount'
    ];

    protected $casts = [
        'check_in_date' => 'datetime',
        'check_out_date' => 'datetime',
        'total_amount' => 'decimal:2',
        'payment_amount' => 'decimal:2',
        'checked_in_at' => 'datetime',
        'checked_out_at' => 'datetime',
        'payment_date' => 'datetime',
        'approved_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'cancellation_date' => 'datetime',
        'refund_amount' => 'decimal:2'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'booking_services')
                    ->withPivot('quantity', 'scheduled_at', 'notes')
                    ->withTimestamps();
    }

    public function checkedInBy()
    {
        return $this->belongsTo(User::class, 'checked_in_by');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // Scope for pending check-ins
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Scope for checked-in bookings
    public function scopeCheckedIn($query)
    {
        return $query->where('status', 'checked_in');
    }

    // Check if booking can be checked in
    public function canCheckIn()
    {
        return $this->status === 'pending' && 
               $this->check_in_date->startOfDay() <= Carbon::now()->startOfDay();
    }

    // Check if booking can be checked out
    public function canCheckOut()
    {
        return $this->status === 'checked_in';
    }
} 