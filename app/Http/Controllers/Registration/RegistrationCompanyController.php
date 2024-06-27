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
    public function display()
    {
        $countries = Country::orderBy('name')->get()->toArray();
        $organizations = OrganizationType::all()->toArray();


        return Inertia::render('Logged/Registration/Company', ['organizations' => $organizations, 'countries' => $countries]);
    }

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
