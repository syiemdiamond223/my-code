<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | REPORT LIST
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $bookings = Booking::latest()->get();

        return view('admin.reports.index', compact('bookings'));
    }



    /*
    |--------------------------------------------------------------------------
    | PREVIEW PDF
    |--------------------------------------------------------------------------
    */

    public function preview($id)
    {
        $booking = Booking::findOrFail($id);

        $pdf = Pdf::loadView(
            'admin.reports.pdf',
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
        $booking = Booking::findOrFail($id);

        $pdf = Pdf::loadView(
            'admin.reports.pdf',
            compact('booking')
        );

        return $pdf->download(
            'booking-report-' . $booking->id . '.pdf'
        );
    }

}