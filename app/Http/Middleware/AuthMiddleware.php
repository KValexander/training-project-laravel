<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

// Connecting modules
use Auth;

class AuthMiddleware
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
        if(Auth::check()) return $next($request);
        else
            return redirect()->route("main_page")->withErrors("Вы не авторизованы", "message");
    }
}
