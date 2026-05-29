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

    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}