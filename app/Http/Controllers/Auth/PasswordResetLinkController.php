<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class PasswordResetLinkController extends Controller
{
    /**
     * @group Authentication
     *
     * Display Password Reset Link Request View
     *
     * Show the view where users can request a password reset link.
     *
     * @return \Inertia\Response A response rendering the password reset request view.
     * @response 200 {
     *   "status": "some-status"
     *   // Rendered view for requesting a password reset link.
     * }
     */
    public function create(): Response
    {
        return Inertia::render('Auth/ForgotPassword', [
            'status' => session('status'),
        ]);
    }

    /**
     * @group Authentication
     *
     * Handle Password Reset Link Request
     *
     * Validate the email address and handle the request to send a password reset link.
     *
     * @param \Illuminate\Http\Request $request The request object containing the email.
     * @param string $request->email The email address to which the reset link will be sent.
     * 
     * @return \Illuminate\Http\RedirectResponse Redirects back to the previous page with a status message if the reset link is sent successfully.
     * @response 302 Redirect response back to the previous page with a status message.
     * 
     * @throws \Illuminate\Validation\ValidationException If the email validation fails.
     * @response 422 {
     *   "errors": {
     *     "email": [
     *       "The email address is not valid or does not exist."
     *     ]
     *   }
     * }
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }
}
