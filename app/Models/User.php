<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // user can have one tutor profile
    public function tutor()
    {
        return $this->hasOne(Tutor::class);
    }

    // user can have many bookings as student
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'student_id');
    }

    // user can have many payments
    public function payments()
    {
        return $this->hasMany(Payment::class, 'student_id');
    }
}