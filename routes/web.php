<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RegistrationSteps;
use App\Http\Controllers\Registration\RegistrationCompanyController;
use App\Http\Controllers\Registration\RegistrationRisksController;
use App\Http\Controllers\CompanyRisksController;
use App\Http\Controllers\CompanyRiskController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\EnsureUserIsActivated;
use App\Http\Controllers\EmergencyPlanController;
use App\Http\Middleware\EmergencyPlanActive;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', DashboardController::class)->middleware(['auth', EnsureUserIsActivated::class, 'verified', RegistrationSteps::class, EmergencyPlanActive::class])->name('dashboard');

Route::middleware('auth', EnsureUserIsActivated::class)->group(function () {
    Route::get('/register/company', [RegistrationCompanyController::class, 'display'])->name('register.company');
    Route::post('/register/company', [RegistrationCompanyController::class, 'store'])->name('register.company.store');
    Route::get('/register/risks', [RegistrationRisksController::class, 'index'])->name('register.risks.index');
    Route::post('/register/risks', [RegistrationRisksController::class, 'store'])->name('register.risks.store');
    Route::patch('/register/risks', [RegistrationRisksController::class, 'update'])->name('register.risks.update');
    Route::post('/register/risks/validate', [RegistrationRisksController::class, 'validate'])->name('register.risks.validate');
});

Route::middleware('auth', EnsureUserIsActivated::class)->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->middleware(EmergencyPlanActive::class)->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth', EnsureUserIsActivated::class)->group(function () {
    Route::get('/risks', [CompanyRisksController::class, 'index'])->middleware(EmergencyPlanActive::class)->name('risks');
    Route::get('/risks/{id}', [CompanyRiskController::class, 'display'])->middleware(EmergencyPlanActive::class)->name('risks.show');
});

Route::middleware('auth', EnsureUserIsActivated::class)->group(function () {
    Route::get('/admin/users', [UsersController::class, 'index'])->middleware(EmergencyPlanActive::class)->name('admin.users');
    Route::post('/admin/users', [UsersController::class, 'store'])->name('admin.users.store');
    Route::patch('/admin/users', [UsersController::class, 'update'])->name('admin.users.update');
});


Route::middleware(['auth', EnsureUserIsActivated::class])->group(function () {
    Route::get('/emergency-plan/{id}', [EmergencyPlanController::class, 'index'])->name('emergency.plan');
    Route::patch('/emergency-plan/{id}/agents', [EmergencyPlanController::class, 'update'])->name('emergency.plan.set.agents');
    Route::patch('/emergency-plan/{id}/start', [EmergencyPlanController::class, 'start'])->name('emergency.plan.start');
});



require __DIR__ . '/auth.php';
require __DIR__ . '/api.php';
