<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
   /**
    * The index function retrieves all categories from the database and returns them as a JSON
    * response.
    * 
    * @return An array of all categories in JSON format is being returned.
    */
    public function index() {
        $categories = Category::all();
        return response()->json($categories);
    }
}
