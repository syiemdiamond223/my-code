<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class StudentPaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = Booking::with(
            'tutor.user',
            'subject'
        )
        ->where('student_id', Auth::id())
        ->whereNotNull('payment_status');

        if ($request->filled('tutor')) {

            $payments->whereHas('tutor.user', function ($query) use ($request) {

                $query->where(
                    'name',
                    'like',
                    '%' . $request->tutor . '%'
                );

            });

        }

        if ($request->filled('status')) {

            $payments->where(
                'payment_status',
                $request->status
            );

        }

        if ($request->filled('date')) {

            $payments->whereDate(
                'session_date',
                $request->date
            );

        }

        $payments = $payments
            ->latest()
            ->get();

        $totalPaid = $payments
            ->where('payment_status', 'paid')
            ->whereNotIn('status', ['rejected', 'cancelled'])
            ->sum('total_price');

        $totalRefund = $payments
            ->whereIn('refund_status', ['refunded', 'partial_refund'])
            ->sum('refund_amount');

        $pendingRefunds = $payments
            ->where('refund_status', 'pending')
            ->count();

        return view(
            'student.payments',
            compact(
                'payments',
                'totalPaid',
                'totalRefund',
                'pendingRefunds'
            )
        );
    }
}