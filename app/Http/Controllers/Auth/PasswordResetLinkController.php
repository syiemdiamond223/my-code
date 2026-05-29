<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /* Display the password reset link request view*/
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /*Handle an incoming password reset link request.
      @throws \Illuminate\Validation\ValidationException*/
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        /* Will send the password reset link to this user. Once have attempted
         to send the link, will examine the response then see the message that
         need to show to the user...then will send out a proper response*/
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
    }
}
