<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CompanyRiskPrecursor;
use Illuminate\Http\Request;


class PrecursorsController extends Controller
{
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

    public function delete(Request $request)
    {
        $ids = $request->input('precursors');

        foreach ($ids as $id) {
            $precursor = CompanyRiskPrecursor::find($id);
            $precursor->delete();
        }

        return back()->withInput();
    }

    public function update(Request $request)
    {
        $precursor = CompanyRiskPrecursor::find($request->input('id'));
        $precursor->status = $request->input('status');
        $precursor->save();

        return back()->withInput();
    }
}
