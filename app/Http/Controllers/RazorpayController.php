<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\Booking;
use App\Models\Availability;
use Illuminate\Support\Facades\Auth;

class RazorpayController extends Controller
{
    public function pay()
    {
        $bookingData = session('booking_data');

        if (!$bookingData) {
            return redirect()
                ->route('student.dashboard')
                ->with('error', 'Booking information missing.');
        }

        $api = new Api(
            env('RAZORPAY_KEY_ID'),
            env('RAZORPAY_KEY_SECRET')
        );

        $order = $api->order->create([
            'receipt' => 'booking_' . time(),
            'amount' => $bookingData['total_price'] * 100,
            'currency' => 'INR'
        ]);

        return view(
            'student.razorpay',
            compact('order', 'bookingData')
        );
    }

 public function success(Request $request)
    {
        $bookingData = session('booking_data');

        if (!$bookingData) {
            return redirect()
                ->route('student.dashboard')
                ->with('error', 'Booking data missing.');
        }

        $booking = Booking::create([

            'student_id' => $bookingData['student_id'],
            'tutor_id' => $bookingData['tutor_id'],
            'subject_id' => $bookingData['subject_id'],
            'student_class' => $bookingData['student_class'],
            'availability_id' => $bookingData['availability_id'],

            'session_date' => $bookingData['session_date'],
            'session_time' => $bookingData['session_time'],

            'hours' => $bookingData['hours'],
            'total_price' => $bookingData['total_price'],

            'status' => 'pending',

            'session_mode' => $bookingData['session_mode'],

            'payment_status' => 'paid',

            'student_phone' => $bookingData['student_phone'],
            'student_address' => $bookingData['student_address'],

            'razorpay_payment_id' => $request->payment_id,
            'razorpay_order_id' => $request->order_id,

            'paid_at' => now(),
        ]);

        Availability::where(
            'id',
            $bookingData['availability_id']
        )->update([
            'status' => 'unavailable'
        ]);

        session()->forget('booking_data');

        return redirect()
            ->route('student.bookings')
            ->with(
                'success',
                'Payment successful and booking created.'
            );
    }
}