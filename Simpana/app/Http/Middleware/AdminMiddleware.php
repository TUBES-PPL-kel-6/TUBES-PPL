<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Log::info('AdminMiddleware: Checking user role', [
            'user_id' => Auth::id(),
            'role' => Auth::user() ? Auth::user()->role : 'not logged in'
        ]);

        // Check if user is authenticated and has admin role
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        Log::warning('AdminMiddleware: Access denied', [
            'user_id' => Auth::id(),
            'role' => Auth::user() ? Auth::user()->role : 'not logged in'
        ]);

        // If not admin, redirect to user dashboard with error message
        return redirect()->route('user.dashboard')->with('error', 'You do not have admin access.');
    }
}
