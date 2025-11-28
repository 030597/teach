<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StudentMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->type === 'student') {
            return $next($request);
        }
        return redirect('/')->with('error', 'Access denied for students only.');
    }
}