<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EmergencyPlanActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $emergencyPlanStatus = Auth::user()->company->risks->where('emergencyPlanStatus', !0)->first();
            if ($emergencyPlanStatus) {
                return redirect('/emergency-plan/' . $emergencyPlanStatus->id);
            }
        }
        return $next($request);
    }
}
