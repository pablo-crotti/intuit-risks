<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewUserMail;
use App\Models\Company;

class UsersController extends Controller
{
    public function index()
    {
        $company_id = auth()->user()->company_id;
        $company_users = User::where('company_id', $company_id)->get();
        $company_admin = Company::where('id', $company_id)->first()->administrator_id;

        return inertia('Logged/Admin/Users', [
            'users' => $company_users,
            'admin' => $company_admin
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'is_admin' => 'required|boolean',
        ]);


        $company_id = auth()->user()->company_id;

        $random = random_bytes(16);
        $timestamp = now()->timestamp;

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->is_admin = $request->is_admin;
        $user->company_id = $company_id;
        $user->registration_step = 3;
        $user->token = bin2hex($timestamp . $random);
        $user->save();

        $company_name = Company::where('id', $company_id)->first()->name;

        $url = "http://localhost:8000/user-register/$user->token";

        Mail::to($request->email)->send(new NewUserMail(["name" => $request->name, "company_name" => $company_name, "email" => $request->email, "url" => $url]));

        return back()->withInput();
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'update' => 'required|in:status,admin',
        ]);

        if ($request->update == 'status') {
            $user = User::find($request->id);
            $user->is_deleted = !$user->is_deleted;
            $user->save();
        } else {
            $user = User::find($request->id);
            $user->is_admin = !$user->is_admin;
            $user->save();
        }

        $company_id = auth()->user()->company_id;
        $company_users = User::where('company_id', $company_id)->get();

        return response()->json([
            'users' => $company_users,
        ]);
    }
}
