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
use App\Http\Controllers\IntuitRisks\RisksController;
use App\Http\Middleware\EmergencyPlanActive;
use App\Http\Middleware\IsIntuitRisksAdmin;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('welcome');

Route::get('/cgi', function () {
    return Inertia::render('ConditionsGenerales');
})->name('cgi');

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
    Route::patch('/emergency-plan/{id}/execute', [EmergencyPlanController::class, 'execute'])->name('emergency.plan.execute');

    Route::patch('/emergency-plan/{id}/start', [EmergencyPlanController::class, 'start'])->name('emergency.plan.start');
    Route::patch('/emergency-plan/{id}/end', [EmergencyPlanController::class, 'end'])->name('emergency.plan.end');

    Route::patch('/emergency-plan/{id}/action-done', [EmergencyPlanController::class, 'actionDone'])->name('emergency.plan.action.done');
    Route::patch('/emergency-plan/{id}/action-response', [EmergencyPlanController::class, 'actionResponse'])->name('emergency.plan.action.response');
});

Route::middleware(['auth', EnsureUserIsActivated::class, IsIntuitRisksAdmin::class])->group(function () {
    Route::get('/intuit-risks/risks', [RisksController::class, 'index'])->name('intuitrisks.risks');
    Route::post('/intuit-risks/risks', [RisksController::class, 'create'])->name('intuitrisks.risks.create');
    Route::patch('/intuit-risks/risks/{id}', [RisksController::class, 'update'])->name('intuitrisks.risks.update');
});



require __DIR__ . '/auth.php';
require __DIR__ . '/api.php';
