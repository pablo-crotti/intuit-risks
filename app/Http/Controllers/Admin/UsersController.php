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
    /**
     * Get Company Users
     *
     * Retrieve all users for the authenticated user's company.
     *
     * @group Users
     * 
     * @return \Illuminate\Http\Response An object containing the users of the company and the administrator ID.
     * @return array returns.users Array of users.
     * @return int returns.users[].id The ID of the user.
     * @return string returns.users[].name The name of the user.
     * @return string returns.users[].email The email of the user.
     * @return int returns.users[].company_id The ID of the company.
     * @return bool returns.users[].is_admin Whether the user is an admin.
     * @return int returns.users[].registration_step The registration step of the user.
     * @return string returns.users[].token The registration token of the user.
     * @return bool returns.users[].is_deleted Whether the user is deleted.
     * @return int returns.admin The administrator ID of the company.
     * @authenticated
     */
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

    /**
     * Create a New User
     *
     * Create a new user for the authenticated user's company.
     *
     * @group Users
     * 
     * @param \Illuminate\Http\Request $request The request object.
     * @param string $request->name The name of the user.
     * @param string $request->email The email of the user.
     * @param bool $request->is_admin Whether the user is an admin.
     * 
     * @return \Illuminate\Http\RedirectResponse
     * @authenticated
     */
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

    /**
     * Update User Information
     *
     * Update the status or admin role of a specific user.
     *
     * @group Users
     * 
     * @param \Illuminate\Http\Request $request The request object.
     * @param int $request->id The ID of the user.
     * @param string $request->update The field to update (status or admin).
     * 
     * @return \Illuminate\Http\JsonResponse An object containing the updated list of users.
     * @return array returns.users Array of users.
     * @return int returns.users[].id The ID of the user.
     * @return string returns.users[].name The name of the user.
     * @return string returns.users[].email The email of the user.
     * @return int returns.users[].company_id The ID of the company.
     * @return bool returns.users[].is_admin Whether the user is an admin.
     * @return int returns.users[].registration_step The registration step of the user.
     * @return string returns.users[].token The registration token of the user.
     * @return bool returns.users[].is_deleted Whether the user is deleted.
     * @authenticated
     */
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
