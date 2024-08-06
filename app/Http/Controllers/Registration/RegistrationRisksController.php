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
     * @group Company Risks
     *
     * Display the risks registration view.
     *
     * Fetch and process risks based on the organization type of the authenticated user's company.
     * The risks are grouped by category, and categories are aggregated with their respective risk counts.
     * The view also includes the company's existing risks and the current registration step of the user.
     *
     * @return \Inertia\Response The Inertia response rendering the risks registration view.
     * @response 200 {
     *   "organization": {
     *     "id": 1,
     *     "name": "Organization Type Example",
     *     "risks": [
     *       {
     *         "id": 1,
     *         "name": "Risk Example",
     *         "category": {
     *           "id": 1,
     *           "name": "Category Example",
     *           "color": "#FF0000",
     *           "description_short": "Short description",
     *           "description_long": "Long description"
     *         },
     *         "is_active": true
     *       }
     *     ]
     *   },
     *   "categories": [
     *     {
     *       "id": 1,
     *       "name": "Category Example",
     *       "color": "#FF0000",
     *       "description_short": "Short description",
     *       "description_long": "Long description",
     *       "risks_count": 1
     *     }
     *   ],
     *   "risks": [
     *     {
     *       "category_id": 1,
     *       "risks": [
     *         {
     *           "id": 1,
     *           "name": "Risk Example",
     *           "description": "Description",
     *           "probability": 5,
     *           "impact": 7
     *         }
     *       ]
     *     }
     *   ],
     *   "companyRisks": [
     *     {
     *       "id": 1,
     *       "company_id": 1,
     *       "author_id": 1,
     *       "risk_id": 1,
     *       "category_id": 1,
     *       "name": "Risk Example",
     *       "description": "Description",
     *       "evaluations": [
     *         {
     *           "id": 1,
     *           "probability": 5,
     *           "impact": 7
     *         }
     *       ]
     *     }
     *   ],
     *   "registration_step": 2
     * }
     * @authenticated
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
     * @group Company Risks
     *
     * Store a new risk or update an existing one.
     *
     * If the risk already exists, its evaluations and records are deleted. Otherwise, a new risk is created and evaluated.
     * The method validates the input and creates or updates the company risk and its evaluation.
     *
     * @param \Illuminate\Http\Request $request The request object containing risk details.
     * @param array $request->selectedRisk The selected risk details.
     * @param int $request->selectedRisk.id The ID of the risk.
     * @param int $request->selectedRisk.category The ID of the risk category.
     * @param string $request->selectedRisk.name The name of the risk.
     * @param string $request->selectedRisk.description The description of the risk.
     * @param int $request->selectedRisk.probability The probability of the risk.
     * @param int $request->selectedRisk.impact The impact of the risk.
     * 
     * @return \Illuminate\Http\RedirectResponse Redirects back with input after processing.
     * @response 302 Redirect response to the previous page.
     * 
     * @throws \Illuminate\Validation\ValidationException If validation fails for any risk details.
     * @response 422 {
     *   "errors": {
     *     "selectedRisk.*.id": [
     *       "The id field is required and must be an integer."
     *     ],
     *     "selectedRisk.*.category": [
     *       "The category field is required and must be an integer."
     *     ],
     *     "selectedRisk.*.name": [
     *       "The name field is required."
     *     ],
     *     "selectedRisk.*.description": [
     *       "The description field is required."
     *     ],
     *     "selectedRisk.*.probability": [
     *       "The probability field is required and must be an integer."
     *     ],
     *     "selectedRisk.*.impact": [
     *       "The impact field is required and must be an integer."
     *     ]
     *   }
     * }
     * @authenticated
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
     * @group Risk Evaluation
     *
     * Update the evaluation of an existing risk.
     *
     * Validate and update the risk evaluation details for the given risk ID.
     *
     * @param \Illuminate\Http\Request $request The request object containing evaluation details.
     * @param array $request->newEvaluationData The new evaluation data.
     * @param int $request->newEvaluationData.id The ID of the risk evaluation.
     * @param int $request->newEvaluationData.probability The new probability value.
     * @param int $request->newEvaluationData.impact The new impact value.
     * 
     * @return void
     * @response 204 No content.
     * 
     * @throws \Illuminate\Validation\ValidationException If validation fails for evaluation data.
     * @response 422 {
     *   "errors": {
     *     "newEvaluationData.*.id": [
     *       "The id field is required and must be an integer."
     *     ],
     *     "newEvaluationData.*.probability": [
     *       "The probability field is required and must be an integer."
     *     ],
     *     "newEvaluationData.*.impact": [
     *       "The impact field is required and must be an integer."
     *     ]
     *   }
     * }
     * @authenticated
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

    /**
     * @group User Registration
     *
     * Update the user's registration step to the next phase.
     *
     * Sets the user's registration step to 3 to indicate progress in the registration process.
     *
     * @return void
     * @response 204 No content.
     * @authenticated
     */
    public function validate()
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $user->update([
            'registration_step' => 3
        ]);
    }
}
