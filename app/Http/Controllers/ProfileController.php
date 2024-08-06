<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * @group Users
     * Display the user's profile form.
     *
     * Renders the profile edit page with information about whether the user's email must be verified
     * and any status messages from the session.
     *
     * @param \Illuminate\Http\Request $request The incoming request object.
     * 
     * @return \Illuminate\Http\Response A response object rendering the profile edit page.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * @group Users
     * 
     * Update the user's profile information.
     *
     * Validates and updates the user's profile information based on the provided request.
     * If the email has changed, it sets the `email_verified_at` attribute to null.
     * Saves the updated user information and redirects to the profile edit page.
     *
     * @param \App\Http\Requests\ProfileUpdateRequest $request The request object containing validated profile data.
     * 
     * @return \Illuminate\Http\RedirectResponse A redirect response to the profile edit page.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * @group Users
     * 
     * Delete the user's account.
     *
     * Validates that the provided password is correct, then logs out the user,
     * deletes the user's account, and invalidates and regenerates the session.
     * Redirects to the homepage after the account is deleted.
     *
     * @param \Illuminate\Http\Request $request The incoming request object containing the user's password.
     * 
     * @return \Illuminate\Http\RedirectResponse A redirect response to the homepage.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
