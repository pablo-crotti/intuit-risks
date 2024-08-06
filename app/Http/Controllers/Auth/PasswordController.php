<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * @group Authentication
     *
     * Update User's Password
     *
     * Validate and update the user's password.
     *
     * @param \Illuminate\Http\Request $request The request object containing the current and new passwords.
     * @param string $request->current_password The current password of the user.
     * @param string $request->password The new password to be set.
     * @param string $request->password_confirmation The confirmation of the new password.
     * 
     * @return \Illuminate\Http\RedirectResponse Redirects back to the previous page upon successful password update.
     * @response 302 Redirect response back to the previous page.
     * 
     * @throws \Illuminate\Validation\ValidationException If the validation fails.
     * @response 422 {
     *   "errors": {
     *     "current_password": [
     *       "The current password is incorrect."
     *     ],
     *     "password": [
     *       "The password confirmation does not match."
     *     ]
     *   }
     * }
     * @authenticated
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back();
    }
}
