<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tutor;
use App\Models\Booking;
use App\Models\Availability;
use Illuminate\Support\Facades\Auth;

class StudentBookingController extends Controller
{
    // BOOK SESSION FORM
    public function create($id)
    {
        $tutor = Tutor::with([
            'user',
            'subjects',
            'availabilities' => function ($q) {
                $q->where('status', 'available');
            }
        ])->findOrFail($id);

        return view('student.book-session', compact('tutor'));
    }

    // STORE BOOKING
    public function store(Request $request, $id)
    {
        $request->validate([
            'subject_id' => 'required',
            'hours' => 'required|numeric|min:1',
            'session_mode' => 'required',
            'student_phone' => 'nullable|required_if:session_mode,offline|digits:10',
            'student_address' => 'nullable|required_if:session_mode,offline|max:500',
            'student_class' => 'required|max:20',
            'availability_id' => 'required|exists:availabilities,id',
        ]);

        $tutor = Tutor::findOrFail($id);

        $availability = Availability::where('id', $request->availability_id)
            ->where('tutor_id', $tutor->id)
            ->where('status', 'available')
            ->first();

        if (!$availability) {
            return back()->withErrors([
                'availability_id' => 'Invalid slot selected.'
            ]);
        }
        
       $totalPrice = $tutor->price_per_hour * $request->hours;

        session([
            'booking_data' => [
                'student_id' => Auth::id(),
                'tutor_id' => $tutor->id,
                'subject_id' => $request->subject_id,
                'student_class' => $request->student_class,
                'availability_id' => $availability->id,
                'session_date' => $availability->available_date,
                'session_time' => $availability->start_time,
                'hours' => $request->hours,
                'total_price' => $totalPrice,
                'session_mode' => $request->session_mode,
                'student_phone' => $request->student_phone,
                'student_address' => $request->student_address,
            ]
        ]);

        return redirect()->route('student.payment.pay');
            }

    // STUDENT BOOKINGS
    public function index()
    {
        Booking::where('status', 'approved')
            ->whereDate('session_date', '<', today())
            ->update([
                'status' => 'completed'
            ]);

        $bookings = Booking::with(
            'tutor.user',
            'subject'
        )
        ->where('student_id', Auth::id())
        ->latest()
        ->get();

        return view(
            'student.bookings',
            compact('bookings')
        );
    }

    // CANCEL BOOKING
    public function cancel(Booking $booking)
    {
        if ($booking->student_id != Auth::id()) {
            abort(403);
        }

        if ($booking->status === 'completed') {
            return back()->with(
                'error',
                'Completed sessions cannot be cancelled.'
            );
        }

        $refundAmount = 0;

        if ($booking->payment_status === 'paid') {

            $sessionDateTime = strtotime(
                $booking->session_date . ' ' . $booking->session_time
            );

            $hoursRemaining =
                ($sessionDateTime - time()) / 3600;

            if ($hoursRemaining >= 24) {

                $refundAmount = $booking->total_price;

                $booking->update([
                    'refund_status' => 'pending',
                    'refund_amount' => $refundAmount
                ]);

            } else {

                $refundAmount = $booking->total_price * 0.5;

                $booking->update([
                    'refund_status' => 'partial_refund',
                    'refund_amount' => $refundAmount
                ]);
            }
        }

        $booking->update([
            'status' => 'cancelled'
        ]);

        if ($booking->availability) {
            $booking->availability->update([
                'status' => 'available'
            ]);
        }

        return redirect()
            ->route('student.bookings')
            ->with(
                'success',
                'Booking cancelled successfully.'
            );
    }

}
