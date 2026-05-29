<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class TutorReportController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | REPORT LIST
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $bookings = Booking::where(
            'tutor_id',
            Auth::user()->tutor->id
        )->latest()->get();

        return view(
            'tutor.reports.index',
            compact('bookings')
        );
    }



    /*
    |--------------------------------------------------------------------------
    | PREVIEW PDF
    |--------------------------------------------------------------------------
    */

    public function preview($id)
    {
        $booking = Booking::where(
            'id',
            $id
        )->where(
            'tutor_id',
            Auth::user()->tutor->id
        )->firstOrFail();

        $pdf = Pdf::loadView(
            'tutor.reports.pdf',
            compact('booking')
        );

        return $pdf->stream(
            'booking-report-' . $booking->id . '.pdf'
        );
    }



    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD PDF
    |--------------------------------------------------------------------------
    */

    public function download($id)
    {
        $booking = Booking::where(
            'id',
            $id
        )->where(
            'tutor_id',
            Auth::user()->tutor->id
        )->firstOrFail();

        $pdf = Pdf::loadView(
            'tutor.reports.pdf',
            compact('booking')
        );

        return $pdf->download(
            'booking-report-' . $booking->id . '.pdf'
        );
    }
}