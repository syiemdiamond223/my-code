<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    protected $fillable = [
        'tutor_id',
        'available_date',
        'start_time',
        'end_time',
        'status',
    ];

    //Relationships
    public function tutor()
    {
        // ONE AVAILABILITY BELONGS TO ONE TUTOR
        return $this->belongsTo(Tutor::class);
    }

    public function bookings()
    {
        // ONE AVAILABILITY CAN HAVE MANY BOOKINGS
        return $this->hasMany(Booking::class);
    }
}