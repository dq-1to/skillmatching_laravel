<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check() || (int)Auth::user()->role !== 1) {
            abort(403); 
        }
        return $next($request);
    }
}
