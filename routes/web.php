<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RegistrationSteps;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Registration\RegistrationCompanyController;
use App\Http\Controllers\Registration\RegistrationRisksController;
use App\Http\Controllers\CompanyRisksController;
use App\Http\Controllers\CompanyRiskController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\API\CompanyController;
use App\Http\Controllers\API\PrecursorsController;
use App\Http\Controllers\Admin\UsersController;

use App\Http\Middleware\EnsureUserIsActivated;

use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Logged/Dashboard');
})->middleware(['auth', EnsureUserIsActivated::class, 'verified', RegistrationSteps::class])->name('dashboard');


Route::middleware('auth', EnsureUserIsActivated::class)->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth', EnsureUserIsActivated::class)->group(function () {
    Route::get('/register/company', [RegistrationCompanyController::class, 'display'])->name('register.company');
    Route::post('/register/company', [RegistrationCompanyController::class, 'store'])->name('register.company.store');
    Route::get('/register/risks', [RegistrationRisksController::class, 'index'])->name('register.risks.index');
    Route::post('/register/risks', [RegistrationRisksController::class, 'store'])->name('register.risks.store');
    Route::patch('/register/risks', [RegistrationRisksController::class, 'update'])->name('register.risks.update');
    Route::post('/register/risks/validate', [RegistrationRisksController::class, 'validate'])->name('register.risks.validate');
});

Route::middleware('auth', EnsureUserIsActivated::class)->group(function () {
    Route::get('/risks', [CompanyRisksController::class, 'display'])->name('risks');
    Route::get('/risks/{id}', [CompanyRiskController::class, 'display'])->name('risks.show');
});


Route::middleware('auth', EnsureUserIsActivated::class)->group(function () {
    Route::get('/admin/users', [UsersController::class, 'index'])->name('admin.users');
    Route::post('/admin/users', [UsersController::class, 'store'])->name('admin.users.store');
    Route::patch('/admin/users', [UsersController::class, 'update'])->name('admin.users.update');
});


Route::get('api/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::middleware('auth', EnsureUserIsActivated::class)->group(function () {
    Route::post('api/evaluations', [EvaluationController::class, 'store'])->name('evaluations.store');
    Route::get('api/company', [CompanyController::class, 'index'])->name('company.index');
    Route::post('api/precursors', [PrecursorsController::class, 'store'])->name('precursors.store');
    Route::delete('api/precursors', [PrecursorsController::class, 'delete'])->name('precursors.delete');
    Route::patch('api/precursors', [PrecursorsController::class, 'update'])->name('precursors.update');
});

require __DIR__.'/auth.php';