<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    //check if user is admin
    public function handle(Request $request, Closure $next): Response
    {
            if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
         }
    
        //if not admin, redirect to home with error message
        return redirect('/')->with('error', 'Access denied');
    }
}
