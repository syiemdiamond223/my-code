<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'student_id',//who made the payment
        'booking_id',//which booking this payment is for
        'amount',//how much was paid
        'method',// payment method (e.g., Razorpay, PayPal)
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