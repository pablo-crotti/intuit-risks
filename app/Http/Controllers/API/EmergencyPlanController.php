<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompanyRiskEmergencyPlanAction;


class EmergencyPlanController extends Controller
{
    /**
     * @group Risk Emergency Plan
     *
     * Store Risk Emergency Plan Actions
     *
     * Store new risk emergency plan actions and delete specified actions.
     *
     * @param \Illuminate\Http\Request $request The request object.
     * @param array $request->informations An array of information actions to be added.
     * @param array $request->actions An array of general actions to be added.
     * @param array $request->toDelete An array of action IDs to be deleted.
     * 
     * @param array $request->informations[].information The information to be stored in each information action.
     * @param array $request->actions[].action The action to be stored in each general action.
     * @param array $request->toDelete[] The IDs of the actions to be deleted.
     * 
     * @return \Illuminate\Http\RedirectResponse Redirects back to the previous page with input data.
     * @authenticated
     */
    public function store(Request $request)
    {

        $request->validate([
            'informations' => 'array',
            'actions' => 'array',
            'toDelete' => 'array'
        ]);

        $id = $request->route('id');

        foreach ($request->informations as $key => $information) {
            $newAction = CompanyRiskEmergencyPlanAction::create([
                'company_risk_id' => $id,
                'is_information' => true,
                'action' => $information['information']
            ]);
        }

        foreach ($request->actions as $key => $action) {
            $newAction = CompanyRiskEmergencyPlanAction::create([
                'company_risk_id' => $id,
                'is_information' => false,
                'action' => $action['action']
            ]);
        }

        foreach ($request->toDelete as $key => $action) {
            CompanyRiskEmergencyPlanAction::where('id', $action)->delete();
        }

        return back()->withInput();
    }
}
