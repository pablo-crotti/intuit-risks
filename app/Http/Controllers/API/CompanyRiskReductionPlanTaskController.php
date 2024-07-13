<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompanyRiskReductionPlanTask;

class CompanyRiskReductionPlanTaskController extends Controller
{
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

    public function delete(Request $request) {
        $task = CompanyRiskReductionPlanTask::find($request->id);
        $task->delete();

        return back()->withInput();
    }
}
