<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Tutor;
use App\Models\Booking;
use App\Models\Availability;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TutorProfileController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TutorDashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TutorReportController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\StudentReportController;

// ROOT ROUTE

Route::get('/test-route', function () {
    return 'working';
});

Route::get('/', function () {

    if (Auth::check()) {

        return match (Auth::user()->role) {

            'admin' => redirect()->route('admin.dashboard'),
            'tutor' => redirect()->route('tutor.dashboard'),
            default => redirect()->route('student.dashboard'),
        };
    }

    return view('welcome');
});


// AUTH MIDDLEWARE GROUP

Route::middleware(['auth', 'blocked'])->group(function () {

    // ADMIN ROUTES

    Route::prefix('admin')->middleware('admin')->group(function () {

        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('admin.dashboard');

        Route::get('/users', [AdminController::class, 'users'])
            ->name('admin.users');

        Route::patch('/users/{user}/toggle-status',
            [AdminController::class, 'toggleUserStatus'])
            ->name('admin.users.toggle');

        Route::get('/tutors', [AdminController::class, 'tutors'])
            ->name('admin.tutors');

        Route::get('/tutors/{id}/show', [AdminController::class, 'showTutor'])
            ->name('admin.tutors.show');

        Route::patch('/tutors/{id}/approve',
            [AdminController::class, 'approveTutor'])
            ->name('admin.tutors.approve');

        Route::patch('/tutors/{id}/reject',
            [AdminController::class, 'rejectTutor'])
            ->name('admin.tutors.reject');

        Route::get('/bookings', [AdminController::class, 'bookings'])
            ->name('admin.bookings');

        Route::get('/reports', [ReportController::class, 'index'])
            ->name('admin.reports');

        Route::get('/reports/{id}/preview',
            [ReportController::class, 'preview'])
            ->name('admin.reports.preview');

        Route::get('/reports/{id}/download',
            [ReportController::class, 'download'])
            ->name('admin.reports.download');
    });


    // STUDENT DASHBOARD

    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])
        ->name('student.dashboard');


    // SEARCH TUTORS

    Route::get('/student/search', function (Request $request) {

        $query = $request->input('search');

      $tutors = Tutor::with([
    'user',
    'subjects',
    'availabilities' => function ($q) {

        $q->where('status', 'available')
          ->whereNotIn('id', function ($sub) {

                $sub->select('availability_id')
                    ->from('bookings');

          });

    }
])
            ->where('status', 'approved')
            ->whereHas('user', function ($q) {
                $q->where('status', 'active');
            })
            ->when($query, function ($q) use ($query) {

                $q->whereHas('subjects', function ($sub) use ($query) {
                    $sub->where('name', 'LIKE', "%{$query}%");
                });

            })
            ->latest()
            ->get();

        return view('student.search', compact('tutors', 'query'));

    })->name('student.search');


    // TUTOR PROFILE VIEW

    Route::get('/student/tutor/{id}', function ($id) {

        $tutor = Tutor::with([
            'user',
            'subjects',
            'availabilities'
        ])
            ->where('status', 'approved')
            ->whereHas('user', function ($q) {
                $q->where('status', 'active');
            })
            ->findOrFail($id);

        return view('student.tutor-profile', compact('tutor'));

    })->name('student.tutor.show');


    // BOOK SESSION FORM

 Route::get('/student/book/{id}', function ($id) {

    $tutor = Tutor::with([
        'user',
        'subjects',
        'availabilities' => function ($q) {

            $q->where('status', 'available');

        }
    ])->findOrFail($id);

    return view('student.book-session', compact('tutor'));

})->name('student.booking.create');


    // STORE BOOKING (FIXED)

    Route::post('/student/book/{id}', function (Request $request, $id) {

        $request->validate([
            'subject_id' => 'required',
            'hours' => 'required|numeric|min:1',
            'session_mode' => 'required',
            'student_phone' => 'nullable|required_if:session_mode,offline|digits:10',
            'student_address' => 'nullable|required_if:session_mode,offline|max:500',
            'availability_id' => 'required|exists:availabilities,id',
        ]);

        $tutor = Tutor::findOrFail($id);

        // CHECK SLOT EXISTS
        $availability = Availability::where('id', $request->availability_id)
            ->where('tutor_id', $tutor->id)
            ->where('status', 'available')
            ->first();

        if (!$availability) {

            return back()->withErrors([
                'availability_id' => 'Invalid slot selected.'
            ]);
        }

 // PREVENT DOUBLE BOOKING
$alreadyBooked = Booking::where('availability_id', $request->availability_id)
    ->exists();

if ($alreadyBooked) {

    return redirect()
        ->route('student.booking.create', $tutor->id)
        ->with('error', 'This slot is already booked.');
}

        // TOTAL PRICE
        $totalPrice = $tutor->price_per_hour * $request->hours;

        // CREATE BOOKING
        Booking::create([
            'student_id' => Auth::id(),
            'tutor_id' => $tutor->id,
            'subject_id' => $request->subject_id,
            'availability_id' => $availability->id,

            // AUTO GET FROM AVAILABILITY
            'session_date' => $availability->available_date,
            'session_time' => $availability->start_time,

            'hours' => $request->hours,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'session_mode' => $request->session_mode,
            'payment_status' => 'pending',
            'student_phone' => $request->student_phone,
            'student_address' => $request->student_address,
        ]);

        return redirect()->route('student.bookings')
            ->with('success', 'Booking created successfully.');

    })->name('student.booking.store');


    // STUDENT BOOKINGS

    Route::get('/student/bookings', function () {

        $bookings = Booking::with('tutor.user', 'subject')
            ->where('student_id', Auth::id())
            ->latest()
            ->get();

        return view('student.bookings', compact('bookings'));

    })->name('student.bookings');


    // CANCEL BOOKING

    Route::delete('/student/bookings/{booking}/cancel', function (Booking $booking) {

        if ($booking->student_id != Auth::id()) {
            abort(403);
        }

        if ($booking->status === 'approved') {

            return back()->with(
                'error',
                'Approved bookings cannot be cancelled.'
            );
        }

        $booking->update([
            'status' => 'cancelled'
        ]);

        return redirect()->route('student.bookings')
            ->with('success', 'Booking cancelled successfully.');

    })->name('student.bookings.cancel');


    // STUDENT REPORTS

    Route::get('/student/reports', [StudentReportController::class, 'index'])
        ->name('student.reports');

    Route::get('/student/reports/{id}/preview', [StudentReportController::class, 'preview'])
        ->name('student.reports.preview');

    Route::get('/student/reports/{id}/download', [StudentReportController::class, 'download'])
        ->name('student.reports.download');


    // TUTOR DASHBOARD

    Route::get('/tutor/dashboard', [TutorDashboardController::class, 'index'])
        ->name('tutor.dashboard');


    // TUTOR AVAILABILITY

    Route::get('/tutor/availability', [AvailabilityController::class, 'index'])
        ->name('tutor.availability');

    Route::post('/tutor/availability/store', [AvailabilityController::class, 'store'])
        ->name('tutor.availability.store');

    Route::patch('/tutor/availability/toggle/{id}', [AvailabilityController::class, 'toggle'])
        ->name('tutor.availability.toggle');

    Route::delete('/tutor/availability/delete/{id}', [AvailabilityController::class, 'destroy'])
        ->name('tutor.availability.delete');


    // TUTOR PROFILE

    Route::get('/tutor/profile', [TutorProfileController::class, 'form'])
        ->name('tutor.profile.form');

    Route::post('/tutor/profile/store', [TutorProfileController::class, 'store'])
        ->name('tutor.profile.store');

    Route::put('/tutor/profile/update', [TutorProfileController::class, 'update'])
        ->name('tutor.profile.update');


    // TUTOR BOOKING APPROVE / REJECT

    Route::patch('/tutor/booking/{id}/approve', [BookingController::class, 'approve'])
        ->name('tutor.booking.approve');

    Route::patch('/tutor/booking/{id}/reject', [BookingController::class, 'reject'])
        ->name('tutor.booking.reject');


    // TUTOR SESSIONS

    Route::get('/tutor/sessions', function () {

        $tutor = Tutor::where('user_id', Auth::id())->first();

        $sessions = Booking::with('student', 'subject')
            ->where('tutor_id', $tutor->id)
            ->latest()
            ->get();

        return view('tutor.sessions', compact('sessions'));

    })->name('tutor.sessions');


    // TUTOR REPORTS

    Route::get('/tutor/reports', [TutorReportController::class, 'index'])
        ->name('tutor.reports');

    Route::get('/tutor/reports/{id}/preview', [TutorReportController::class, 'preview'])
        ->name('tutor.reports.preview');

    Route::get('/tutor/reports/{id}/download', [TutorReportController::class, 'download'])
        ->name('tutor.reports.download');


    // UPDATE MEETING LINK

    Route::patch('/tutor/booking/{id}/meeting', function (Request $request, $id) {

        $request->validate([
            'meeting_link' => 'required|url'
        ]);

        $booking = Booking::findOrFail($id);

        $booking->update([
            'meeting_link' => $request->meeting_link
        ]);

        return back()->with(
            'success',
            'Meeting link added successfully.'
        );

    })->name('tutor.booking.meeting');
});


// PROFILE ROUTES

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';