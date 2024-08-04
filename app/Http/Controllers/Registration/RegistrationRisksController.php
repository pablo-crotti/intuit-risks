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

    /**
     * The index function retrieves organization, risk categories, risks, and company risks data for
     * display in a web page.
     * 
     * @return The `index` function is returning data to be used in a view. The data being returned
     * includes:
     * - 'organization': The organization type with risks and categories
     * - 'categories': An array of categories with their details and the count of associated risks
     * - 'risks': Risks grouped by category ID
     * - 'companyRisks': Company risks with evaluations, filtered by the company ID
     */
    public function index()
    {

        $company_id = auth()->user()->company_id;

        $organization_id = Company::where('id', $company_id)->first()->organization_type_id;


        $organizationType = OrganizationType::with('risks.category')->find($organization_id);


        $categories = $organizationType->risks->mapToGroups(function ($risk) {
            return [$risk->category->id => $risk];
        });

        $risks = $organizationType->risks->filter(function ($risk) {
            return $risk->is_active == 1;
        })->groupBy('category_id');

        $categoriesWithCounts = $risks->map(function ($risks) {
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

        $companyRisks = CompanyRisk::with('evaluations')->where('company_id', $company_id)->get();

        return inertia('Logged/Registration/Risks', [
            'organization' => $organizationType,
            'categories' => $categoriesWithCounts,
            'risks' => $risks,
            'companyRisks' => $companyRisks,
            'registration_step' => auth()->user()->registration_step

        ]);
    }

    /**
     * The function `store` checks if a company risk already exists, deletes existing evaluations and
     * the risk if found, otherwise creates a new company risk and evaluation.
     * 
     * @param Request request The `store` function you provided is responsible for storing company
     * risks and their evaluations based on the request data.
     */
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

            return back()->withInput();
        }
    }

    /**
     * The update function in the PHP code snippet updates the probability and impact values of a
     * company risk evaluation based on the provided request data, while the validate function updates
     * the registration step of the authenticated user to 3.
     * 
     * @param Request request In the `update` function, you are trying to update the probability and
     * impact values of a CompanyRiskEvaluation based on the data received in the request. However,
     * there are a couple of issues in your code:
     */
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

    public function validate()
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $user->update([
            'registration_step' => 3
        ]);
    }
}
