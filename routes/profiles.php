<?php

use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\PetugasProfileController;
use App\Http\Controllers\BusinessProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
|
| Routes for user profiles, business profiles, and petugas profiles
|
*/

Route::middleware('auth')->group(function () {
    // USER PROFILE SETTING
    Route::get('/profile', [UserProfileController::class, 'index'])->name('user.profile.index');
    Route::put('/profile', [UserProfileController::class, 'updateOrCreate'])->name('user.profile.update');
    Route::get('/profile/kota-by-provinsi/{provinsiId}', [UserProfileController::class, 'getKotaByProvinsi'])->name('user.profile.kota_by_provinsi');

    // BUSINESS PROFILE SETTING
    Route::middleware('role:ROLE_USER_BUSINESS')->group(function () {
        Route::get('/profil-bisnis', [BusinessProfileController::class, 'index'])->name('business.profile.index');
        Route::put('/profil-bisnis', [BusinessProfileController::class, 'updateBusiness'])->name('business.profile.update');
        Route::get('/profil-bisnis/kota-by-provinsi/{provinsiId}', [BusinessProfileController::class, 'getKotaByProvinsi'])->name('business.profile.kota_by_provinsi');
    });

    // PETUGAS PROFILE SETTING
    Route::middleware('role:ROLE_OPERATOR,ROLE_SUPERVISOR,ROLE_LEADER,ROLE_ADMIN')->group(function () {
        Route::get('/data-petugas', [PetugasProfileController::class, 'index'])->name('petugas.profile.index');
        Route::put('/data-petugas', [PetugasProfileController::class, 'updateOrCreate'])->name('petugas.profile.update');
        Route::get('/data-petugas/kota-by-provinsi/{provinsiId}', [PetugasProfileController::class, 'getKotaByProvinsi'])->name('petugas.profile.kota_by_provinsi');
        Route::get('/detail-petugas/{userId}', [PetugasProfileController::class, 'detail'])->name('petugas.profile.detail');
    });
});

// Non-authenticated route for registration
Route::get('/register/kota-by-provinsi/{provinsiId}', [UserProfileController::class, 'getKotaByProvinsi'])->name('register.kota_by_provinsi');

// Non-authenticated route for produk psat by jenis psat
Route::get('/register/produk-psat-by-jenis/{jenisId}', [UserProfileController::class, 'getProdukPsatByJenis'])->name('register.produk_psat_by_jenis');
