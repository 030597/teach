<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TutorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->type === 'tutor') {
            return $next($request);
        }
        return redirect('/')->with('error', 'Access denied for tutors only.');
    }
}