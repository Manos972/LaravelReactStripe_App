<?php

use App\Http\Controllers\Feature1Controller;
use App\Http\Controllers\Feature2Controller;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransacController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
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
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/buy-credits/webhook',[TransacController::class,'webhook'])->name('credits.webhook');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/feature1', [Feature1Controller::class, 'index'])->name('feature1.index');
    Route::post('/feature1', [Feature1Controller::class, 'calculate'])->name('feature1.calculate');

    Route::get('/feature2', [Feature2Controller::class, 'index'])->name('feature2.index');
    Route::post('/feature2', [Feature2Controller::class, 'calculate'])->name('feature2.calculate');

    Route::get('/buy-credits', [TransacController::class, 'index'])->name('credits.index');
    Route::get('/buy-credits/success', [TransacController::class, 'success'])->name('credits.success');
    Route::get('/buy-credits/cancel', [TransacController::class, 'cancel'])->name('credits.cancel');
    Route::post('/buy-credits/{package}', [TransacController::class, 'buyCredits'])->name('credits.buy');

});

require __DIR__.'/auth.php';
