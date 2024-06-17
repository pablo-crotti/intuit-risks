<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\OrganizationType;
use App\Models\CompanyRisk;
use App\Models\CompanyRiskEvaluation;
use App\Models\Risk;
use Illuminate\Http\Request;

class RegistrationRisksController extends Controller
{
    public function display()
    {
        $user_id = auth()->user()->id;
        $organizationId = Company::where('administrator_id', $user_id)->first()->organization_type_id;

        $organization = OrganizationType::with(['risks.category'])
            ->findOrFail($organizationId);

        $groupedRisks = $organization->risks->groupBy('category.name');

        return inertia('Logged/Registration/Risks', [
            'organization' => $organization,
            'risks' => $groupedRisks->jsonSerialize(),
        ]);
    }

    public function store(Request $request)
    {

        $selectedRisks = $request->input('selectedRisks');

        $request->validate([
            'selectedRisks' => 'required|array',
        ]);


        $user_id = auth()->user()->id;
        $company_id = Company::where('administrator_id', $user_id)->first()->id;


        foreach ($selectedRisks as $selectedRiskGroup) {
            if (!empty($selectedRiskGroup)) {
                foreach ($selectedRiskGroup as $risk) {
                    $companyRisk = new CompanyRisk();
                    $companyRisk->company_id = $company_id;
                    $companyRisk->author_id = $user_id;
                    $companyRisk->risk_id = $risk['id'];
                    $companyRisk->category_id = $risk['category'];
                    $companyRisk->name = $risk['name'];
                    $companyRisk->description = $risk['description'];
                    $companyRisk->save();

                    $evaluation = new CompanyRiskEvaluation();
                    $evaluation->company_risk_id = $companyRisk->id;
                    $evaluation->author_id = $user_id;
                    $evaluation->probability = $risk['probability'];
                    $evaluation->impact = $risk['impact'];
                    $evaluation->save();
                }
            }
        }


        return redirect()->route('dashboard');
    }
}
