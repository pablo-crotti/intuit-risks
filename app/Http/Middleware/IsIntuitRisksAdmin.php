<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsIntuitRisksAdmin
{
    /**
     * Handle an incoming request.
     *
     * This middleware checks if the authenticated user has the `is_intuitrisks_admin` attribute set to `true`. If so, the request is allowed to proceed to the next middleware or request handler. If the user does not have this attribute, they are redirected to the dashboard.
     *
     * @param \Illuminate\Http\Request $request The incoming HTTP request instance.
     * @param \Closure $next A closure that processes the request if the middleware conditions are met.
     * 
     * @return \Symfony\Component\HttpFoundation\Response The response from the next middleware or request handler if the user is an admin, or a redirect response to the dashboard if not.
     */

    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->is_intuitrisks_admin) {
            return $next($request);
        } else {
            return redirect()->route('dashboard');
        }
    }
}
