<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Availability;
use App\Models\Tutor;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class AvailabilityController extends Controller
{
    // Show Tutor Availability Page
    public function index()
    {
        // Get logged-in tutor
        $tutor = Tutor::where('user_id', Auth::id())->first();

        // Get all availability records
        $availabilities = Availability::where('tutor_id', $tutor->id)
            ->latest()
            ->get();

        // Return view
        return view('tutor.availability', compact('availabilities'));
    }


    // Store New Availability
    public function store(Request $request)
    {
        // Validate form
        $request->validate([
            'available_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        // Get tutor
        $tutor = Tutor::where('user_id', Auth::id())->first();

        // Create availability
        Availability::create([
            'tutor_id' => $tutor->id,
            'available_date' => $request->available_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => 'available',
        ]);

        return back()->with(
            'success',
            'Availability added successfully.'
        );
    }


    // Toggle Availability Status
    public function toggle($id)
    {
        $availability = Availability::findOrFail($id);

        // CHECK IF SLOT HAS BOOKINGS
        $hasBooking = Booking::where('availability_id', $availability->id)
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($hasBooking) {

            return back()->with(
                'error',
                'This slot already has bookings and cannot be changed.'
            );
        }

        if ($availability->status == 'available') {

            $availability->status = 'unavailable';

        } else {

            $availability->status = 'available';

        }

        $availability->save();

        return back()->with(
            'success',
            'Availability updated successfully.'
        );
    }


    // Delete Availability
    public function destroy($id)
    {
        $availability = Availability::findOrFail($id);

        // CHECK IF SLOT HAS BOOKINGS
        $hasBooking = Booking::where('availability_id', $availability->id)
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($hasBooking) {

            return back()->with(
                'error',
                'Cannot delete a slot that already has bookings.'
            );
        }

        $availability->delete();

        return back()->with(
            'success',
            'Availability slot deleted successfully.'
        );
    }
}