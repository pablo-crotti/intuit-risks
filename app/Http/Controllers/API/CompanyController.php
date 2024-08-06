<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
   /**
    * @group Company
    *
    * Get Company Information
    *
    * Retrieve detailed information about the authenticated user's company, including its organization type and country.
    *
    * @return \Illuminate\Http\JsonResponse A JSON response containing the company details.
    * @response 200 {
    *   "id": 1,
    *   "name": "Acme Corporation",
    *   "organization_type": {
    *     "id": 2,
    *     "type": "LLC"
    *   },
    *   "country": {
    *     "id": 1,
    *     "name": "United States"
    *   },
    *   "created_at": "2023-08-01T00:00:00.000000Z",
    *   "updated_at": "2023-08-01T00:00:00.000000Z"
    * }
    * @authenticated
    */
   public function index()
   {

      $user = auth()->user();

      $company = Company::with(['organizationType', 'country'])->where('id', $user->company_id)->first();

      return response()->json($company);
   }
}
