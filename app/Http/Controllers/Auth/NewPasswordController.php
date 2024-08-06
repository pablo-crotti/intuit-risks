<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class NewPasswordController extends Controller
{
    /**
     * @group Authentication
     *
     * Display Password Reset View
     *
     * Show the password reset view to the user, prefilled with email and token.
     *
     * @param \Illuminate\Http\Request $request The request object containing the email and token.
     * @param string $request->email The email address of the user requesting a password reset.
     * @param string $request->route('token') The token for password reset from the route.
     * 
     * @return \Inertia\Response A response rendering the password reset view.
     * @response 200 {
     *   "email": "user@example.com",
     *   "token": "reset-token-value"
     * }
     */
    public function create(Request $request): Response
    {
        return Inertia::render('Auth/ResetPassword', [
            'email' => $request->email,
            'token' => $request->route('token'),
        ]);
    }

    /**
     * @group Authentication
     *
     * Handle New Password Request
     *
     * Validate and handle the request to reset the user's password.
     *
     * @param \Illuminate\Http\Request $request The request object containing reset details.
     * @param string $request->token The password reset token.
     * @param string $request->email The email address of the user.
     * @param string $request->password The new password.
     * @param string $request->password_confirmation The confirmation of the new password.
     * 
     * @return \Illuminate\Http\RedirectResponse Redirects to the login page upon successful password reset.
     * @response 302 Redirect response to the login route with a status message.
     * 
     * @throws \Illuminate\Validation\ValidationException If validation fails.
     * @response 422 {
     *   "errors": {
     *     "email": [
     *       "The provided email is incorrect or expired."
     *     ],
     *     "password": [
     *       "The password confirmation does not match."
     *     ]
     *   }
     * }
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        if ($status == Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', __($status));
        }

        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }
}
