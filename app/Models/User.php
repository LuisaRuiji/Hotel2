<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'phone',
        'address',
        'employee_id',
        'last_login',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login' => 'datetime',
        ];
    }
    
    /**
     * Get the employee record associated with the user.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    
    /**
     * Get the bookings for the user.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    
    /**
     * Get the transactions processed by the user.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    
    /**
     * Get the activities performed by the user.
     */
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
    
    /**
     * Check if the user is an admin.
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    
    /**
     * Check if the user is a receptionist.
     */
    public function isReceptionist()
    {
        return $this->role === 'receptionist';
    }
    
    /**
     * Check if the user is a customer.
     */
    public function isCustomer()
    {
        return $this->role === 'customer';
    }
}
