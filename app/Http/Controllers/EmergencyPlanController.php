<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\CompanyRisk;

use App\Models\CompanyRiskEmergencyPlanAction;
use Symfony\Component\Routing\Requirement\Requirement;

class EmergencyPlanController extends Controller
{
    public function index()
    {
        $risk = CompanyRisk::with(['author', 'category', 'responsible', 'emergencyPlanActions'])->find(request()->route('id'));
        $user = auth()->user();

        if ($risk->emergencyPlanStatus == 0) {
            return redirect()->route('dashboard');
        }


        return Inertia::render('Logged/EmergencyPlan/Execution', [
            'risk' => $risk,
            'user' => $user,
        ]);
    }


    public function update(Request $request)
    {
        $request->validate([
            'task' => 'required',
            'responsible' => 'required'
        ]);

        $updatedAction = CompanyRiskEmergencyPlanAction::find($request->task);
        $updatedAction->update([
            'agent_id' => $request->responsible
        ]);


        return back()->withInput();
    }

    public function start(Request $request)

    {


        $risk = CompanyRisk::find($request->route('id'));
        $risk->emergencyPlanStatus = 2;
        $risk->save();



        return back()->withInput();
    }

    public function actionDone(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);

        $action = CompanyRiskEmergencyPlanAction::find($request->id);
        $action->status = 1;
        $action->save();

        return back()->withInput();
    }

    public function actionResponse(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'response' => 'required'
        ]);

        $action = CompanyRiskEmergencyPlanAction::find($request->id);
        $action->response = $request->response;
        $action->save();

        return back()->withInput();
    }

    public function end()
    {
        $risk = CompanyRisk::find(request()->route('id'));
        $risk->emergencyPlanStatus = 0;
        $risk->save();

        $deleteActions = CompanyRiskEmergencyPlanAction::where('company_risk_id', $risk->id)->update([
            'status' => 0,
            'response' => null,
            'agent_id' => null

        ]);

        return redirect()->route('dashboard');
    }

    public function execute()
    {
        $risk = CompanyRisk::find(request()->route('id'));
        $risk->update([
            'emergencyPlanStatus' => 1
        ]);

        return redirect()->route('dashboard');
    }
}
