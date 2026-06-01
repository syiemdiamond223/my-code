<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class TutorReportController extends Controller
{

    //Report List
   public function index()
{
    $tutor = Auth::user()->tutor;

    if (!$tutor) {
        return redirect()
            ->route('tutor.dashboard')
            ->with('error', 'Please complete your tutor profile first.');
    }

    $bookings = Booking::where('tutor_id', $tutor->id)
        ->latest()
        ->get();

    return view('tutor.reports.index', compact('bookings'));
}

    //Preview PDF
   public function preview(int $id)
{
    $tutor = Auth::user()->tutor;

    if (!$tutor) {
        return redirect()
            ->route('tutor.dashboard')
            ->with('error', 'Please complete your tutor profile first.');
    }

    $booking = Booking::where('id', $id)
        ->where('tutor_id', $tutor->id)
        ->firstOrFail();

    $pdf = Pdf::loadView('tutor.reports.pdf', compact('booking'));

    return $pdf->stream('booking-report-' . $booking->id . '.pdf');
}

    //Download PDF
   public function download(int $id)
{
    $tutor = Auth::user()->tutor;

    if (!$tutor) {
        return redirect()
            ->route('tutor.dashboard')
            ->with('error', 'Please complete your tutor profile first.');
    }

    $booking = Booking::where('id', $id)
        ->where('tutor_id', $tutor->id)
        ->firstOrFail();

    $pdf = Pdf::loadView('tutor.reports.pdf', compact('booking'));

    return $pdf->download('booking-report-' . $booking->id . '.pdf');
}
}