<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Storage;

class RegisteredUserController extends Controller
{
    /**
     * @group Authentication
     *
     * Display Registration View
     *
     * Show the registration view for new users to create an account.
     *
     * @return \Inertia\Response A response rendering the registration view.
     * @response 200 {
     *   // Rendered view for user registration.
     * }
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * @group Authentication
     *
     * Handle Registration Request
     *
     * Validate the registration details and create a new user account.
     *
     * @param \Illuminate\Http\Request $request The request object containing user registration details.
     * @param string $request->name The name of the user.
     * @param string $request->email The email address of the user.
     * @param string $request->password The password for the user account.
     * @param string $request->password_confirmation The confirmation of the password.
     * @param bool $request->terms Indicates whether the user accepted the terms and conditions.
     * @param \Illuminate\Http\UploadedFile|null $request->avatar The user's avatar image, if provided.
     * 
     * @return \Illuminate\Http\RedirectResponse Redirects to the company registration route after successful registration.
     * @response 302 Redirect response to the company registration route.
     * 
     * @throws \Illuminate\Validation\ValidationException If validation of registration details fails.
     * @response 422 {
     *   "errors": {
     *     "name": [
     *       "The name field is required."
     *     ],
     *     "email": [
     *       "The email address is not valid or is already taken."
     *     ],
     *     "password": [
     *       "The password confirmation does not match."
     *     ],
     *     "terms": [
     *       "You must accept the terms and conditions."
     *     ]
     *   }
     * }
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => 'required|accepted',
        ]);

        if ($request->avatar) {
            $request->validate([
                'avatar' => 'image|max:2048|mimes:jpeg,png,jpg,gif,svg',
            ]);

            $fileType = $request->avatar->getClientOriginalExtension();
            $random = bin2hex(random_bytes(8)) . bin2hex(random_bytes(8)) . '.' . $fileType;


            $image_path = $request->avatar->storeAs('public/images', $random);
        } else {
            $image_path = null;
        }


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => true,
            'is_active' => true,
            'image' => $image_path,

        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('register.company', absolute: false));
    }
}
