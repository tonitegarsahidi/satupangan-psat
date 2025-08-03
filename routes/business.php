<?php

use App\Http\Controllers\RegisterSppbController;
use App\Http\Controllers\RegisterIzinedarPsatplController;
use App\Http\Controllers\RegisterIzinedarPsatpdController;
use App\Http\Controllers\RegisterIzinedarPsatpdukController;
use App\Http\Controllers\QrBadanPanganController;
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

        // REGISTER IZIN EDAR PSATPD CRUD FOR ROLE_USER_BUSINESS
        Route::prefix('/register-izinedar-psatpd')->group(function () {
            Route::get('/', [RegisterIzinedarPsatpdController::class, 'index'])->name('register-izinedar-psatpd.index');
            Route::get('/add/new', [RegisterIzinedarPsatpdController::class, 'create'])->name('register-izinedar-psatpd.add');
            Route::post('/add/new', [RegisterIzinedarPsatpdController::class, 'store'])->name('register-izinedar-psatpd.store');
            Route::get('/detail/{id}', [RegisterIzinedarPsatpdController::class, 'detail'])->name('register-izinedar-psatpd.detail');
            Route::put('/edit/{id}', [RegisterIzinedarPsatpdController::class, 'update'])->name('register-izinedar-psatpd.update');
            Route::get('/edit/{id}', [RegisterIzinedarPsatpdController::class, 'edit'])->name('register-izinedar-psatpd.edit');
            Route::get('/delete/{id}', [RegisterIzinedarPsatpdController::class, 'deleteConfirm'])->name('register-izinedar-psatpd.delete');
            Route::delete('/delete/{id}', [RegisterIzinedarPsatpdController::class, 'destroy'])->name('register-izinedar-psatpd.destroy');
        });

        // REGISTER IZIN EDAR PSATPDUK CRUD FOR ROLE_USER_BUSINESS
        Route::prefix('/register-izinedar-psat-pduk')->group(function () {
            Route::get('/', [RegisterIzinedarPsatpdukController::class, 'index'])->name('register-izinedar-psatpduk.index');
            Route::get('/add/new', [RegisterIzinedarPsatpdukController::class, 'create'])->name('register-izinedar-psatpduk.add');
            Route::post('/add/new', [RegisterIzinedarPsatpdukController::class, 'store'])->name('register-izinedar-psatpduk.store');
            Route::get('/detail/{id}', [RegisterIzinedarPsatpdukController::class, 'detail'])->name('register-izinedar-psatpduk.detail');
            Route::put('/edit/{id}', [RegisterIzinedarPsatpdukController::class, 'update'])->name('register-izinedar-psatpduk.update');
            Route::get('/edit/{id}', [RegisterIzinedarPsatpdukController::class, 'edit'])->name('register-izinedar-psatpduk.edit');
            Route::get('/delete/{id}', [RegisterIzinedarPsatpdukController::class, 'deleteConfirm'])->name('register-izinedar-psatpduk.delete');
            Route::delete('/delete/{id}', [RegisterIzinedarPsatpdukController::class, 'destroy'])->name('register-izinedar-psatpduk.destroy');
        });

        // QR BADAN PANGAN CRUD FOR ROLE_USER_BUSINESS
        Route::prefix('/qr-badan-pangan')->group(function () {
            Route::get('/', [QrBadanPanganController::class, 'index'])->name('qr-badan-pangan.index');
            Route::get('/add/new', [QrBadanPanganController::class, 'create'])->name('qr-badan-pangan.add');
            Route::post('/add/new', [QrBadanPanganController::class, 'store'])->name('qr-badan-pangan.store');
            Route::get('/detail/{id}', [QrBadanPanganController::class, 'detail'])->name('qr-badan-pangan.detail');
            Route::put('/edit/{id}', [QrBadanPanganController::class, 'update'])->name('qr-badan-pangan.update');
            Route::get('/edit/{id}', [QrBadanPanganController::class, 'edit'])->name('qr-badan-pangan.edit');
            Route::get('/delete/{id}', [QrBadanPanganController::class, 'deleteConfirm'])->name('qr-badan-pangan.delete');
            Route::delete('/delete/{id}', [QrBadanPanganController::class, 'destroy'])->name('qr-badan-pangan.destroy');
            Route::post('/update-status/{id}', [QrBadanPanganController::class, 'updateStatus'])->name('qr-badan-pangan.update-status');
            Route::post('/assign-user/{id}', [QrBadanPanganController::class, 'assignToUser'])->name('qr-badan-pangan.assign-user');
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
