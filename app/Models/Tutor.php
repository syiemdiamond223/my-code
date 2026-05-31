<?php

namespace App\Models;

use App\Models\Availability;
use Illuminate\Database\Eloquent\Model;

class Tutor extends Model
{
    protected $fillable = [
        'user_id',//which user this tutor profile belongs to
        'bio',//brief description of the tutor
        'phone',//tutor's phone number
        'qualification',//educational qualifications
        'experience',//teaching experience
        'institution',//institution where the tutor is affiliated
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

    // Tutor has many availabilities
    public function availabilities()
    {
        return $this->hasMany(Availability::class);
    }
}