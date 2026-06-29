<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TutorProfileController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TutorDashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TutorReportController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\StudentReportController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentBookingController;
use App\Http\Controllers\StudentPaymentController;
use App\Http\Controllers\TutorBookingController;
use App\Http\Controllers\RazorpayController;
use App\Http\Controllers\ReceiptController;

// ROOT ROUTE

Route::get('/test-route', function () {
    return 'working';
});

//Sends user based on role to respective dashboard
Route::get('/', [HomeController::class, 'index']);

// AUTH MIDDLEWARE GROUP - ONLY ACCESSIBLE TO LOGGED IN USERS
Route::middleware(['auth', 'blocked'])->group(function () {


    // ADMIN ROUTES - ONLY ACCESSIBLE TO ADMINS
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

        Route::get( '/admin/payments', [AdminController::class, 'payments'])
            ->name('admin.payments');

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

        // STUDENT FEATURES
    Route::get('/student/search', [StudentController::class, 'search'])
        ->name('student.search');

    Route::get('/student/tutor/{id}', [StudentController::class, 'showTutor'])
        ->name('student.tutor.show');

        // STUDENT BOOKINGS
    Route::get('/student/book/{id}',
        [StudentBookingController::class, 'create'])
        ->name('student.booking.create');

    Route::post('/student/book/{id}',
        [StudentBookingController::class, 'store'])
        ->name('student.booking.store');

    Route::get('/student/bookings',
        [StudentBookingController::class, 'index'])
        ->name('student.bookings');

    Route::delete('/student/bookings/{booking}/cancel',
        [StudentBookingController::class, 'cancel'])
        ->name('student.bookings.cancel');

    // STUDENT PAYMENTS
     Route::get('/student/payments',
        [StudentPaymentController::class, 'index'])
        ->name('student.payments');

    Route::get('/student/payment',
        [RazorpayController::class, 'pay'])
        ->name('student.payment.pay');

    Route::get('/student/payment/success',
        [RazorpayController::class, 'success'])
       ->name('student.payment.success');

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

    Route::patch('/tutor/booking/{id}/approve',
         [TutorBookingController::class, 'approve'])
        ->name('tutor.booking.approve');

    Route::patch('/tutor/booking/{id}/reject', 
        [TutorBookingController::class, 'reject'])
        ->name('tutor.booking.reject');


    // TUTOR SESSIONS - SHOW ALL SESSIONS FOR TUTOR
    Route::get('/tutor/sessions',
        [TutorBookingController::class, 'tutorSessions'])
        ->name('tutor.sessions');    

    // TUTOR CANCEL SESSION
    Route::patch('/tutor/booking/{id}/cancel',
        [TutorBookingController::class, 'cancelSession'])
        ->name('tutor.booking.cancel');

    // TUTOR PAYMENTS
     Route::get('/tutor/payments',
         [TutorBookingController::class, 'payments'])
        ->name('tutor.payments');

    // TUTOR REPORTS

    Route::get('/tutor/reports', 
        [TutorReportController::class, 'index'])
        ->name('tutor.reports');

    Route::get('/tutor/reports/{id}/preview', 
        [TutorReportController::class, 'preview'])
        ->name('tutor.reports.preview');

    Route::get('/tutor/reports/{id}/download', 
        [TutorReportController::class, 'download'])
        ->name('tutor.reports.download');

    // RECEIPTS

    Route::get('/receipt/{id}/preview',
        [ReceiptController::class, 'preview'])
        ->name('receipt.preview');

    Route::get('/receipt/{id}/download',
        [ReceiptController::class, 'download'])
        ->name('receipt.download');


    // ADD MEETING LINK
    Route::patch( '/tutor/booking/{id}/meeting',
            [TutorBookingController::class, 'addMeetingLink']
        )->name('tutor.booking.meeting');
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

    // AUTH ROUTES LOADED FROM auth.php
    require __DIR__.'/auth.php';