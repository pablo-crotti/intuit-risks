<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CompanyRiskPrecursor;
use Illuminate\Http\Request;


class PrecursorsController extends Controller
{
    /**
     * The `store` function in PHP creates new CompanyRiskPrecursor instances based on input data from
     * a request.
     * 
     * @param Request request The `store` function you provided seems to be storing company risk
     * precursors based on the input received in the request.
     * 
     * @return The `store` function is storing new CompanyRiskPrecursor records based on the input data
     * provided in the request. After saving each precursor, the function redirects back to the
     * previous page with the input data.
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
     * The function deletes multiple CompanyRiskPrecursor records based on the input IDs received in
     * the request.
     * 
     * @param Request request The `Request ` parameter in the `delete` function is an instance
     * of the Illuminate\Http\Request class in Laravel. It represents an HTTP request that contains
     * data sent by the client.
     * 
     * @return The `delete` function is deleting multiple CompanyRiskPrecursor records based on the IDs
     * provided in the request input. After deleting the records, the function redirects back to the
     * previous page with input data.
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
     * The function updates the status of a CompanyRiskPrecursor object based on the input received in
     * a request.
     * 
     * @param Request request The `` parameter in the `update` function is an instance of the
     * `Illuminate\Http\Request` class in Laravel. It represents the HTTP request that is being made to
     * the server and contains data such as form inputs, headers, cookies, and files that are sent as
     * part of the request.
     * 
     * @return The `update` function is updating the status of a `CompanyRiskPrecursor` model based on
     * the input received from the request. After updating the status, it redirects back to the
     * previous page with the input data.
     */
    public function update(Request $request)
    {
        $precursor = CompanyRiskPrecursor::find($request->input('id'));
        $precursor->status = $request->input('status');
        $precursor->save();

        return back()->withInput();
    }
}
