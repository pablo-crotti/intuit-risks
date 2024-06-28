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
    public function create(): Response
    {
        $token = request()->route('token');

        $user = User::with('company')->where('token', $token)->first();
        
        return Inertia::render('Auth/UserRegister', [
            'user' => $user
        ]);
    }

    public function store(Request $request) 
    {
        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => 'required|accepted',
            'token' => 'required|string'
        ]);

    
        $user = User::where('token', $request->token)->first();
        $user->password = Hash::make($request->password);
        $user->token = null;
        $user->is_active = true;

        $user->save();

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
