<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * @group Authentication
     *
     * Mark Email as Verified
     *
     * Mark the authenticated user's email address as verified.
     * If the email is already verified, redirect to the dashboard with a `verified` query parameter.
     * If the email is not verified, mark it as verified and trigger the Verified event.
     *
     * @param \Illuminate\Foundation\Http\FormRequest $request The request object containing the authenticated user.
     * @param \Illuminate\Auth\Events\Verified $event The event triggered when the email is verified.
     * 
     * @return \Illuminate\Http\RedirectResponse Redirects to the dashboard with a `verified` query parameter.
     * @response 302 Redirect response to the dashboard with a `verified` query parameter.
     * 
     * @response 200 {
     *   "message": "Email verified successfully."
     *   // Redirects to the dashboard with `?verified=1` if the email is verified.
     * }
     * 
     * @response 403 {
     *   "message": "Unauthorized"
     *   // If the request is made by a user who is not authenticated.
     * }
     * @authenticated
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false) . '?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->intended(route('dashboard', absolute: false) . '?verified=1');
    }
}
