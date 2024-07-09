<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;



class UserController extends Controller
{
    public function index() {
        $company_id = auth()->user()->company_id;
        $users = User::where('company_id', $company_id)->where('is_deleted', false)->get();

        return response()->json($users);
    }

}
