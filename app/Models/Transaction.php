<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'invoice_number',
        'booking_id',
        'user_id',
        'payment_method',
        'amount',
        'description',
        'guest_name',
        'room_number',
        'reference_number',
        'status',
    ];

    /**
     * Get the user who processed this transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the booking related to this transaction.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}