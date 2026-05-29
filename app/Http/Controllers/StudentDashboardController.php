<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Tutor;
use App\Models\Booking;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $tutors = Tutor::with([
            'user',
            'subjects',
            'availabilities' => function ($q) {

                $q->where('status', 'available')
                  ->whereNotIn('id', function ($sub) {

                        $sub->select('availability_id')
                            ->from('bookings');

                  })
                  ->orderBy('available_date');

            }
        ])
        ->where('status', 'approved')
        ->whereHas('user', function ($q) {
            $q->where('status', 'active');
        })
        ->latest()
        ->get();

        // STATS
        $bookedSessions = Booking::where('student_id', Auth::id())
            ->where('status', 'approved')
            ->count();

        $learningHours = Booking::where('student_id', Auth::id())
            ->where('status', 'approved')
            ->sum('hours');

        return view('student.dashboard', compact(
            'tutors',
            'bookedSessions',
            'learningHours'
        ));
    }
}