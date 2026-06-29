<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tutor;
use App\Models\Booking;

class Subject extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];
    
    public function tutors()
    {
        // MANY SUBJECTS CAN BELONG TO MANY TUTORS
        return $this->belongsToMany(Tutor::class);
    }
    public function bookings()
    {
        // ONE SUBJECT CAN HAVE MANY BOOKINGS
        return $this->hasMany(Booking::class);
    }
}
