<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyRisk;
use Inertia\Inertia;

class CompanyRiskController extends Controller
{
    /**
     * The function `display` retrieves a CompanyRisk model with related data and returns it to an
     * Inertia view for display.
     * 
     * @return The `display` function is returning an Inertia response with the data of a specific
     * CompanyRisk model loaded with its related author, category, evaluations, and precursors. The
     * data is fetched based on the ID provided in the route parameters. The returned data is then
     * passed to the 'Logged/Risk' Inertia view component under the 'risk' key.
     */
    public function display()
    {
        $risk = CompanyRisk::with(['author', 'category', 'evaluations', 'precursors', 'responsible'])->find(request()->route('id'));

        return inertia('Logged/Risk', [
            'risk' => $risk,
        ]);
    }
}
