<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyRisk;
use Inertia\Inertia;

class CompanyRiskController extends Controller
{
    /**
     * @group Company Risks
     *
     * Display the detailed view of a specific company risk.
     *
     * Retrieves the detailed information of a company risk based on the provided risk ID.
     * Includes related data such as the author, category, evaluations, precursors, responsible individuals,
     * reduction plan tasks, and emergency plan actions associated with the risk.
     *
     * @param \Illuminate\Http\Request $request The request object containing the risk ID.
     * @param int $request->route('id') The ID of the risk to be displayed.
     * 
     * @return \Inertia\Response The Inertia response rendering the detailed view of the risk.
     * @response 200 {
     *   "risk": {
     *     "id": 1,
     *     "company_id": 1,
     *     "author": {
     *       "id": 1,
     *       "name": "Author Name"
     *     },
     *     "category": {
     *       "id": 1,
     *       "name": "Category Name"
     *     },
     *     "name": "Risk Name",
     *     "description": "Risk Description",
     *     "evaluations": [
     *       {
     *         "id": 1,
     *         "probability": 5,
     *         "impact": 7
     *       }
     *     ],
     *     "precursors": [
     *       {
     *         "id": 1,
     *         "name": "Precursor Name"
     *       }
     *     ],
     *     "responsible": [
     *       {
     *         "id": 1,
     *         "name": "Responsible Person Name"
     *       }
     *     ],
     *     "reductionPlanTasks": [
     *       {
     *         "id": 1,
     *         "action": "Task Action",
     *         "agent": {
     *           "id": 1,
     *           "name": "Agent Name"
     *         }
     *       }
     *     ],
     *     "emergencyPlanActions": [
     *       {
     *         "id": 1,
     *         "action": "Emergency Plan Action",
     *         "agent": {
     *           "id": 1,
     *           "name": "Agent Name"
     *         }
     *       }
     *     ]
     *   }
     * }
     */
    public function display()
    {
        $risk = CompanyRisk::with(['author', 'category', 'evaluations', 'precursors', 'responsible', 'reductionPlanTasks', 'emergencyPlanActions'])->find(request()->route('id'));

        return inertia('Logged/Risk', [
            'risk' => $risk,
        ]);
    }
}
