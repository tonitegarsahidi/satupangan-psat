<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Registration Routes
|--------------------------------------------------------------------------
|
| Routes for user registration functionality
|
*/

// Register List Page
Route::get('/register-list', function () {
    return view('admin.auth.register-list');
})->name('register.list');

// Register Business
Route::get('/register-business', [RegisteredUserController::class, 'createBusiness'])->name('register-business');
Route::post('/register-business', [RegisteredUserController::class, 'storeBusiness']);

// Register Petugas
Route::get('/register-petugas', [RegisteredUserController::class, 'createPetugas'])->name('register-petugas');
Route::post('/register-petugas', [RegisteredUserController::class, 'storePetugas'])->name('register-petugas-add');
