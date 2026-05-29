<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use Carbon\Carbon;

class TutorDashboardController extends Controller
{
    public function index()
    {
        $tutor = Auth::user()->tutor;

        if (!$tutor) {

            return view('tutor.dashboard', [
                'totalStudents' => 0,
                'upcomingSessionList' => collect(),
                'pendingBookings' => collect(),
                'recentSessions' => collect(),
                'todaySessions' => collect(),
            ]);
        }

        $tutorId = $tutor->id;

        /*
        |--------------------------------------------------------------------------
        | TOTAL STUDENTS
        |--------------------------------------------------------------------------
        */

        $totalStudents = Booking::where('tutor_id', $tutorId)
            ->distinct('student_id')
            ->count('student_id');

        /*
        |--------------------------------------------------------------------------
        | UPCOMING SESSIONS
        |--------------------------------------------------------------------------
        |
        | Show approved bookings
        | where date is today or future
        |
        */

        $upcomingSessionList = Booking::with(['student', 'subject'])
            ->where('tutor_id', $tutorId)
            ->where('status', 'approved')
            ->whereDate('session_date', '>=', Carbon::today())
            ->orderBy('session_date', 'asc')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | PENDING BOOKINGS
        |--------------------------------------------------------------------------
        */

        $pendingBookings = Booking::with(['student', 'subject'])
            ->where('tutor_id', $tutorId)
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | RECENT SESSIONS
        |--------------------------------------------------------------------------
        */

        $recentSessions = Booking::with(['student', 'subject'])
            ->where('tutor_id', $tutorId)
            ->latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | TODAY SESSIONS
        |--------------------------------------------------------------------------
        */

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
            'todaySessions'
        ));
    }
}