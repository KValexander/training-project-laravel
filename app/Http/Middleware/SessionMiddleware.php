<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

// Connecting modules
use Auth;

class SessionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Authorization check
        if(Auth::check()) {
            $user = Auth::user();
            $user_id = $user->id;
            $role = $user->role;
        } else {
            $user_id = -1;
            $role = "guest";
        }

        // Passing variables to views
        view()->share(["role" => $role, "user_id" => $user_id]);

        return $next($request);
    }
}
