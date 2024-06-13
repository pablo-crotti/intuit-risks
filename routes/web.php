<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
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
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/risks', function () {
    return Inertia::render('Logged/Risks');
})->middleware(['auth', 'verified'])->name('risks');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::get('/test', function () {
    return Inertia::render('Logged/TestPage');
})->middleware(['auth', 'verified'])->name('test');



Route::get('api/categories', [CategoryController::class, 'index'])->name('categories.index');






require __DIR__.'/auth.php';
