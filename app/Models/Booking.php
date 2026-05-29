<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [

        'student_id',
        'tutor_id',
        'subject_id',

        // ✅ ADD THESE
        'availability_id',
        'session_time',

        'session_date',
        'hours',
        'total_price',
        'status',
        'session_mode',
        'meeting_link',
        'payment_status',
        'razorpay_payment_id',
        'razorpay_order_id',
        'paid_at',

        'student_phone',
        'student_address',
    ];

    // Booking belongs to student
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // Booking belongs to tutor
    public function tutor()
    {
        return $this->belongsTo(Tutor::class, 'tutor_id');
    }

    // Booking belongs to subject
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    // ✅ BOOKING BELONGS TO AVAILABILITY
    public function availability()
    {
        return $this->belongsTo(Availability::class);
    }

    // Booking has one payment
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}