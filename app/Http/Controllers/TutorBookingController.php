<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tutor;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class TutorBookingController extends Controller
{
    
    // TUTOR APPROVE
   public function approve($id)
    {
        $booking = Booking::findOrFail($id);

        $tutor = Tutor::where(
            'user_id',
            Auth::id()
        )->first();

        if (!$tutor || $booking->tutor_id != $tutor->id) {
            abort(403);
        }

        $booking->update([
            'status' => 'approved'
        ]);

        return back()->with(
            'success',
            'Booking approved successfully'
        );
    }

    // TUTOR REJECT
    public function reject($id)
    {
        $booking = Booking::findOrFail($id);

        $tutor = Tutor::where(
            'user_id',
            Auth::id()
        )->first();

        if (!$tutor || $booking->tutor_id != $tutor->id) {
            abort(403);
        }

        $booking->update([
            'status' => 'rejected',
            'refund_status' => 'refunded',
            'refund_amount' => $booking->total_price
        ]);

        if ($booking->availability) {
                $booking->availability->update([
                    'status' => 'available'
            ]);
        }


        return back()->with(
            'success',
            'Booking rejected successfully'
        );
    }

   public function addMeetingLink(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $tutor = Tutor::where('user_id', Auth::id())->first();

        if (!$tutor || $booking->tutor_id != $tutor->id) {
            abort(403);
        }

        $request->validate([
            'meeting_link' => 'required|url'
        ]);

        $booking->update([
            'meeting_link' => $request->meeting_link
        ]);

        return back()->with(
            'success',
            'Meeting link updated successfully'
        );
    }

    public function tutorSessions(Request $request)
    {
        $user = Auth::user();

        $tutor = Tutor::where('user_id', $user->id)->first();

        if (!$tutor) {
            return redirect()
                ->route('tutor.dashboard')
                ->with(
                    'error',
                    'Please complete your tutor profile first.'
                );
        }

        Booking::where('status', 'approved')
            ->whereDate('session_date', '<', today())
            ->update([
                'status' => 'completed'
            ]);

            $sessions = Booking::with(
                'student',
                'subject'
            )
            ->where('tutor_id', $tutor->id)
            ->latest()
            ->get();

            return view(
                'tutor.sessions',
                compact('sessions')
            );
    } 

    // TUTOR PAYMENTS
    public function payments(Request $request)
    {
        $tutor = Tutor::where(
            'user_id',
            Auth::id()
        )->first();

        $payments = Booking::with(
            'student',
            'subject'
        )
        ->where('tutor_id', $tutor->id)
        ->whereNotNull('payment_status')
        ->latest()
        ->get();

        $totalEarnings = $payments
            ->where('payment_status', 'paid')
            ->whereIn('status', ['approved', 'completed'])
            ->sum('total_price');

        $totalRefunds = $payments
            ->whereIn('refund_status', ['refunded', 'partial_refund'])
            ->sum('refund_amount');

        $pendingRefunds = $payments
            ->where('refund_status', 'pending')
            ->count();

        return view(
            'tutor.payments',
            compact(
                'payments',
                'totalEarnings',
                'totalRefunds',
                'pendingRefunds'
            )
        );
    }

    public function cancelSession($id)
    {
        $booking = Booking::findOrFail($id);

        $tutor = Tutor::where(
            'user_id',
            Auth::id()
        )->first();

        if (!$tutor || $booking->tutor_id != $tutor->id) {
            abort(403);
        }

        $booking->update([
            'status' => 'cancelled',
            'refund_status' => 'pending',
            'refund_amount' => $booking->total_price
        ]);

        if ($booking->availability) {
            $booking->availability->update([
                'status' => 'available'
            ]);
        }

        return back()->with(
            'success',
            'Session cancelled successfully.'
        );
    }
}
