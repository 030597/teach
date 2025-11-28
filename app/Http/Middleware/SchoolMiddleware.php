<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SchoolMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->type === 'school') {
            return $next($request);
        }
        return redirect('/')->with('error', 'Access denied for schools only.');
    }
}