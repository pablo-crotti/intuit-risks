<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Models\CompanyRisk;
use App\Models\CompanyRiskEvaluation;

class DashboardController extends Controller
{
    /**
     * @group Dashboard
     *
     * Display the company dashboard with risk evaluations and statistics.
     *
     * Retrieves and processes data to display on the dashboard, including:
     * - Total number of risks
     * - Categorization of risks into low, moderate, and critical based on their evaluations
     * - Recent evaluations with the highest criticality
     * - Detailed information about the most critical risks
     * 
     * @return \Inertia\Response The Inertia response rendering the dashboard view with the following data:
     * 
     * @response 200 {
     *   "company": {
     *     "id": 1,
     *     "name": "Company Name",
     *     "sector": "Sector",
     *     "country": "Country",
     *     "employees": 100,
     *     "city": "City"
     *   },
     *   "totalRisks": 25,
     *   "criticalityCategories": {
     *     "low": 5,
     *     "moderate": 10,
     *     "critical": 10
     *   },
     *   "evaluations": [
     *     {
     *       "id": 1,
     *       "company_risk_id": 1,
     *       "probability": 2,
     *       "impact": 3,
     *       "created_at": "2024-08-01T00:00:00Z"
     *     }
     *   ],
     *   "mainRisks": [
     *     {
     *       "id": 1,
     *       "company_risk_id": 1,
     *       "probability": 5,
     *       "impact": 7,
     *       "companyRisk": {
     *         "id": 1,
     *         "name": "Risk Name",
     *         "description": "Risk Description",
     *         "category": {
     *           "id": 1,
     *           "name": "Category Name"
     *         }
     *       }
     *     }
     *   ]
     * }
     * @authenticated
     */
    public function __invoke()
    {
        $company_id = auth()->user()->company_id;
        $company = Company::find($company_id);

        $results = DB::table('company_risks')
            ->join('company_risk_evaluations as cre', function ($join) {
                $join->on('company_risks.id', '=', 'cre.company_risk_id')
                    ->whereRaw('cre.id = (select max(id) from company_risk_evaluations where company_risk_id = company_risks.id)');
            })
            ->where('company_risks.company_id', $company_id)
            ->select(
                DB::raw('count(*) as totalRisks'),
                DB::raw('sum(case when cre.probability * cre.impact < 3 then 1 else 0 end) as low'),
                DB::raw('sum(case when cre.probability * cre.impact between 3 and 8 then 1 else 0 end) as moderate'),
                DB::raw('sum(case when cre.probability * cre.impact >=9 then 1 else 0 end) as critical')
            )
            ->first();


        $companyRisks = CompanyRisk::where('company_id', $company_id)->with('evaluations')->get();

        $evaluations = $companyRisks->flatMap(function ($risk) {
            return $risk->evaluations;
        });

        $recentEvaluations = DB::table('company_risk_evaluations as e1')
            ->select('e1.*', DB::raw('probability * impact as criticity'))
            ->join(DB::raw('(SELECT company_risk_id, MAX(created_at) as max_date FROM company_risk_evaluations GROUP BY company_risk_id) as e2'), function ($join) {
                $join->on('e1.company_risk_id', '=', 'e2.company_risk_id')
                    ->on('e1.created_at', '=', 'e2.max_date');
            })
            ->orderByDesc('criticity')
            ->take(5)
            ->get();

        $mainRisks = CompanyRiskEvaluation::whereIn('id', $recentEvaluations->pluck('id'))
            ->whereHas('companyRisk', function ($query) use ($company_id) {
                $query->where('company_id', $company_id);
            })
            ->with('companyRisk')
            ->get();


        return Inertia::render('Logged/Dashboard', [
            'company' => $company,
            'totalRisks' => $results->totalRisks,
            'criticalityCategories' => [
                'low' => $results->low,
                'moderate' => $results->moderate,
                'critical' => $results->critical,
            ],
            'evaluations' => $evaluations,
            'mainRisks' => $mainRisks->toArray()
        ]);
    }
}
