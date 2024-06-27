<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
   public function index()
   {

    $user = auth()->user();

    $company = Company::with(['organizationType', 'country'])->where('id', $user->company_id)->first();
       
    return response()->json($company);
   }
}
