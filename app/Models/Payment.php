<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'student_id',
        'booking_id',
        'amount',
        'method',
        'transaction_id',
        'status',
        'receipt',
    ];

    // payment belongs to booking
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // payment belongs to student
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}