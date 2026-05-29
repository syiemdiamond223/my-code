<?php

namespace App\Models;

use App\Models\Availability;
use Illuminate\Database\Eloquent\Model;

class Tutor extends Model
{
    protected $fillable = [
        'user_id',
        'bio',
        'phone',
        'qualification',
        'experience',
        'institution',
        'price_per_hour',
        'mode',
        'is_approved',
        'status',
        'rejection_message',
    ];

    // Tutor belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Tutor has many subjects
    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    // Tutor has many bookings
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function availabilities()
    {
        return $this->hasMany(Availability::class);
    }
}