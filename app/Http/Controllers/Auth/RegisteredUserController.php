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
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => 'required|accepted',
        ]);

        if ($request->has('avatar')) {
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
