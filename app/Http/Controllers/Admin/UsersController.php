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

        return inertia('Logged/Admin/Users', [
            'users' => $company_users
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

        // $user = new User();
        // $user->name = $request->name;
        // $user->email = $request->email;
        // $user->is_admin = $request->is_admin;
        // $user->company_id = $company_id;
        // $user->save();
        
        $company_name = Company::where('id', $company_id)->first()->name;
       
        Mail::to($request->email)->send(new NewUserMail(["name" => $request->name, "company_name" => $company_name, "email" => $request->email]));

        // User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'is_admin' => $request->is_admin,
        //     'company_id' => auth()->user()->company_id,
        // ]);

        // return redirect()->route('admin.users');


        
    }
}
