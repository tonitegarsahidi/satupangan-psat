<?php

use App\Http\Controllers\SurveilanController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('notifikasi-surveilan')->group(function () {
        Route::get('/', [SurveilanController::class, 'index'])->name('surveilan.index');
    });
});
