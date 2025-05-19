<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'amount',
        'payment_method',
        'status',
        'transaction_id',
        'card_type',
        'card_last_four',
        'card_expiry',
        'notes'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
} 