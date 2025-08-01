<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SampleController;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Demo and Sample Routes
|--------------------------------------------------------------------------
|
| Routes for demo functionality and sample UI pages
|
*/

Route::middleware('auth')->group(function () {
    // Dashboard route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // SAMPLE UI
    Route::prefix('/sample')
        ->middleware('role:ROLE_USER')
        ->group(function () {
            Route::get('cards', [SampleController::class, 'cards'])->name('sample.cards');
            Route::get('table', [SampleController::class, 'tablePage'])->name('sample.table');
            Route::get('form1', [SampleController::class, 'formPage1'])->name('sample.form1');
            Route::get('form2', [SampleController::class, 'formPage2'])->name('sample.form2');
            Route::get('textdivider', [SampleController::class, 'textDivider'])->name('sample.textdivider');
            Route::get('blank', [SampleController::class, 'blank'])->name('sample.blank');
        });

    // User page (demo of role-based access)
    Route::get('/user-page', [UserController::class, 'userOnlyPage'])->name('user-page')->middleware('role:ROLE_USER');

    // Demo routes
    Route::prefix('/demo')
        ->middleware('role:ROLE_USER')
        ->group(function () {
            // Only users which has the 'ROLE_USER'can access this route
            Route::get('/', [DemoController::class, 'index'])->name('demo');
            Route::get('/print', [DemoController::class, 'print'])->name('demo.print');
        });
});
