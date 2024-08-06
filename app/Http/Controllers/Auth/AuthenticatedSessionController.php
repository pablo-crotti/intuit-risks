<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * @group Authentication
     *
     * Show Login Form
     *
     * Display the login form to the user.
     *
     * @return \Inertia\Response A response rendering the login form view.
     * @response 200 {
     *   "canResetPassword": true,
     *   "status": null
     * }
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * @group Authentication
     *
     * Handle Authentication Request
     *
     * Authenticate the user and redirect to the intended location or dashboard.
     *
     * @param \App\Http\Requests\LoginRequest $request The request object for authentication.
     * 
     * @return \Illuminate\Http\RedirectResponse Redirects to the intended location or dashboard.
     * @response 302 Redirect response to the intended route.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * @group Authentication
     *
     * Logout and Destroy Session
     *
     * Logout the authenticated user and destroy the session.
     *
     * @param \Illuminate\Http\Request $request The request object.
     * 
     * @return \Illuminate\Http\RedirectResponse Redirects to the home page.
     * @response 302 Redirect response to the home page.
     * @authenticated
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
