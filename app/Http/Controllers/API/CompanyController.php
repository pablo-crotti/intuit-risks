<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
   /**
    * The function retrieves the company details along with its organization type and country for the
    * authenticated user and returns the data in JSON format.
    * 
    * @return The code is returning a JSON response containing the company details of the authenticated
    * user. The company details include the organization type and country associated with the company.
    */
   public function index()
   {

    $user = auth()->user();

    $company = Company::with(['organizationType', 'country'])->where('id', $user->company_id)->first();
       
    return response()->json($company);
   }
}
