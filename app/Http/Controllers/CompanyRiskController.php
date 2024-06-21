<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyRisk;
use Inertia\Inertia;

class CompanyRiskController extends Controller
{
    public function display()
    {
        $risk = CompanyRisk::with(['author', 'category', 'evaluations'])->find(request()->route('id'));

        return inertia('Logged/Risk', [
            'risk' => $risk,
        ]);
    }

    
}
