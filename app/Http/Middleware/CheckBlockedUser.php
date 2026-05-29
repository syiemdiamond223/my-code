<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckBlockedUser
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->status === 'blocked') {

            Auth::logout();

            return redirect('/login')
                ->with('error', 'Your account has been blocked by admin.');
        }

        return $next($request);
    }
}