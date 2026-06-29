<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {

            return match (Auth::user()->role) {

                'admin' => redirect()->route('admin.dashboard'),
                'tutor' => redirect()->route('tutor.dashboard'),
                default => redirect()->route('student.dashboard'),
            };
        }

        return view('welcome');
    }
}