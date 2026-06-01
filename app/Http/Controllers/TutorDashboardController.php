<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use Carbon\Carbon;

class TutorDashboardController extends Controller
{
    public function index()
    {
        //Logic to check if tutor profile is complete
        $tutor = Auth::user()->tutor;

        // Flag to indicate if profile is incomplete
        $profileIncomplete = !$tutor;

        if (!$tutor) {
           
            return view('tutor.dashboard', [
                'totalStudents' => 0,
                'upcomingSessionList' => collect(),
                'pendingBookings' => collect(),
                'recentSessions' => collect(),
                'todaySessions' => collect(),
                'profileIncomplete' => true,
            ]);
        }

        $tutorId = $tutor->id;

        //Total Students
        $totalStudents = Booking::where('tutor_id', $tutorId)
            ->distinct('student_id')
            ->count('student_id');

       //Upcoming Sessions
        $upcomingSessionList = Booking::with(['student', 'subject'])
            ->where('tutor_id', $tutorId)
            ->where('status', 'approved')
            ->whereDate('session_date', '>=', Carbon::today())
            ->orderBy('session_date', 'asc')
            ->get();

        //Pending Bookings
        $pendingBookings = Booking::with(['student', 'subject'])
            ->where('tutor_id', $tutorId)
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        //Recent Sessions
        $recentSessions = Booking::with(['student', 'subject'])
            ->where('tutor_id', $tutorId)
            ->latest()
            ->take(5)
            ->get();

        //Today's Sessions
        $todaySessions = Booking::with(['student', 'subject'])
            ->where('tutor_id', $tutorId)
            ->whereDate('session_date', Carbon::today())
            ->where('status', 'approved')
            ->get();

        return view('tutor.dashboard', compact(
            'totalStudents',
            'upcomingSessionList',
            'pendingBookings',
            'recentSessions',
            'todaySessions',
            'profileIncomplete'
        ));
    }
}