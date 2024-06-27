<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\CompanyRisk;
use App\Models\CompanyRiskEvaluation;

class CompanyRisksController extends Controller
{
    public function display()
    {
        $company_id = auth()->user()->company_id;

        $company_risks = CompanyRisk::with(['risk', 'category', 'evaluations'])->where('company_id', $company_id)->get();

        return inertia('Logged/Risks', [
            'risks' => $company_risks,
        ]);
    }
}
