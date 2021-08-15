<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

// Connecting modules
use Auth;

class ModerationMiddleware
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
        // Get role
        $role = Auth::user()->role;
        // Access check
        if($role == "admin" || $role == "moderator") return $next($request);
        else return redirect()->route("personal_area")->withErrors("Ошибка доступа", "message");
    }
}
