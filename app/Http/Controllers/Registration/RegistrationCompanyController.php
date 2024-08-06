<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\OrganizationType;
use App\Models\Country;
use App\Models\Company;
use App\Models\User;
use Inertia\Inertia;

class RegistrationCompanyController extends Controller
{
    /**
     * @group Company Registration
     *
     * Display the company registration view.
     *
     * Retrieve all organizations and countries, and render the `Logged/Registration/Company` view.
     * The view includes lists of organizations and countries for user selection.
     *
     * @return \Inertia\Response The Inertia response rendering the company registration view.
     * @response 200 {
     *   "organizations": [
     *     {
     *       "id": 1,
     *       "name": "Organization Type Example"
     *     }
     *   ],
     *   "countries": [
     *     {
     *       "id": 1,
     *       "name": "Country Example"
     *     }
     *   ]
     * }
     * 
     * @authenticated
     */
    public function display()
    {
        $countries = Country::orderBy('name')->get()->toArray();
        $organizations = OrganizationType::all()->toArray();


        return Inertia::render('Logged/Registration/Company', ['organizations' => $organizations, 'countries' => $countries]);
    }

    /**
     * @group Company Registration
     *
     * Handle the creation of a new company.
     *
     * Validate the provided company details and create a new company entry in the database.
     * Update the authenticated user's company ID and registration step.
     *
     * @param \Illuminate\Http\Request $request The request object containing company details.
     * @param string $request->name The name of the company.
     * @param int $request->organization The ID of the organization type.
     * @param string $request->sector The sector in which the company operates.
     * @param int $request->country The ID of the country where the company is based.
     * @param int $request->employees The number of employees in the company.
     * @param string $request->city The city where the company is located.
     * 
     * @return \Illuminate\Http\RedirectResponse Redirects to the risks registration page after successful creation.
     * @response 302 Redirect response to the route for registering risks.
     * 
     * @throws \Illuminate\Validation\ValidationException If validation fails for any required fields.
     * @response 422 {
     *   "errors": {
     *     "name": [
     *       "The name field is required."
     *     ],
     *     "organization": [
     *       "The organization field is required and must be an integer."
     *     ],
     *     "sector": [
     *       "The sector field is required."
     *     ],
     *     "country": [
     *       "The country field is required and must be an integer."
     *     ],
     *     "employees": [
     *       "The employees field is required and must be an integer with a minimum value of 0."
     *     ],
     *     "city": [
     *       "The city field is required."
     *     ]
     *   }
     * }
     * @authenticated
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'organization' => 'required|integer',
            'sector' => 'required|string|max:255',
            'country' => 'required|integer',
            'employees' => 'required|integer|min:0',
            'city' => 'required|string|max:255',
        ]);

        $user_id = auth()->user()->id;

        $company = Company::create([
            'name' => $request->name,
            'organization_type_id' => $request->organization,
            'sector' => $request->sector,
            'country_id' => $request->country,
            'employees' => $request->employees,
            'city' => $request->city,
            'administrator_id' => $user_id,
        ]);

        $user = User::find($user_id);
        $user->company_id = $company->id;
        $user->registration_step = 2;
        $user->save();

        return redirect(route('register.risks.index', absolute: false));
    }
}
