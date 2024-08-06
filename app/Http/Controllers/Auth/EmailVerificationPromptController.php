<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EmailVerificationPromptController extends Controller
{
    /**
     * @group Authentication
     *
     * Display Email Verification Prompt
     *
     * Display the email verification prompt if the user's email is not verified,
     * otherwise redirect to the dashboard.
     *
     * @param \Illuminate\Http\Request $request The request object.
     * 
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response Redirects to the dashboard if the email is verified,
     *         otherwise renders the email verification prompt view.
     * @response 302 Redirect response to the dashboard if the email is verified.
     * @response 200 {
     *   "status": "verification-link-sent"
     *   // Rendered view for email verification prompt.
     * }
     * @authenticated
     */
    public function __invoke(Request $request): RedirectResponse|Response
    {
        return $request->user()->hasVerifiedEmail()
            ? redirect()->intended(route('dashboard', absolute: false))
            : Inertia::render('Auth/VerifyEmail', ['status' => session('status')]);
    }
}
