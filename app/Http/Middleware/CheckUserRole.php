<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    
    public function handle($request, Closure $next)
    {
        // Check if the user is an admin
        if (Auth::check() && Auth::user()->isAdmin()) {
            return $next($request);
        }
        // Redirect to home or show an unauthorized message
        return back();
    }
}
