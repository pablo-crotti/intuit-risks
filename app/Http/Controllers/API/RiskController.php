<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompanyRisk;
use App\Models\CompanyRiskEvaluation;


class RiskController extends Controller
{
    public function index()
    {
        $company_id = auth()->user()->company_id;
        $risks = CompanyRisk::where('company_id', $company_id)->get();
        return response()->json($risks);
    }

    public function store(Request $request)
    {
        $request->validate([
            "title" => "required|string",
            "description" => "required|string",
            "category" => "required|array",
            "probability" => "required|numeric",
            "impact" => "required|numeric",

        ]);

        $company_id = auth()->user()->company_id;
        $user_id = auth()->user()->id;

        $companyRisk = new CompanyRisk();
        $companyRisk->company_id = $company_id;
        $companyRisk->author_id = $user_id;
        $companyRisk->category_id = $request->category['id'];
        $companyRisk->name = $request->title;
        $companyRisk->description = $request->description;
        $companyRisk->save();

        $evaluation = new CompanyRiskEvaluation();
        $evaluation->company_risk_id = $companyRisk->id;
        $evaluation->author_id = $user_id;
        $evaluation->probability = $request->probability;
        $evaluation->impact = $request->impact;
        $evaluation->save();

        return back()->withInput();
    }
}
