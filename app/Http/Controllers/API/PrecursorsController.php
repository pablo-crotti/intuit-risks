<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CompanyRiskPrecursor;
use Illuminate\Http\Request;


class PrecursorsController extends Controller
{
    /**
     * @group Risk Precursors
     *
     * Store Precursors
     *
     * Add new precursors for a company risk.
     *
     * @param \Illuminate\Http\Request $request The request object.
     * @param array $request->precursors An array of precursors to be added.
     * @param string $request->precursors[].name The name of each precursor.
     * @param int $request->risk_id The ID of the associated company risk.
     * 
     * @return \Illuminate\Http\RedirectResponse Redirects back to the previous page with input data.
     * @authenticated
     */
    public function store(Request $request)
    {


        $precursors = $request->input('precursors');
        foreach ($precursors as $precursor) {
            $newPrecursor = new CompanyRiskPrecursor();
            $newPrecursor->company_risk_id = $request->input('risk_id');
            $newPrecursor->name = $precursor['name'];
            $newPrecursor->save();
        }

        return back()->withInput();
    }

    /**
     * @group Risk Precursors
     *
     * Delete Precursors
     *
     * Delete specified precursors by their IDs.
     *
     * @param \Illuminate\Http\Request $request The request object.
     * @param array $request->precursors An array of precursor IDs to be deleted.
     * @param int $request->precursors[] The ID of each precursor to be deleted.
     * 
     * @return \Illuminate\Http\RedirectResponse Redirects back to the previous page with input data.
     * @authenticated
     */
    public function delete(Request $request)
    {
        $ids = $request->input('precursors');

        foreach ($ids as $id) {
            $precursor = CompanyRiskPrecursor::find($id);
            $precursor->delete();
        }

        return back()->withInput();
    }

    /**
     * @group Risk Precursors
     *
     * Update Precursor Status
     *
     * Update the status of a specific precursor.
     *
     * @param \Illuminate\Http\Request $request The request object.
     * @param int $request->id The ID of the precursor to be updated.
     * @param string $request->status The new status of the precursor.
     * 
     * @return \Illuminate\Http\RedirectResponse Redirects back to the previous page with input data.
     * @authenticated
     */
    public function update(Request $request)
    {
        $precursor = CompanyRiskPrecursor::find($request->input('id'));
        $precursor->status = $request->input('status');
        $precursor->save();

        return back()->withInput();
    }
}
