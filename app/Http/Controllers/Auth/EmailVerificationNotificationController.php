<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * @group Authentication
     *
     * Send Email Verification Notification
     *
     * Send a new email verification notification to the user if their email is not verified.
     *
     * @param \Illuminate\Http\Request $request The request object.
     * 
     * @return \Illuminate\Http\RedirectResponse Redirects back to the previous page with a status message.
     * @response 302 Redirect response back to the previous page with a status message.
     * @response 200 {
     *   "status": "verification-link-sent"
     * }
     * 
     * @throws \Illuminate\Auth\Access\AuthorizationException If the user is unauthorized.
     * @response 403 {
     *   "message": "You are not authorized to access this resource."
     * }
     * @authenticated
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false));
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
