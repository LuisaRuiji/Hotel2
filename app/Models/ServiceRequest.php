<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'booking_id',
        'service_id',
        'requested_date',
        'requested_time',
        'notes',
        'status',
        'completed_at',
        'staff_notes'
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'requested_date' => 'date',
        'completed_at' => 'datetime',
    ];
    
    /**
     * Get the user that owns the service request.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the booking that owns the service request.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
    
    /**
     * Get the service that owns the service request.
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
