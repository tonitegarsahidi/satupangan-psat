<?php

use App\Http\Controllers\LaporanPengaduanController;
use App\Http\Controllers\LaporanPengaduanWorkflowController;
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
        ->middleware('role:ROLE_USER,ROLE_KANTOR')
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

    // MANAGE LAPORAN PENGADUAN WORKFLOW
    Route::prefix('/laporan-pengaduan-workflow')
        ->middleware('role:ROLE_USER,ROLE_KANTOR')
        ->group(function () {
            Route::get('/', [LaporanPengaduanWorkflowController::class, 'index'])->name('admin.laporan-pengaduan-workflow.index');
            Route::get('/add/new', [LaporanPengaduanWorkflowController::class, 'create'])->name('admin.laporan-pengaduan-workflow.add');
            Route::post('/add/new', [LaporanPengaduanWorkflowController::class, 'store'])->name('admin.laporan-pengaduan-workflow.store');
            Route::get('/detail/{id}', [LaporanPengaduanWorkflowController::class, 'detail'])->name('admin.laporan-pengaduan-workflow.detail');
            Route::put('/edit/{id}', [LaporanPengaduanWorkflowController::class, 'update'])->name('admin.laporan-pengaduan-workflow.update');
            Route::get('/edit/{id}', [LaporanPengaduanWorkflowController::class, 'edit'])->name('admin.laporan-pengaduan-workflow.edit');
            Route::get('/delete/{id}', [LaporanPengaduanWorkflowController::class, 'deleteConfirm'])->name('admin.laporan-pengaduan-workflow.delete');
            Route::delete('/delete/{id}', [LaporanPengaduanWorkflowController::class, 'destroy'])->name('admin.laporan-pengaduan-workflow.destroy');
            // Additional routes for workflow statistics
            Route::get('/statistics', [LaporanPengaduanWorkflowController::class, 'statistics'])->name('admin.laporan-pengaduan-workflow.statistics');
            // Route for getting workflow entries by laporan pengaduan ID
            Route::get('/by-laporan/{laporanId}', [LaporanPengaduanWorkflowController::class, 'getByLaporanId'])->name('admin.laporan-pengaduan-workflow.by-laporan');
        });
});
