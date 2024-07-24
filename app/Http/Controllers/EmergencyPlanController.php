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

        if ($risk->emergencyPlanStatus == 0 || $risk->emergencyPlanStatus == 2) {
            $risk->update([
                'emergencyPlanStatus' => 1
            ]);
        }


        return Inertia::render('Logged/EmergencyPlan/Execution', [
            'risk' => $risk,
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

    public function start()
    {
        $risk = CompanyRisk::find(request()->route('id'));
        $risk->update([
            'emergencyPlanStatus' => 2
        ]);
        $risk->save();

        dd($risk);

        return back()->withInput();
    }
}
