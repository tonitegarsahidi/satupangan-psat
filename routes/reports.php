<?php

use App\Http\Controllers\LaporanPengaduanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Reports Routes
|--------------------------------------------------------------------------
|
| Routes for laporan pengaduan functionality
|
*/

Route::middleware('auth')->group(function () {
    // MANAGE LAPORAN PENGADUAN
    Route::prefix('/laporan-pengaduan')
        ->middleware('role:ROLE_USER')
        ->group(function () {
            Route::get('/', [LaporanPengaduanController::class, 'index'])->name('admin.laporan-pengaduan.index');
            Route::get('/add/new', [LaporanPengaduanController::class, 'create'])->name('admin.laporan-pengaduan.add');
            Route::post('/add/new', [LaporanPengaduanController::class, 'store'])->name('admin.laporan-pengaduan.store');
            Route::get('/detail/{id}', [LaporanPengaduanController::class, 'detail'])->name('admin.laporan-pengaduan.detail');
            Route::get('/workflow/{id}', [LaporanPengaduanController::class, 'detail'])->name('admin.laporan-pengaduan.workflow');
            Route::put('/edit/{id}', [LaporanPengaduanController::class, 'update'])->name('admin.laporan-pengaduan.update');
            Route::get('/edit/{id}', [LaporanPengaduanController::class, 'edit'])->name('admin.laporan-pengaduan.edit');
            Route::get('/delete/{id}', [LaporanPengaduanController::class, 'deleteConfirm'])->name('admin.laporan-pengaduan.delete');
            Route::delete('/delete/{id}', [LaporanPengaduanController::class, 'destroy'])->name('admin.laporan-pengaduan.destroy');
        });
});
