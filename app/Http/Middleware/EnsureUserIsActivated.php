<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class EnsureUserIsActivated
{
    /**
     * Handle an incoming request.
     *
     * This middleware checks if the authenticated user has been marked as deleted. If the user is deleted, they are logged out, and a validation exception is thrown indicating that their account is not activated. Otherwise, the request is passed to the next middleware or handler.
     *
     * @param \Illuminate\Http\Request $request The incoming HTTP request instance.
     * @param \Closure $next A closure that processes the request if the middleware conditions are not met.
     * 
     * @return mixed The response from the next middleware or request handler.
     * 
     * @throws \Illuminate\Validation\ValidationException If the user's account is deleted.
     */

    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->is_deleted) {
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => 'Your account is not activated.',
            ]);
        }

        return $next($request);
    }
}
