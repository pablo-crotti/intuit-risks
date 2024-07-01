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
     * The function retrieves and returns a list of countries and organization types for display in a
     * company registration form using the Inertia.js framework.
     * 
     * @return The `display` function is returning a view called 'Company' with data for organizations
     * and countries. The data for organizations is fetched from the `OrganizationType` model and the
     * data for countries is fetched from the `Country` model, both sorted alphabetically. The data is
     * then passed to the view using Inertia for rendering.
     */
    public function display()
    {
        $countries = Country::orderBy('name')->get()->toArray();
        $organizations = OrganizationType::all()->toArray();


        return Inertia::render('Logged/Registration/Company', ['organizations' => $organizations, 'countries' => $countries]);
    }

    /**
     * The function stores company information provided in a request, associates it with the
     * authenticated user, and redirects to the next registration step for managing risks.
     * 
     * @param Request request The `store` function you provided is a controller method that handles
     * storing a new company record in a database. It expects a `Request` object as a parameter, which
     * contains the data submitted by a form.
     * 
     * @return RedirectResponse A RedirectResponse is being returned. The code is redirecting to the
     * 'register.risks.index' route with the absolute parameter set to false.
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
