<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Str;

use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    //validate the login request
    //Determine if the user is authorized to make this request
    public function authorize(): bool
    {
        return true;
    }

    //validate the login request
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    //Handle the authentication attempt
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // LOGIN ATTEMPT
        if (! Auth::attempt(
            $this->only('email', 'password'),
            $this->boolean('remember')
        )) {

        //If login fails, increment the login attempts and throw validation exception
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => 'Invalid email or password.',
            ]);
        }

        // CHECK IF USER IS BLOCKED
        if (Auth::user()->status === 'blocked') {

            Auth::logout();

            throw ValidationException::withMessages([
                'email' => 'Your account has been blocked. Please contact admin.',
            ]);
        }

        // CLEAR LOGIN RATE LIMIT
        RateLimiter::clear($this->throttleKey());

        // REGENERATE SESSION
        Session::regenerate();
    }

    //Check if the login request is not rate limited
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    //Get the rate limiting throttle key for the request
    public function throttleKey(): string
    {
        return Str::transliterate(
            Str::lower($this->string('email')) . '|' . $this->ip()
        );
    }
}