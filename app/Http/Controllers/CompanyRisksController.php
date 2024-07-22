<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\CompanyRisk;
use App\Models\CompanyRiskEvaluation;

class CompanyRisksController extends Controller
{
    /**
     * The `display` function retrieves company risks with related data and returns them for display
     * using the Inertia.js framework.
     * 
     * @return The `display` function is returning an Inertia response with the data of company risks
     * related to the authenticated user's company. The function retrieves company risks along with
     * their related risk, category, and evaluations data based on the company ID of the authenticated
     * user. Finally, it returns a view named 'Logged/Risks' with the retrieved company risks data
     * passed as 'risks' to the view.
     */
    public function index()
    {
        $company_id = auth()->user()->company_id;

        $company_risks = CompanyRisk::with(['risk', 'category', 'evaluations'])->where('company_id', $company_id)->get();

        return inertia('Logged/Risks', [
            'risks' => $company_risks,
        ]);
    }
}
