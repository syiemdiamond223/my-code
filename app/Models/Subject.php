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
        return $this->belongsToMany(Tutor::class);
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
