<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class UserRegister extends Controller
{
    /**
     * @group Authentication
     *
     * Display User Registration View
     *
     * Show the registration view for users who have received a registration token.
     *
     * @return \Inertia\Response A response rendering the user registration view.
     * @response 200 {
     *   "user": {
     *     "id": 1,
     *     "name": "John Doe",
     *     "email": "johndoe@example.com",
     *     "company": {
     *       "id": 1,
     *       "name": "Example Company"
     *     }
     *   }
     *   // Rendered view for user registration.
     * }
     */
    public function create(): Response
    {
        $token = request()->route('token');

        $user = User::with('company')->where('token', $token)->first();

        return Inertia::render('Auth/UserRegister', [
            'user' => $user
        ]);
    }

    /**
     * @group Authentication
     *
     * Handle User Registration Request
     *
     * Validate the registration details and complete the registration process for the user.
     *
     * @param \Illuminate\Http\Request $request The request object containing user registration details.
     * @param string $request->password The new password for the user account.
     * @param string $request->password_confirmation The confirmation of the new password.
     * @param bool $request->terms Indicates whether the user accepted the terms and conditions.
     * @param string $request->token The registration token.
     * @param \Illuminate\Http\UploadedFile|null $request->avatar The user's avatar image, if provided.
     * 
     * @return \Illuminate\Http\RedirectResponse Redirects to the dashboard after successful registration.
     * @response 302 Redirect response to the dashboard.
     * 
     * @throws \Illuminate\Validation\ValidationException If validation of registration details fails.
     * @response 422 {
     *   "errors": {
     *     "password": [
     *       "The password confirmation does not match."
     *     ],
     *     "terms": [
     *       "You must accept the terms and conditions."
     *     ],
     *     "token": [
     *       "The registration token is required."
     *     ],
     *     "avatar": [
     *       "The avatar must be an image of type jpeg, png, jpg, gif, or svg and must not exceed 2048 kilobytes."
     *     ]
     *   }
     * }
     */
    public function store(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => 'required|accepted',
            'token' => 'required|string'
        ]);

        if ($request->has('avatar') && !empty($request->avatar)) {
            $request->validate([
                'avatar' => 'image|max:2048|mimes:jpeg,png,jpg,gif,svg',
            ]);

            $fileType = $request->avatar->getClientOriginalExtension();
            $random = bin2hex(random_bytes(8)) . bin2hex(random_bytes(8)) . '.' . $fileType;


            $image_path = $request->avatar->storeAs('public/images', $random);
        } else {
            $image_path = null;
        }


        $user = User::where('token', $request->token)->first();
        $user->password = Hash::make($request->password);
        $user->token = null;
        $user->is_active = true;
        $user->image = $image_path;

        $user->save();

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
