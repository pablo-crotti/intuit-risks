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
        $user_id = auth()->user()->id;
        $company_id = Company::where('administrator_id', $user_id)->first()->id;

        $company_risks = CompanyRisk::with(['risk', 'category', 'evaluations'])
            ->where('company_id', $company_id)
            ->paginate(10);

        return inertia('Logged/Risks', [
            'risks' => $company_risks,
        ]);
    }
}
