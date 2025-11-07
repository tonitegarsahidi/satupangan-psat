<?php

use App\Http\Controllers\PengawasanController;
use App\Http\Controllers\PengawasanRekapController;
use App\Http\Controllers\RekapPengawasanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Pengawasan Routes
|--------------------------------------------------------------------------
|
| Routes for pengawasan functionality including CRUD operations
|
*/

Route::middleware(['auth', 'role:ROLE_OPERATOR,ROLE_SUPERVISOR,ROLE_LEADER,ROLE_ADMIN'])->group(function () {
    // MANAGE PENGAWASAN
    Route::prefix('/pengawasan-data')
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
            Route::get('/get-pengawasan-data', [PengawasanRekapController::class, 'getPengawasanData'])->name('pengawasan-rekap.getPengawasanData');
        });

    // MANAGE PENGAWASAN TINDAKAN
    Route::prefix('/pengawasan-tindakan-utama')
        ->group(function () {
            Route::get('/', [\App\Http\Controllers\PengawasanTindakanController::class, 'index'])->name('pengawasan-tindakan.index');
            Route::get('/add/{pengawasanRekapId?}', [\App\Http\Controllers\PengawasanTindakanController::class, 'create'])->name('pengawasan-tindakan.add');
            Route::post('/add', [\App\Http\Controllers\PengawasanTindakanController::class, 'store'])->name('pengawasan-tindakan.store');
            Route::get('/detail/{id}', [\App\Http\Controllers\PengawasanTindakanController::class, 'detail'])->name('pengawasan-tindakan.detail');
            Route::get('/edit/{id}', [\App\Http\Controllers\PengawasanTindakanController::class, 'edit'])->name('pengawasan-tindakan.edit');
            Route::put('/edit/{id}', [\App\Http\Controllers\PengawasanTindakanController::class, 'update'])->name('pengawasan-tindakan.update');
            Route::get('/delete/{id}', [\App\Http\Controllers\PengawasanTindakanController::class, 'deleteConfirm'])->name('pengawasan-tindakan.delete');
            Route::delete('/delete/{id}', [\App\Http\Controllers\PengawasanTindakanController::class, 'destroy'])->name('pengawasan-tindakan.destroy');
            Route::get('/search', [\App\Http\Controllers\PengawasanTindakanController::class, 'search'])->name('pengawasan-tindakan.search');
        });

    // MANAGE PENGAWASAN TINDAKAN LANJUTAN
    Route::prefix('/pengawasan-tindakan-lanjutan')
        ->group(function () {
            Route::get('/', [\App\Http\Controllers\PengawasanTindakanLanjutanController::class, 'index'])->name('pengawasan-tindakan-lanjutan.index');
            Route::get('/add/{pengawasanTindakanId?}', [\App\Http\Controllers\PengawasanTindakanLanjutanController::class, 'create'])->name('pengawasan-tindakan-lanjutan.add');
            Route::post('/add', [\App\Http\Controllers\PengawasanTindakanLanjutanController::class, 'store'])->name('pengawasan-tindakan-lanjutan.store');
            Route::get('/detail/{id}', [\App\Http\Controllers\PengawasanTindakanLanjutanController::class, 'detail'])->name('pengawasan-tindakan-lanjutan.detail');
            Route::get('/edit/{id}', [\App\Http\Controllers\PengawasanTindakanLanjutanController::class, 'edit'])->name('pengawasan-tindakan-lanjutan.edit');
            Route::put('/edit/{id}', [\App\Http\Controllers\PengawasanTindakanLanjutanController::class, 'update'])->name('pengawasan-tindakan-lanjutan.update');
            Route::get('/delete/{id}', [\App\Http\Controllers\PengawasanTindakanLanjutanController::class, 'deleteConfirm'])->name('pengawasan-tindakan-lanjutan.delete');
            Route::delete('/delete/{id}', [\App\Http\Controllers\PengawasanTindakanLanjutanController::class, 'destroy'])->name('pengawasan-tindakan-lanjutan.destroy');
            Route::get('/search', [\App\Http\Controllers\PengawasanTindakanLanjutanController::class, 'search'])->name('pengawasan-tindakan-lanjutan.search');
        });
    // MANAGE REKAP PENGAWASAN
    Route::prefix('/rekap-pengawasan')
        ->group(function () {
            Route::get('/', [RekapPengawasanController::class, 'index'])->name('rekap-pengawasan.index');
        });
});
