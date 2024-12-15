<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated and if the email is verified
        if (Auth::check() && is_null(Auth::user()->email_verified_at)) {
            // Return a JSON response indicating that the user needs to verify their email
            return response()->json(['error' => 'Please verify your email.'], 403);
        }
        return $next($request);
    }
}