<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompanyRisk;
use App\Models\CompanyRiskEvaluation;
use App\Models\CompanyRiskReductionPlanTask;


class RiskController extends Controller
{
    /**
     * @group Company Risks
     *
     * Get Company Risks
     *
     * Retrieve a list of all risks associated with the authenticated user's company.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response containing the list of risks.
     * @response 200 [
     *   {
     *     "id": 1,
     *     "company_id": 1,
     *     "author_id": 2,
     *     "category_id": 3,
     *     "name": "Risk Title",
     *     "description": "Risk Description",
     *     "created_at": "2024-01-01T00:00:00.000000Z",
     *     "updated_at": "2024-01-01T00:00:00.000000Z"
     *   },
     *   // ... more risks
     * ]
     * @authenticated
     */
    public function index()
    {
        $company_id = auth()->user()->company_id;
        $risks = CompanyRisk::where('company_id', $company_id)->get();
        return response()->json($risks);
    }

    /**
     * @group Company Risks
     *
     * Store a New Risk
     *
     * Create a new risk for the authenticated user's company and evaluate it.
     *
     * @param \Illuminate\Http\Request $request The request object.
     * @param string $request->title The title of the risk.
     * @param string $request->description The description of the risk.
     * @param array $request->category The category of the risk.
     * @param int $request->category.id The ID of the risk category.
     * @param float $request->probability The probability of the risk.
     * @param float $request->impact The impact of the risk.
     * 
     * @return \Illuminate\Http\RedirectResponse Redirects back to the previous page with input data.
     * @authenticated
     */
    public function store(Request $request)
    {
        $request->validate([
            "title" => "required|string",
            "description" => "required|string",
            "category" => "required|array",
            "probability" => "required|numeric",
            "impact" => "required|numeric",
        ]);

        $company_id = auth()->user()->company_id;
        $user_id = auth()->user()->id;

        $companyRisk = new CompanyRisk();
        $companyRisk->company_id = $company_id;
        $companyRisk->author_id = $user_id;
        $companyRisk->category_id = $request->category['id'];
        $companyRisk->name = $request->title;
        $companyRisk->description = $request->description;
        $companyRisk->save();

        $evaluation = new CompanyRiskEvaluation();
        $evaluation->company_risk_id = $companyRisk->id;
        $evaluation->author_id = $user_id;
        $evaluation->probability = $request->probability;
        $evaluation->impact = $request->impact;
        $evaluation->save();

        return back()->withInput();
    }

    /**
     * @group Company Risks
     *
     * Update Risk Information
     *
     * Update details of an existing risk, including category, title, description, and evaluation frequency.
     *
     * @param \Illuminate\Http\Request $request The request object.
     * @param int $request->id The ID of the risk to be updated.
     * @param string $request->title The updated title of the risk.
     * @param string $request->description The updated description of the risk.
     * @param array $request->category The updated category of the risk.
     * @param int $request->category.id The ID of the updated risk category.
     * @param float $request->frequency The updated evaluation frequency of the risk.
     * @param array|null $request->responsible The updated responsible person.
     * @param int|null $request->responsible.id The ID of the responsible person.
     * 
     * @return \Illuminate\Http\RedirectResponse Redirects back to the previous page with input data.
     * @authenticated
     */
    public function update(Request $request)
    {
        $request->validate([
            "title" => "required|string",
            "description" => "required|string",
            "category" => "required|array",
            "frequency" => "required|numeric",

        ]);

        $responsible = $request->responsible;

        if ($responsible) {
            $responsible = $responsible['id'];
        } else {
            $responsible = null;
        }

        $update = CompanyRisk::find($request->id);
        $update->category_id = $request->category['id'];
        $update->name = $request->title;
        $update->description = $request->description;
        $update->responsible_id = $responsible;
        $update->evaluation_frequency = $request->frequency;
        $update->save();

        return back()->withInput();
    }

    /**
     * @group Company Risks
     *
     * Update Risk Strategy
     *
     * Update the strategy associated with a specific risk.
     *
     * @param \Illuminate\Http\Request $request The request object.
     * @param int $request->id The ID of the risk to be updated.
     * @param string $request->strategy The updated strategy for the risk.
     * 
     * @return \Illuminate\Http\RedirectResponse Redirects back to the previous page with input data.
     * @authenticated
     */
    public function updateStrategy(Request $request)
    {
        $request->validate([
            "strategy" => "required|string",
        ]);

        $update = CompanyRisk::find($request->id);
        $update->strategy = $request->strategy;
        $update->save();

        return back()->withInput();
    }

    /**
     * @group Reduction Plans
     *
     * Store Reduction Plans Task
     *
     * Create a new task associated with a risk reduction plan.
     *
     * @param \Illuminate\Http\Request $request The request object.
     * @param array $request->responsible The person responsible for the task.
     * @param int $request->responsible.id The ID of the responsible person.
     * @param string $request->task The description of the task.
     * 
     * @return \Illuminate\Http\RedirectResponse Redirects back to the previous page with input data.
     * @authenticated
     */
    public function storeTask(Request $request)
    {
        $request->validate([
            'responsible' => 'required',
            'task' => 'required',
        ]);


        $task = new CompanyRiskReductionPlanTask();
        $task->company_risk_id = $request->id;
        $task->agent_id = $request->responsible['id'];
        $task->action = $request->task;
        $task->save();

        return back()->withInput();
    }
}
