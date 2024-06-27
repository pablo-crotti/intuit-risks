<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RegistrationSteps
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $userRegistrationStep = Auth::user()->registration_step;
            if ($userRegistrationStep == 1) {
                return redirect()->route('register.company');
            } else if ($userRegistrationStep == 2) {
                return redirect()->route('register.risks.index');
            }
        }

        return $next($request);
    }
}
