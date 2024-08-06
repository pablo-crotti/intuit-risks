<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class ConfirmablePasswordController extends Controller
{
    /**
     * @group Authentication
     *
     * Show Confirm Password View
     *
     * Display the view for confirming the user's password.
     *
     * @return \Inertia\Response A response rendering the confirm password view.
     * @response 200 {
     *   // Rendered view for password confirmation.
     * }
     * @authenticated
     */
    public function show(): Response
    {
        return Inertia::render('Auth/ConfirmPassword');
    }

    /**
     * @group Authentication
     *
     * Confirm User's Password
     *
     * Validate the user's password to confirm their identity.
     *
     * @param \Illuminate\Http\Request $request The request object containing the password.
     * @param string $request->password The password to be validated.
     * 
     * @return \Illuminate\Http\RedirectResponse Redirects to the intended location or dashboard upon successful confirmation.
     * @response 302 Redirect response to the intended route.
     * 
     * @throws \Illuminate\Validation\ValidationException If password validation fails.
     * @response 422 {
     *   "errors": {
     *     "password": [
     *       "The provided password is incorrect."
     *     ]
     *   }
     * }
     * @authenticated
     */
    public function store(Request $request): RedirectResponse
    {
        if (!Auth::guard('web')->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        $request->session()->put('auth.password_confirmed_at', time());

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
