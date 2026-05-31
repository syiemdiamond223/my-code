<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    // Verify user email and redirect based on role
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        // If already verified
        if ($request->user()->hasVerifiedEmail()) {

            $user = $request->user();

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            if ($user->role === 'tutor') {
                return redirect()->route('tutor.dashboard');
            }

            return redirect()->route('student.dashboard');
        }

        // Mark email as verified in DB
        if ($request->user()->markEmailAsVerified()) {

            event(new Verified($request->user()));
        }

        $user = $request->user();

        // Redirect based on role
        if ($user->role === 'admin') {

            return redirect()->route('admin.dashboard')
                ->with('success', 'Email verified successfully.');
        }

        if ($user->role === 'tutor') {

            return redirect()->route('tutor.dashboard')
                ->with('success', 'Email verified successfully.');
        }

        return redirect()->route('student.dashboard')
            ->with('success', 'Email verified successfully.');
    }
}