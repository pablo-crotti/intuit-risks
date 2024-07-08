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
     * The function retrieves and processes data related to company risks and evaluations for display
     * on dashboard.
     * 
     * @return The code snippet provided is a PHP function that is invoked when called. It performs the
     * following actions:
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
