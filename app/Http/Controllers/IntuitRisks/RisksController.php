<?php

namespace App\Http\Controllers\IntuitRisks;

use App\Http\Controllers\Controller;
use App\Models\OrganizationType;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Risk;


class RisksController extends Controller
{
    /**
     * @group Risks
     *
     * Display a list of risks.
     *
     * Retrieve all risks with their associated categories and organization types.
     * Return the data to be rendered on the `IntuitRisks/Risks` view.
     *
     * @return \Inertia\Response The Inertia response rendering the risks view.
     * @response 200 {
     *   "risks": [
     *     {
     *       "id": 1,
     *       "name": "Risk Example",
     *       "category": {
     *         "id": 2,
     *         "name": "Category Example"
     *       },
     *       "organizationTypes": [
     *         {
     *           "id": 3,
     *           "name": "Organization Type Example"
     *         }
     *       ]
     *     }
     *   ],
     *   "categories": [
     *     {
     *       "id": 2,
     *       "name": "Category Example"
     *     }
     *   ],
     *   "organizations": [
     *     {
     *       "id": 3,
     *       "name": "Organization Type Example"
     *     }
     *   ]
     * }
     * @authenticated
     */
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

    /**
     * @group Risks
     *
     * Handle the creation of a new risk.
     *
     * Validate the provided risk details and create a new risk entry in the database.
     * Associate the risk with the specified organization types.
     *
     * @param \Illuminate\Http\Request $request The request object containing risk details.
     * @param string $request->name The name of the risk.
     * @param array $request->category The category of the risk.
     * @param string $request->desc The description of the risk.
     * @param array $request->organization_types The organization types associated with the risk.
     * 
     * @return \Illuminate\Http\RedirectResponse Redirects back with input after successful creation.
     * @response 302 Redirect response back to the previous page with input.
     * 
     * @throws \Illuminate\Validation\ValidationException If validation fails for any required fields.
     * @response 422 {
     *   "errors": {
     *     "name": [
     *       "The name field is required."
     *     ],
     *     "category": [
     *       "The category field is required."
     *     ],
     *     "desc": [
     *       "The description field is required."
     *     ],
     *     "organization_types": [
     *       "The organization types field is required."
     *     ]
     *   }
     * }
     * @authenticated
     */
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

    /**
     * @group Risks
     *
     * Handle the updating of an existing risk.
     *
     * Validate the provided risk details and update the existing risk entry in the database.
     * If no name is provided, toggle the active status of the risk instead.
     * Update the associated organization types for the risk.
     *
     * @param \Illuminate\Http\Request $request The request object containing updated risk details.
     * @param string|null $request->name The updated name of the risk, or null to toggle active status.
     * @param array $request->category The updated category of the risk.
     * @param string $request->desc The updated description of the risk.
     * @param array $request->organization_types The updated organization types associated with the risk.
     * 
     * @return \Illuminate\Http\RedirectResponse Redirects back with input after successful update.
     * @response 302 Redirect response back to the previous page with input.
     * 
     * @throws \Illuminate\Validation\ValidationException If validation fails for any required fields when updating.
     * @response 422 {
     *   "errors": {
     *     "name": [
     *       "The name field is required."
     *     ],
     *     "category": [
     *       "The category field is required."
     *     ],
     *     "desc": [
     *       "The description field is required."
     *     ],
     *     "organization_types": [
     *       "The organization types field is required."
     *     ]
     *   }
     * }
     * @authenticated
     */
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
