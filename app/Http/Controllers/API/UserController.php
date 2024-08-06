<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;



class UserController extends Controller
{
    /**
     * @group Users
     *
     * Get Active Users
     *
     * Retrieve a list of active users for the authenticated user's company.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response containing the list of active users.
     * @response 200 [
     *   {
     *     "id": 1,
     *     "name": "John Doe",
     *     "email": "johndoe@example.com",
     *     "company_id": 1,
     *     "is_deleted": false,
     *     "created_at": "2024-01-01T00:00:00.000000Z",
     *     "updated_at": "2024-01-01T00:00:00.000000Z"
     *   },
     *   {
     *     "id": 2,
     *     "name": "Jane Smith",
     *     "email": "janesmith@example.com",
     *     "company_id": 1,
     *     "is_deleted": false,
     *     "created_at": "2024-01-01T00:00:00.000000Z",
     *     "updated_at": "2024-01-01T00:00:00.000000Z"
     *   }
     *   // ... more users
     * ]
     * @authenticated
     */
    public function index()
    {
        $company_id = auth()->user()->company_id;
        $users = User::where('company_id', $company_id)->where('is_deleted', false)->get();

        return response()->json($users);
    }
}
