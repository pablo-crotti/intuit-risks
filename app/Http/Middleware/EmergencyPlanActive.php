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
     * This middleware checks if the user is authenticated and has an active emergency plan. If the user has an active emergency plan, they are redirected to the emergency plan page. If not, the request proceeds as normal.
     *
     * @param \Illuminate\Http\Request $request The incoming request instance.
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next A closure to call the next middleware or request handler.
     * 
     * @return \Symfony\Component\HttpFoundation\Response|mixed The response from the next middleware or a redirect response if the user has an active emergency plan.
     * 
     * @throws \Symfony\Component\HttpFoundation\Response If the user is redirected due to an active emergency plan.
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
