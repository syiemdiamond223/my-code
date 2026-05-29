<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;

class StudentReportController extends Controller
{

   //Report List
   public function index()
    {
        $bookings = Booking::with([
                'tutor.user',
                'subject'
            ])
            ->where('student_id', Auth::id())
            ->latest()
            ->get();

        return view(
            'student.reports.index',
            compact('bookings')
        );
    }



    //Preview PDF
    public function preview($id)
    {
        $booking = Booking::where('student_id', Auth::id())
            ->findOrFail($id);

        $pdf = Pdf::loadView(
            'student.reports.pdf',
            compact('booking')
        );

        return $pdf->stream(
            'student-booking-report-' . $booking->id . '.pdf'
        );
    }



    //Download PDF
    public function download($id)
    {
        $booking = Booking::where('student_id', Auth::id())
            ->findOrFail($id);

        $pdf = Pdf::loadView(
            'student.reports.pdf',
            compact('booking')
        );

        return $pdf->download(
            'student-booking-report-' . $booking->id . '.pdf'
        );
    }

}