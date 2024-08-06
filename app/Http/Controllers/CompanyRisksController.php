<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\CompanyRisk;
use App\Models\CompanyRiskEvaluation;

class CompanyRisksController extends Controller
{
    /**
     * @group Company Risks
     *
     * Display a list of risks associated with the authenticated user's company.
     *
     * Retrieves all company risks related to the company of the currently authenticated user.
     * Includes related data such as risk details, categories, and evaluations.
     *
     * @param \Illuminate\Http\Request $request The request object used to fetch the risks.
     *
     * @return \Inertia\Response The Inertia response rendering the list of company risks.
     * @response 200 {
     *   "risks": [
     *     {
     *       "id": 1,
     *       "company_id": 1,
     *       "risk": {
     *         "id": 1,
     *         "name": "Risk Name",
     *         "description": "Risk Description"
     *       },
     *       "category": {
     *         "id": 1,
     *         "name": "Category Name"
     *       },
     *       "evaluations": [
     *         {
     *           "id": 1,
     *           "probability": 5,
     *           "impact": 7
     *         }
     *       ]
     *     }
     *   ]
     * }
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
