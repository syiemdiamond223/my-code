<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;

class ReceiptController extends Controller
{
    public function preview($id)
    {
        $booking = Booking::with([
            'student',
            'tutor.user',
            'subject'
        ])->findOrFail($id);

        $pdf = Pdf::loadView(
            'receipts.pdf',
            compact('booking')
        );

        return $pdf->stream(
            'receipt-'.$booking->id.'.pdf'
        );
    }

    public function download($id)
    {
        $booking = Booking::with([
            'student',
            'tutor.user',
            'subject'
        ])->findOrFail($id);

        $pdf = Pdf::loadView(
            'receipts.pdf',
            compact('booking')
        );

        return $pdf->download(
            'receipt-'.$booking->id.'.pdf'
        );
    }
}