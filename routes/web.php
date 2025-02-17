<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasterData\RoleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MasterData\UserController;
use App\Http\Controllers\System\NavigationsController;
use App\Http\Controllers\System\PermissionController;
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


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('dashboard', DashboardController::class)->middleware('check_access');

    Route::prefix('master-data')->as('master-data.')->group(function() {
        Route::resource('users', UserController::class)->middleware('check_access');
        Route::resource('roles', RoleController::class)->middleware('check_access');
    });

    Route::prefix('system')->as('system.')->group(function() {
        Route::resource('permissions', PermissionController::class)->middleware('check_access');
        Route::resource('navigation-menu', NavigationsController::class)->middleware('check_access');
    });
});

require __DIR__.'/auth.php';
