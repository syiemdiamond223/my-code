<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Availability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        //ensure the availability slot is still open and valid
        $request->validate([
            'availability_id' => 'required|exists:availabilities,id',
            'tutor_id' => 'required',
            'subject_id' => 'required',
            'hours' => 'required',
            'session_mode' => 'required',

            'student_phone' => 'required_if:session_mode,offline|digits:10',
            'student_address' => 'required_if:session_mode,offline|max:150',
        ]);

        $availability = Availability::findOrFail($request->availability_id);

        //already booked
        if ($availability->status === 'booked') 
        {
            return back()->with('error', 'This slot is already booked');
        }

        //create booking
        Booking::create([
            'student_id' => Auth::id(),
            'tutor_id' => $request->tutor_id,
            'subject_id' => $request->subject_id,
            'availability_id' => $availability->id,
            'session_date' => $availability->available_date,
            'hours' => $request->hours,
            'session_mode' => $request->session_mode,
            'student_phone' => $request->student_phone,
            'student_address' => $request->student_address,
            'status' => 'pending',
        ]);

        $availability->update([
            'status' => 'booked'
        ]);

        return back()->with('success', 'Booking created successfully');
    }

    //Approves booking
    public function approve( int $id)
    {
        $booking = Booking::findOrFail($id);

        $booking->update([
            'status' => 'approved'
        ]);

        return back()->with('success', 'Booking approved successfully');
    }

    //Rejects booking
    public function reject( int $id)
    {
        $booking = Booking::findOrFail($id);

        $booking->update([
            'status' => 'rejected'
        ]);

        return back()->with('success', 'Booking rejected successfully');
    }
}