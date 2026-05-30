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

    // Tutor has not completed profile yet
    if (!$tutor) {
        return redirect()
            ->route('tutor.profile.form')
            ->with('error', 'Please complete your tutor profile first.');
    }

    // Tutor profile exists but not approved by admin
    if ($tutor->status !== 'approved') {
        return redirect()
            ->route('tutor.dashboard')
            ->with('error', 'Your profile is pending admin approval. You cannot set availability yet.');
    }

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

    // Get logged-in tutor
    $tutor = Tutor::where('user_id', Auth::id())->first();

    // Tutor has not completed profile yet
    if (!$tutor) {
        return redirect()
            ->route('tutor.profile.form')
            ->with('error', 'Please complete your tutor profile first.');
    }

    // Tutor profile exists but not approved by admin
    if ($tutor->status !== 'approved') {
        return redirect()
            ->route('tutor.dashboard')
            ->with('error', 'Your profile is pending admin approval. You cannot set availability yet.');
    }

    // Create availability slot
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
    public function toggle(int $id)
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
    public function destroy(int $id)
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