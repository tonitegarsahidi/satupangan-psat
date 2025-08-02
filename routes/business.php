<?php

use App\Http\Controllers\RegisterSppbController;
use App\Http\Controllers\RegisterIzinedarPsatplController;
use App\Http\Controllers\MasterPenangananController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Business Routes
|--------------------------------------------------------------------------
|
| Routes for business-specific functionality including SPPB registration,
| izin edar registration, and master penanganan
|
*/

Route::middleware('auth')->group(function () {
    // BUSINESS-ONLY ROUTES
    Route::middleware('role:ROLE_USER_BUSINESS,ROLE_OPERATOR,ROLE_SUPERVISOR,ROLE_ADMIN')->group(function () {
        // REGISTER SPPB CRUD FOR ROLE_USER_BUSINESS
        Route::prefix('/register-sppb')->group(function () {
            Route::get('/', [RegisterSppbController::class, 'index'])->name('register-sppb.index');
            Route::get('/add/new', [RegisterSppbController::class, 'create'])->name('register-sppb.add');
            Route::post('/add/new', [RegisterSppbController::class, 'store'])->name('register-sppb.store');
            Route::get('/detail/{id}', [RegisterSppbController::class, 'detail'])->name('register-sppb.detail');
            Route::put('/edit/{id}', [RegisterSppbController::class, 'update'])->name('register-sppb.update');
            Route::get('/edit/{id}', [RegisterSppbController::class, 'edit'])->name('register-sppb.edit');
            Route::get('/delete/{id}', [RegisterSppbController::class, 'deleteConfirm'])->name('register-sppb.delete');
            Route::delete('/delete/{id}', [RegisterSppbController::class, 'destroy'])->name('register-sppb.destroy');
        });

        // REGISTER IZIN EDAR PSATPL CRUD FOR ROLE_USER_BUSINESS
        Route::prefix('/register-izinedar-psatpl')->group(function () {
            Route::get('/', [RegisterIzinedarPsatplController::class, 'index'])->name('register-izinedar-psatpl.index');
            Route::get('/add/new', [RegisterIzinedarPsatplController::class, 'create'])->name('register-izinedar-psatpl.add');
            Route::post('/add/new', [RegisterIzinedarPsatplController::class, 'store'])->name('register-izinedar-psatpl.store');
            Route::get('/detail/{id}', [RegisterIzinedarPsatplController::class, 'detail'])->name('register-izinedar-psatpl.detail');
            Route::put('/edit/{id}', [RegisterIzinedarPsatplController::class, 'update'])->name('register-izinedar-psatpl.update');
            Route::get('/edit/{id}', [RegisterIzinedarPsatplController::class, 'edit'])->name('register-izinedar-psatpl.edit');
            Route::get('/delete/{id}', [RegisterIzinedarPsatplController::class, 'deleteConfirm'])->name('register-izinedar-psatpl.delete');
            Route::delete('/delete/{id}', [RegisterIzinedarPsatplController::class, 'destroy'])->name('register-izinedar-psatpl.destroy');
        });

        // MASTER PENANGANAN FOR ROLE_USER_BUSINESS
        Route::prefix('/master-penanganan')->group(function () {
            Route::get('/', [MasterPenangananController::class, 'index'])->name('master-penanganan.index');
            Route::get('/add/new', [MasterPenangananController::class, 'create'])->name('master-penanganan.add');
            Route::post('/add/new', [MasterPenangananController::class, 'store'])->name('master-penanganan.store');
            Route::get('/detail/{id}', [MasterPenangananController::class, 'detail'])->name('master-penanganan.detail');
            Route::put('/edit/{id}', [MasterPenangananController::class, 'update'])->name('master-penanganan.update');
            Route::get('/edit/{id}', [MasterPenangananController::class, 'edit'])->name('master-penanganan.edit');
            Route::get('/delete/{id}', [MasterPenangananController::class, 'deleteConfirm'])->name('master-penanganan.delete');
            Route::delete('/delete/{id}', [MasterPenangananController::class, 'destroy'])->name('master-penanganan.destroy');
        });
    });
});
