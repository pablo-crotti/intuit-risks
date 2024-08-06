<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompanyRiskReductionPlanTask;

class CompanyRiskReductionPlanTaskController extends Controller
{
    /**
     * @group Reduction Plans
     *
     * Update Reduction Plans
     *
     * Update the status and optional remark of a specific task.
     *
     * @param \Illuminate\Http\Request $request The request object.
     * @param int $request->id The ID of the task.
     * @param int $request->status The new status of the task. Must be -1 or 1.
     * @param string|null $request->remark An optional remark for the task.
     *
     * @return \Illuminate\Http\RedirectResponse Redirects back to the previous page with input data.
     * @authenticated
     */
    public function update(Request $request)
    {


        $request->validate([
            'status' => 'required|in:-1,1',
            'remark' => 'string|nullable',
        ]);

        $task = CompanyRiskReductionPlanTask::find($request->id);
        $task->status = $request->status;
        $task->remark = $request->remark;
        $task->save();

        return back()->withInput();
    }

    /**
     * @group Reduction Plans
     *
     * Delete a Task
     *
     * Delete a specific task by its ID.
     *
     * @param \Illuminate\Http\Request $request The request object.
     * @param int $request->id The ID of the task to be deleted.
     *
     * @return \Illuminate\Http\RedirectResponse Redirects back to the previous page with input data.
     * @authenticated
     */
    public function delete(Request $request)
    {
        $task = CompanyRiskReductionPlanTask::find($request->id);
        $task->delete();

        return back()->withInput();
    }
}
