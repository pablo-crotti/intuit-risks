<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * @group Categories
     *
     * Get All Categories
     *
     * Retrieve a list of all categories.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response containing the list of categories.
     * @response 200 [
     *   {
     *     "id": 1,
     *     "name": "Electronics",
     *     "created_at": "2023-08-01T00:00:00.000000Z",
     *     "updated_at": "2023-08-01T00:00:00.000000Z"
     *   },
     *   {
     *     "id": 2,
     *     "name": "Books",
     *     "created_at": "2023-08-01T00:00:00.000000Z",
     *     "updated_at": "2023-08-01T00:00:00.000000Z"
     *   }
     *   // ... more categories
     * ]
     */
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories);
    }
}
