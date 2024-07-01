<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyRiskEvaluation;

class EvaluationController extends Controller
{
    /**
     * The function stores a new company risk evaluation based on the provided risk ID, probability,
     * and impact values.
     * 
     * @param Request request The `store` function in the code snippet is responsible for storing a new
     * `CompanyRiskEvaluation` record based on the data provided in the request. Here's a breakdown of
     * the code:
     * 
     * @return The `back()->withInput()` method is being used to redirect the user back to the previous
     * page with the input data that was submitted. This is commonly used to display any validation
     * errors or to maintain the form data that was entered by the user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'risk_id' => 'required|integer',
            'probability' => 'required|integer|min:1|max:5',
            'impact' => 'required|integer|min:1|max:5',
        ]);

        $evaluation = new CompanyRiskEvaluation();
        $evaluation->company_risk_id = $request->input('risk_id');
        $evaluation->author_id = auth()->user()->id;
        $evaluation->probability = $request->input('probability');
        $evaluation->impact = $request->input('impact');
        $evaluation->save();

        return back()->withInput();
    }
}
