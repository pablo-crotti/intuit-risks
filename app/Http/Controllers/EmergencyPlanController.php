<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\CompanyRisk;

use App\Models\CompanyRiskEmergencyPlanAction;
use Symfony\Component\Routing\Requirement\Requirement;

class EmergencyPlanController extends Controller
{
    /**
     * @group Risk Emergency Plan
     * 
     * Mark the emergency plan of a specific risk as executed.
     *
     * Updates the `emergencyPlanStatus` of the specified risk to 1 (executed).
     * Redirects the user back to the dashboard.
     *
     * @return \Illuminate\Http\RedirectResponse A redirect response to the dashboard route.
     * @authenticated
     */
    public function execute()
    {
        $risk = CompanyRisk::find(request()->route('id'));
        $risk->update([
            'emergencyPlanStatus' => 1
        ]);

        return redirect()->route('dashboard');
    }

    /**
     * @group Risk Emergency Plan
     * 
     * Display the emergency plan execution view for a specific risk.
     *
     * Retrieves and displays the emergency plan details for the specified risk.
     * If the `emergencyPlanStatus` of the risk is 0 (not executed), redirects to the dashboard.
     *
     * @return \Inertia\Response A response rendering the emergency plan execution view.
     * @authenticated
     */
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

    /**
     * @group Risk Emergency Plan
     * 
     * Update the responsible agent for a specific emergency plan action.
     *
     * Validates the request for task ID and responsible agent ID,
     * then updates the responsible agent for the specified emergency plan action.
     *
     * @param \Illuminate\Http\Request $request The incoming request with task and responsible data.
     * 
     * @return \Illuminate\Http\RedirectResponse A redirect response back to the previous page with input.
     * @authenticated
     */
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

    /**
     * @group Risk Emergency Plan
     * 
     * Mark the emergency plan of a specific risk as started.
     *
     * Updates the `emergencyPlanStatus` of the specified risk to 2 (started).
     *
     * @param \Illuminate\Http\Request $request The incoming request with the risk ID.
     * 
     * @return \Illuminate\Http\RedirectResponse A redirect response back to the previous page with input.
     * @authenticated
     */
    public function start(Request $request)

    {


        $risk = CompanyRisk::find($request->route('id'));
        $risk->emergencyPlanStatus = 2;
        $risk->save();



        return back()->withInput();
    }

    /**
     * @group Risk Emergency Plan
     * 
     * Mark a specific emergency plan action as done.
     *
     * Validates the request for action ID, then updates the action status to 1 (done).
     *
     * @param \Illuminate\Http\Request $request The incoming request with action ID.
     * 
     * @return \Illuminate\Http\RedirectResponse A redirect response back to the previous page with input.
     * @authenticated
     */
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

    /**
     * @group Risk Emergency Plan
     * 
     * Provide a response for a specific emergency plan action.
     *
     * Validates the request for action ID and response text,
     * then updates the action's response field.
     *
     * @param \Illuminate\Http\Request $request The incoming request with action ID and response text.
     * 
     * @return \Illuminate\Http\RedirectResponse A redirect response back to the previous page with input.
     * @authenticated
     */
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

    /**
     * @group Risk Emergency Plan
     * 
     * Mark the emergency plan of a specific risk as ended.
     *
     * Updates the `emergencyPlanStatus` of the specified risk to 0 (ended),
     * and resets all associated emergency plan actions.
     *
     * @return \Illuminate\Http\RedirectResponse A redirect response to the dashboard route.
     * @authenticated
     */
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
}
