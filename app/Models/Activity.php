<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'description',
        'action',
        'model_type',
        'model_id',
        'status',
    ];

    /**
     * Get the user who performed this activity.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 