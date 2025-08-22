<?php

use App\Http\Controllers\EarlyWarningController;
use Illuminate\Support\Facades\Route;

// Early Warning Routes
Route::prefix('early-warning')->name('early-warning.')->group(function () {
    Route::get('/', [EarlyWarningController::class, 'index'])->name('index');
    Route::get('/create', [EarlyWarningController::class, 'create'])->name('create');
    Route::post('/', [EarlyWarningController::class, 'store'])->name('store');
    Route::get('/detail/{id}', [EarlyWarningController::class, 'detail'])->name('detail');
    Route::get('/edit/{id}', [EarlyWarningController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [EarlyWarningController::class, 'update'])->name('update');
    Route::get('/delete-confirm/{id}', [EarlyWarningController::class, 'deleteConfirm'])->name('delete-confirm');
    Route::delete('/destroy/{id}', [EarlyWarningController::class, 'destroy'])->name('destroy');
});
