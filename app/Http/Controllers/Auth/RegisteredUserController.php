<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    //Display the registration page
    public function create(): View
    {
        return view('auth.register');
    }

    //Handle an incoming registration request
    public function store(Request $request): RedirectResponse
    {
        $request->validate([

            // NAME
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[A-Za-z\s]+$/'
            ],

            // EMAIL
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'regex:/^[a-z][a-z0-9._%+-]*@[a-z0-9.-]+\.[a-z]{2,}$/',
                'unique:' . User::class,
            ],

            // PASSWORD strength validation
            'password' => [
                'required',
                'confirmed',

                // Minimum 8 characters
                'min:8',

                // At least 1 lowercase
                'regex:/[a-z]/',

                // At least 1 uppercase
                'regex:/[A-Z]/',

                // At least 1 number
                'regex:/[0-9]/',

                // At least 1 special character
                'regex:/[@$!%*#?&]/',
            ],

            // ROLE
            'role' => [
                'required',
                'in:student,tutor'
            ],
        ], [

            //  ERROR MESSAGES
            'name.regex' => 'Name must contain letters only.',

            'email.regex' => 'Email must start with a lowercase letter and contain @.',

            'password.min' => 'Password must be at least 8 characters.',

            'password.regex' => 'Password must contain uppercase, lowercase, number, and special character.',
        ]);

        // Create the user in the database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

       // Log the user in
        Auth::login($user);

        // ROLE-BASED REDIRECT
        if ($user->role === 'student') {
            return redirect()->route('student.dashboard');
        }

        if ($user->role === 'tutor') {
            return redirect()->route('tutor.dashboard');
        }

        return redirect()->route('student.dashboard');
    }
}