<?php

use App\Http\Controllers\EarlyWarningController;
use Illuminate\Support\Facades\Route;

Route::prefix('/early-warning')
    ->middleware('role:ROLE_ADMIN,ROLE_SUPERVISOR,ROLE_LEADER,ROLE_OPERATOR')
    ->group(function () {
        Route::get('/', [\App\Http\Controllers\EarlyWarningController::class, 'index'])->name('early-warning.index');
        Route::get('/create', [\App\Http\Controllers\EarlyWarningController::class, 'create'])->name('early-warning.create');
        Route::post('/', [\App\Http\Controllers\EarlyWarningController::class, 'store'])->name('early-warning.store');
        Route::get('/detail/{id}', [\App\Http\Controllers\EarlyWarningController::class, 'detail'])->name('early-warning.detail');
        Route::get('/edit/{id}', [\App\Http\Controllers\EarlyWarningController::class, 'edit'])->name('early-warning.edit');
        Route::put('/update/{id}', [\App\Http\Controllers\EarlyWarningController::class, 'update'])->name('early-warning.update');
        Route::get('/delete-confirm/{id}', [\App\Http\Controllers\EarlyWarningController::class, 'deleteConfirm'])->name('early-warning.delete-confirm');
        Route::delete('/destroy/{id}', [\App\Http\Controllers\EarlyWarningController::class, 'destroy'])->name('early-warning.destroy');
        Route::post('/publish/{id}', [\App\Http\Controllers\EarlyWarningController::class, 'publishEarlyWarning'])->name('early-warning.publish');
    });
