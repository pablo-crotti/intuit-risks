<?php

namespace App\Http\Controllers\IntuitRisks;

use App\Http\Controllers\Controller;
use App\Models\OrganizationType;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Risk;


class RisksController extends Controller
{
    public function index()
    {
        $risks = Risk::with(['category', 'organizationTypes'])->get();
        $categories = $risks->pluck('category')->unique();
        $organizations = OrganizationType::all();



        return Inertia::render('IntuitRisks/Risks', [
            'risks' => $risks,
            'categories' => $categories,
            'organizations' => $organizations

        ]);
    }

    public function create(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'desc' => 'required',
            'organization_types' => 'required'
        ]);

        $risk = new Risk();
        $risk->name = $request->name;
        $risk->category_id = $request->category["id"];
        $risk->description = $request->desc;
        $risk->save();

        $risk->organizationTypes()->sync($request->organization_types);

        return back()->withInput();
    }

    public function update(Request $request)
    {
        if (!$request->has('name')) {
            $risk = Risk::find(request()->route('id'));
            $risk->is_active = !$risk->is_active;
            $risk->save();

            return back()->withInput();
        }
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'desc' => 'required',
            'organization_types' => 'required'
        ]);

        $risk = Risk::find(request()->route('id'));
        $risk->name = $request->name;
        $risk->category_id = $request->category["id"];
        $risk->description = $request->desc;
        $risk->save();


        $risk->organizationTypes()->sync($request->organization_types);

        return back()->withInput();
    }
}
