<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyRiskEvaluation;

class EvaluationController extends Controller
{
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
