<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\OrganizationType;
use App\Models\CompanyRisk;
use App\Models\CompanyRiskEvaluation;
use Illuminate\Http\Request;
use App\Models\User;

class RegistrationRisksController extends Controller
{

    public function index()
    {
        $user_id = auth()->user()->id;
        $organization_id = Company::where('administrator_id', $user_id)->first()->organization_type_id;
        $company_id = Company::where('administrator_id', $user_id)->first()->id;


        $organizationType = OrganizationType::with('risks.category')->find($organization_id);


        $categories = $organizationType->risks->mapToGroups(function ($risk) {
            return [$risk->category->id => $risk];
        });

        $categoriesWithCounts = $categories->map(function ($risks) {
            $category = $risks->first()->category;
            return [
                'id' => $category->id,
                'name' => $category->name,
                'color' => $category->color,
                'description_short' => $category->description_short,
                'description_long' => $category->description_long,
                'risks_count' => $risks->count()
            ];
        })->values();

        $risks = $organizationType->risks->groupBy('category_id');

        $companyRisks = CompanyRisk::with('evaluations')->where('company_id', $company_id)->get();

        return inertia('Logged/Registration/Risks', [
            'organization' => $organizationType,
            'categories' => $categoriesWithCounts,
            'risks' => $risks,
            'companyRisks' => $companyRisks
        ]);
    }

    public function store(Request $request)
    {
        $riskExists = CompanyRisk::where('risk_id', $request->id)->first();

        if ($riskExists) {
            $evaluations = CompanyRiskEvaluation::where('company_risk_id', $riskExists->id)->get();
            $evaluations->each->delete();
            $riskExists->delete();
        } else {


            $selectedRisk = $request->all();

            $request->validate([
                'selectedRisk.*.id' => 'required|integer',
                'selectedRisk.*.category' => 'required|integer',
                'selectedRisk.*.name' => 'required|string',
                'selectedRisk.*.description' => 'required|string',
                'selectedRisk.*.probability' => 'required|integer',
                'selectedRisk.*.impact' => 'required|integer',
            ]);

            $company_id = Company::where('administrator_id', auth()->user()->id)->first()->id;


            $companyRisk = new CompanyRisk();
            $companyRisk->company_id = $company_id;
            $companyRisk->author_id = auth()->user()->id;
            $companyRisk->risk_id = $selectedRisk['id'];
            $companyRisk->category_id = $selectedRisk['category'];
            $companyRisk->name = $selectedRisk['name'];
            $companyRisk->description = $selectedRisk['description'];
            $companyRisk->save();

            $evaluation = new CompanyRiskEvaluation();
            $evaluation->company_risk_id = $companyRisk->id;
            $evaluation->author_id = auth()->user()->id;
            $evaluation->probability = $selectedRisk['probability'];
            $evaluation->impact = $selectedRisk['impact'];
            $evaluation->save();
        }
    }

    public function update(Request $request)
    {
        $newEvaluationData = $request->all();

        $request->validate([
            'newEvaluationData.*.id' => 'required|integer',
            'newEvaluationData.*.probability' => 'required|integer',
            'newEvaluationData.*.impact' => 'required|integer',
        ]);

        $evaluation = CompanyRiskEvaluation::where('id', $newEvaluationData['id'])->first();
        $evaluation->probability = $newEvaluationData['probability'];
        $evaluation->impact = $newEvaluationData['impact'];
        $evaluation->save();
    }

    public function validate() {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $user->update([
            'registration_step' => 3
        ]);
    }
}

