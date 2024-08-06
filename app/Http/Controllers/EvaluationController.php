<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyRiskEvaluation;

class EvaluationController extends Controller
{
    /**
     * @group Risk Evaluation
     * 
     * Store a new risk evaluation for a company.
     *
     * Validates the incoming request data to ensure that all required fields are present and within valid ranges.
     * Creates a new `CompanyRiskEvaluation` instance with the provided risk ID, probability, and impact values,
     * and associates it with the currently authenticated user.
     *
     * @param \Illuminate\Http\Request $request The incoming request containing the evaluation data.
     * 
     * @return \Illuminate\Http\RedirectResponse A redirect response back to the previous page with input.
     * @authenticated
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
