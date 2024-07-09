<?php 

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\API\CompanyController;
use App\Http\Controllers\API\PrecursorsController;
use App\Http\Middleware\EnsureUserIsActivated;
use App\Http\Controllers\API\RiskController;
use App\Http\Controllers\API\UserController;




Route::get('api/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::middleware('auth', EnsureUserIsActivated::class)->group(function () {
    Route::post('api/evaluations', [EvaluationController::class, 'store'])->name('evaluations.store');
    Route::get('api/company', [CompanyController::class, 'index'])->name('company.index');
    Route::post('api/precursors', [PrecursorsController::class, 'store'])->name('precursors.store');
    Route::delete('api/precursors', [PrecursorsController::class, 'delete'])->name('precursors.delete');
    Route::patch('api/precursors', [PrecursorsController::class, 'update'])->name('precursors.update');
    Route::get('api/risks', [RiskController::class, 'index'])->name('risk.index');
    Route::post('api/risks', [RiskController::class, 'store'])->name('risk.store');
    Route::put('api/risks/{id}', [RiskController::class, 'update'])->name('risk.update');
    Route::get('api/users', [UserController::class, 'index'])->name('users.index');

});