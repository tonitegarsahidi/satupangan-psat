<?php

use App\Http\Controllers\PengawasanController;
use App\Http\Controllers\PengawasanRekapController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Pengawasan Routes
|--------------------------------------------------------------------------
|
| Routes for pengawasan functionality including CRUD operations
|
*/

Route::middleware(['auth', 'role:ROLE_OPERATOR,ROLE_SUPERVISOR,ROLE_LEADER'])->group(function () {
    // MANAGE PENGAWASAN
    Route::prefix('/pengawasan')
        ->group(function () {
            Route::get('/', [PengawasanController::class, 'index'])->name('pengawasan.index');
            Route::get('/add', [PengawasanController::class, 'create'])->name('pengawasan.add');
            Route::post('/add', [PengawasanController::class, 'store'])->name('pengawasan.store');
            Route::get('/detail/{id}', [PengawasanController::class, 'detail'])->name('pengawasan.detail');
            Route::get('/edit/{id}', [PengawasanController::class, 'edit'])->name('pengawasan.edit');
            Route::put('/edit/{id}', [PengawasanController::class, 'update'])->name('pengawasan.update');
            Route::get('/delete/{id}', [PengawasanController::class, 'deleteConfirm'])->name('pengawasan.delete');
            Route::delete('/delete/{id}', [PengawasanController::class, 'destroy'])->name('pengawasan.destroy');
            Route::get('/search', [PengawasanController::class, 'search'])->name('pengawasan.search');
        });

    // MANAGE PENGAWASAN REKAP
    Route::prefix('/pengawasan-rekap')
        ->group(function () {
            Route::get('/', [PengawasanRekapController::class, 'index'])->name('pengawasan-rekap.index');
            Route::get('/add', [PengawasanRekapController::class, 'create'])->name('pengawasan-rekap.add');
            Route::post('/add', [PengawasanRekapController::class, 'store'])->name('pengawasan-rekap.store');
            Route::get('/detail/{id}', [PengawasanRekapController::class, 'detail'])->name('pengawasan-rekap.detail');
            Route::get('/edit/{id}', [PengawasanRekapController::class, 'edit'])->name('pengawasan-rekap.edit');
            Route::put('/edit/{id}', [PengawasanRekapController::class, 'update'])->name('pengawasan-rekap.update');
            Route::get('/delete/{id}', [PengawasanRekapController::class, 'deleteConfirm'])->name('pengawasan-rekap.delete');
            Route::delete('/delete/{id}', [PengawasanRekapController::class, 'destroy'])->name('pengawasan-rekap.destroy');
            Route::get('/search', [PengawasanRekapController::class, 'search'])->name('pengawasan-rekap.search');
        });
});
