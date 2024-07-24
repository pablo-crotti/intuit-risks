<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompanyRiskEmergencyPlanAction;


class EmergencyPlanController extends Controller
{
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
