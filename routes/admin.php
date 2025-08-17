<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\MasterProvinsiController;
use App\Http\Controllers\MasterKelompokPanganController;
use App\Http\Controllers\MasterJenisPanganSegarController;
use App\Http\Controllers\MasterBahanPanganSegarController;
use App\Http\Controllers\MasterPenangananController;
use App\Http\Controllers\WorkflowController;
use App\Http\Controllers\WorkflowActionController;
use App\Http\Controllers\WorkflowThreadController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Routes for admin functionality including user management, master data,
| and workflow management
|
*/

Route::middleware('auth')->group(function () {
    // QR Badan Pangan detail route for all roles needing access
    Route::get('/qr-badan-pangan/{id}', [\App\Http\Controllers\QrBadanPanganController::class, 'show'])->name('qr-badan-pangan.show');
    // Register SPPB detail route for all roles needing access
    Route::get('/register-sppb/{id}', [\App\Http\Controllers\RegisterSppbController::class, 'show'])->name('register-sppb.show');
    // Register IZIN EDAR PL detail route for all roles needing access
    Route::get('/register-izinedar-psatpl/{id}', [\App\Http\Controllers\RegisterIzinedarPsatplController::class, 'show'])->name('register-izinedar-psatpl.show');
    // Register IZIN EDAR PD detail route for all roles needing access
    Route::get('/register-izinedar-psatpd/{id}', [\App\Http\Controllers\RegisterIzinedarPsatpdController::class, 'show'])->name('register-izinedar-psatpd.show');
    // Register IZIN EDAR PDUK detail route for all roles needing access
    Route::get('/register-izinedar-psatpduk/{id}', [\App\Http\Controllers\RegisterIzinedarPsatpdukController::class, 'show'])->name('register-izinedar-psatpduk.show');

    // Admin-only pages
    Route::get('/admin-page', [AdminController::class, 'index'])->name('admin-page')->middleware('role:ROLE_ADMIN');
    Route::get('/operator-page', [OperatorController::class, 'index'])->name('operator-page')->middleware('role:ROLE_OPERATOR');
    Route::get('/supervisor-page', [SupervisorController::class, 'index'])->name('supervisor-page')->middleware('role:ROLE_SUPERVISOR');

    // Only users with the 'ROLE_ADMIN' can access this route group
    Route::prefix('/admin')
        ->middleware('role:ROLE_ADMIN')
        ->group(function () {

            // Admin Dashboard
            Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');

            // MANAGE USERS ON SYSTEM
            Route::get('/user', [UserController::class, 'index'])->name('admin.user.index');
            Route::get('/user/add/new', [UserController::class, 'create'])->name('admin.user.add');
            Route::post('/user/add/new', [UserController::class, 'store'])->name('admin.user.store');
            Route::get('/user/detail/{id}', [UserController::class, 'detail'])->name('admin.user.detail');
            Route::put('/user/edit/{id}', [UserController::class, 'update'])->name('admin.user.update');
            Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('admin.user.edit');
            Route::get('/user/delete/{id}', [UserController::class, 'deleteConfirm'])->name('admin.user.delete');
            Route::delete('/user/delete/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy');
            Route::get('/user/search', [UserController::class, 'search'])->name('admin.users.search');

            // MANAGE PROVINSI
            Route::prefix('/master-provinsi')
                ->group(function () {
                    Route::get('/', [MasterProvinsiController::class, 'index'])->name('admin.master-provinsi.index');
                    Route::get('/add/new', [MasterProvinsiController::class, 'create'])->name('admin.master-provinsi.add');
                    Route::post('/add/new', [MasterProvinsiController::class, 'store'])->name('admin.master-provinsi.store');
                    Route::get('/detail/{id}', [MasterProvinsiController::class, 'detail'])->name('admin.master-provinsi.detail');
                    Route::put('/edit/{id}', [MasterProvinsiController::class, 'update'])->name('admin.master-provinsi.update');
                    Route::get('/edit/{id}', [MasterProvinsiController::class, 'edit'])->name('admin.master-provinsi.edit');
                    Route::get('/delete/{id}', [MasterProvinsiController::class, 'deleteConfirm'])->name('admin.master-provinsi.delete');
                    Route::delete('/delete/{id}', [MasterProvinsiController::class, 'destroy'])->name('admin.master-provinsi.destroy');
                });

            // MANAGE CEMARAN MIKROBA
            Route::prefix('/master-cemaran-mikroba')
                ->group(function () {
                    Route::get('/', [\App\Http\Controllers\MasterCemaranMikrobaController::class, 'index'])->name('admin.master-cemaran-mikroba.index');
                    Route::get('/add/new', [\App\Http\Controllers\MasterCemaranMikrobaController::class, 'create'])->name('admin.master-cemaran-mikroba.add');
                    Route::post('/add/new', [\App\Http\Controllers\MasterCemaranMikrobaController::class, 'store'])->name('admin.master-cemaran-mikroba.store');
                    Route::get('/detail/{id}', [\App\Http\Controllers\MasterCemaranMikrobaController::class, 'detail'])->name('admin.master-cemaran-mikroba.detail');
                    Route::put('/edit/{id}', [\App\Http\Controllers\MasterCemaranMikrobaController::class, 'update'])->name('admin.master-cemaran-mikroba.update');
                    Route::get('/edit/{id}', [\App\Http\Controllers\MasterCemaranMikrobaController::class, 'edit'])->name('admin.master-cemaran-mikroba.edit');
                    Route::get('/delete/{id}', [\App\Http\Controllers\MasterCemaranMikrobaController::class, 'deleteConfirm'])->name('admin.master-cemaran-mikroba.delete');
                    Route::delete('/delete/{id}', [\App\Http\Controllers\MasterCemaranMikrobaController::class, 'destroy'])->name('admin.master-cemaran-mikroba.destroy');
                });

            // MANAGE CEMARAN PESTISIDA
            Route::prefix('/master-cemaran-pestisida')
                ->group(function () {
                    Route::get('/', [\App\Http\Controllers\MasterCemaranPestisidaController::class, 'index'])->name('admin.master-cemaran-pestisida.index');
                    Route::get('/add/new', [\App\Http\Controllers\MasterCemaranPestisidaController::class, 'create'])->name('admin.master-cemaran-pestisida.add');
                    Route::post('/add/new', [\App\Http\Controllers\MasterCemaranPestisidaController::class, 'store'])->name('admin.master-cemaran-pestisida.store');
                    Route::get('/detail/{id}', [\App\Http\Controllers\MasterCemaranPestisidaController::class, 'detail'])->name('admin.master-cemaran-pestisida.detail');
                    Route::put('/edit/{id}', [\App\Http\Controllers\MasterCemaranPestisidaController::class, 'update'])->name('admin.master-cemaran-pestisida.update');
                    Route::get('/edit/{id}', [\App\Http\Controllers\MasterCemaranPestisidaController::class, 'edit'])->name('admin.master-cemaran-pestisida.edit');
                    Route::get('/delete/{id}', [\App\Http\Controllers\MasterCemaranPestisidaController::class, 'deleteConfirm'])->name('admin.master-cemaran-pestisida.delete');
                    Route::delete('/delete/{id}', [\App\Http\Controllers\MasterCemaranPestisidaController::class, 'destroy'])->name('admin.master-cemaran-pestisida.destroy');
                });

            // MANAGE KELOMPOK PANGAN
            Route::prefix('/master-kelompok-pangan')
                ->group(function () {
                    Route::get('/', [MasterKelompokPanganController::class, 'index'])->name('admin.master-kelompok-pangan.index');
                    Route::get('/add/new', [MasterKelompokPanganController::class, 'create'])->name('admin.master-kelompok-pangan.add');
                    Route::post('/add/new', [MasterKelompokPanganController::class, 'store'])->name('admin.master-kelompok-pangan.store');
                    Route::get('/detail/{id}', [MasterKelompokPanganController::class, 'detail'])->name('admin.master-kelompok-pangan.detail');
                    Route::put('/edit/{id}', [MasterKelompokPanganController::class, 'update'])->name('admin.master-kelompok-pangan.update');
                    Route::get('/edit/{id}', [MasterKelompokPanganController::class, 'edit'])->name('admin.master-kelompok-pangan.edit');
                    Route::get('/delete/{id}', [MasterKelompokPanganController::class, 'deleteConfirm'])->name('admin.master-kelompok-pangan.delete');
                    Route::delete('/delete/{id}', [MasterKelompokPanganController::class, 'destroy'])->name('admin.master-kelompok-pangan.destroy');
                });

            // MANAGE JENIS PANGAN SEGAR
            Route::prefix('/master-jenis-pangan-segar')
                ->group(function () {
                    Route::get('/', [MasterJenisPanganSegarController::class, 'index'])->name('admin.master-jenis-pangan-segar.index');
                    Route::get('/add/new', [MasterJenisPanganSegarController::class, 'create'])->name('admin.master-jenis-pangan-segar.add');
                    Route::post('/add/new', [MasterJenisPanganSegarController::class, 'store'])->name('admin.master-jenis-pangan-segar.store');
                    Route::get('/detail/{id}', [MasterJenisPanganSegarController::class, 'detail'])->name('admin.master-jenis-pangan-segar.detail');
                    Route::put('/edit/{id}', [MasterJenisPanganSegarController::class, 'update'])->name('admin.master-jenis-pangan-segar.update');
                    Route::get('/edit/{id}', [MasterJenisPanganSegarController::class, 'edit'])->name('admin.master-jenis-pangan-segar.edit');
                    Route::get('/delete/{id}', [MasterJenisPanganSegarController::class, 'deleteConfirm'])->name('admin.master-jenis-pangan-segar.delete');
                    Route::delete('/delete/{id}', [MasterJenisPanganSegarController::class, 'destroy'])->name('admin.master-jenis-pangan-segar.destroy');
                });

            // MANAGE BAHAN PANGAN SEGAR
            Route::prefix('/master-bahan-pangan-segar')
                ->group(function () {
                    Route::get('/', [MasterBahanPanganSegarController::class, 'index'])->name('admin.master-bahan-pangan-segar.index');
                    Route::get('/add/new', [MasterBahanPanganSegarController::class, 'create'])->name('admin.master-bahan-pangan-segar.add');
                    Route::post('/add/new', [MasterBahanPanganSegarController::class, 'store'])->name('admin.master-bahan-pangan-segar.store');
                    Route::get('/detail/{id}', [MasterBahanPanganSegarController::class, 'detail'])->name('admin.master-bahan-pangan-segar.detail');
                    Route::put('/edit/{id}', [MasterBahanPanganSegarController::class, 'update'])->name('admin.master-bahan-pangan-segar.update');
                    Route::get('/edit/{id}', [MasterBahanPanganSegarController::class, 'edit'])->name('admin.master-bahan-pangan-segar.edit');
                    Route::get('/delete/{id}', [MasterBahanPanganSegarController::class, 'deleteConfirm'])->name('admin.master-bahan-pangan-segar.delete');
                    Route::delete('/delete/{id}', [MasterBahanPanganSegarController::class, 'destroy'])->name('admin.master-bahan-pangan-segar.destroy');
                });

            // MANAGE CEMARAN LOGAM BERAT
            Route::prefix('/master-cemaran-logam-berat')
                ->group(function () {
                    Route::get('/', [\App\Http\Controllers\MasterCemaranLogamBeratController::class, 'index'])->name('admin.master-cemaran-logam-berat.index');
                    Route::get('/add/new', [\App\Http\Controllers\MasterCemaranLogamBeratController::class, 'create'])->name('admin.master-cemaran-logam-berat.add');
                    Route::post('/add/new', [\App\Http\Controllers\MasterCemaranLogamBeratController::class, 'store'])->name('admin.master-cemaran-logam-berat.store');
                    Route::get('/detail/{id}', [\App\Http\Controllers\MasterCemaranLogamBeratController::class, 'detail'])->name('admin.master-cemaran-logam-berat.detail');
                    Route::put('/edit/{id}', [\App\Http\Controllers\MasterCemaranLogamBeratController::class, 'update'])->name('admin.master-cemaran-logam-berat.update');
                    Route::get('/edit/{id}', [\App\Http\Controllers\MasterCemaranLogamBeratController::class, 'edit'])->name('admin.master-cemaran-logam-berat.edit');
                    Route::get('/delete/{id}', [\App\Http\Controllers\MasterCemaranLogamBeratController::class, 'deleteConfirm'])->name('admin.master-cemaran-logam-berat.delete');
                    Route::delete('/delete/{id}', [\App\Http\Controllers\MasterCemaranLogamBeratController::class, 'destroy'])->name('admin.master-cemaran-logam-berat.destroy');
                });

            // MANAGE BATAS CEMARAN LOGAM BERAT
            Route::prefix('/batas-cemaran-logam-berat')
                ->group(function () {
                    Route::get('/', [\App\Http\Controllers\BatasCemaranLogamBeratController::class, 'index'])->name('admin.batas-cemaran-logam-berat.index');
                    Route::get('/add/new', [\App\Http\Controllers\BatasCemaranLogamBeratController::class, 'create'])->name('admin.batas-cemaran-logam-berat.add');
                    Route::post('/add/new', [\App\Http\Controllers\BatasCemaranLogamBeratController::class, 'store'])->name('admin.batas-cemaran-logam-berat.store');
                    Route::get('/detail/{id}', [\App\Http\Controllers\BatasCemaranLogamBeratController::class, 'detail'])->name('admin.batas-cemaran-logam-berat.detail');
                    Route::put('/edit/{id}', [\App\Http\Controllers\BatasCemaranLogamBeratController::class, 'update'])->name('admin.batas-cemaran-logam-berat.update');
                    Route::get('/edit/{id}', [\App\Http\Controllers\BatasCemaranLogamBeratController::class, 'edit'])->name('admin.batas-cemaran-logam-berat.edit');
                    Route::get('/delete/{id}', [\App\Http\Controllers\BatasCemaranLogamBeratController::class, 'deleteConfirm'])->name('admin.batas-cemaran-logam-berat.delete');
                    Route::delete('/delete/{id}', [\App\Http\Controllers\BatasCemaranLogamBeratController::class, 'destroy'])->name('admin.batas-cemaran-logam-berat.destroy');
                });

            // MANAGE CEMARAN MIKROTOKSIN
            Route::prefix('/master-cemaran-mikrotoksin')
                ->group(function () {
                    Route::get('/', [\App\Http\Controllers\MasterCemaranMikrotoksinController::class, 'index'])->name('admin.master-cemaran-mikrotoksin.index');
                    Route::get('/add/new', [\App\Http\Controllers\MasterCemaranMikrotoksinController::class, 'create'])->name('admin.master-cemaran-mikrotoksin.add');
                    Route::post('/add/new', [\App\Http\Controllers\MasterCemaranMikrotoksinController::class, 'store'])->name('admin.master-cemaran-mikrotoksin.store');
                    Route::get('/detail/{id}', [\App\Http\Controllers\MasterCemaranMikrotoksinController::class, 'detail'])->name('admin.master-cemaran-mikrotoksin.detail');
                    Route::put('/edit/{id}', [\App\Http\Controllers\MasterCemaranMikrotoksinController::class, 'update'])->name('admin.master-cemaran-mikrotoksin.update');
                    Route::get('/edit/{id}', [\App\Http\Controllers\MasterCemaranMikrotoksinController::class, 'edit'])->name('admin.master-cemaran-mikrotoksin.edit');
                    Route::get('/delete/{id}', [\App\Http\Controllers\MasterCemaranMikrotoksinController::class, 'deleteConfirm'])->name('admin.master-cemaran-mikrotoksin.delete');
                    Route::delete('/delete/{id}', [\App\Http\Controllers\MasterCemaranMikrotoksinController::class, 'destroy'])->name('admin.master-cemaran-mikrotoksin.destroy');
                });

            // MANAGE BATAS CEMARAN MIKROBA
            Route::prefix('/batas-cemaran-mikroba')
                ->group(function () {
                    Route::get('/', [\App\Http\Controllers\BatasCemaranMikrobaController::class, 'index'])->name('admin.batas-cemaran-mikroba.index');
                    Route::get('/add/new', [\App\Http\Controllers\BatasCemaranMikrobaController::class, 'create'])->name('admin.batas-cemaran-mikroba.add');
                    Route::post('/add/new', [\App\Http\Controllers\BatasCemaranMikrobaController::class, 'store'])->name('admin.batas-cemaran-mikroba.store');
                    Route::get('/detail/{id}', [\App\Http\Controllers\BatasCemaranMikrobaController::class, 'detail'])->name('admin.batas-cemaran-mikroba.detail');
                    Route::put('/edit/{id}', [\App\Http\Controllers\BatasCemaranMikrobaController::class, 'update'])->name('admin.batas-cemaran-mikroba.update');
                    Route::get('/edit/{id}', [\App\Http\Controllers\BatasCemaranMikrobaController::class, 'edit'])->name('admin.batas-cemaran-mikroba.edit');
                    Route::get('/delete/{id}', [\App\Http\Controllers\BatasCemaranMikrobaController::class, 'deleteConfirm'])->name('admin.batas-cemaran-mikroba.delete');
                    Route::delete('/delete/{id}', [\App\Http\Controllers\BatasCemaranMikrobaController::class, 'destroy'])->name('admin.batas-cemaran-mikroba.destroy');
                });

            // MANAGE BATAS CEMARAN MIKROTOKSIN
            Route::prefix('/batas-cemaran-mikrotoksin')
                ->group(function () {
                    Route::get('/', [\App\Http\Controllers\BatasCemaranMikrotoksinController::class, 'index'])->name('admin.batas-cemaran-mikrotoksin.index');
                    Route::get('/add/new', [\App\Http\Controllers\BatasCemaranMikrotoksinController::class, 'create'])->name('admin.batas-cemaran-mikrotoksin.add');
                    Route::post('/add/new', [\App\Http\Controllers\BatasCemaranMikrotoksinController::class, 'store'])->name('admin.batas-cemaran-mikrotoksin.store');
                    Route::get('/detail/{id}', [\App\Http\Controllers\BatasCemaranMikrotoksinController::class, 'detail'])->name('admin.batas-cemaran-mikrotoksin.detail');
                    Route::put('/edit/{id}', [\App\Http\Controllers\BatasCemaranMikrotoksinController::class, 'update'])->name('admin.batas-cemaran-mikrotoksin.update');
                    Route::get('/edit/{id}', [\App\Http\Controllers\BatasCemaranMikrotoksinController::class, 'edit'])->name('admin.batas-cemaran-mikrotoksin.edit');
                    Route::get('/delete/{id}', [\App\Http\Controllers\BatasCemaranMikrotoksinController::class, 'deleteConfirm'])->name('admin.batas-cemaran-mikrotoksin.delete');
                    Route::delete('/delete/{id}', [\App\Http\Controllers\BatasCemaranMikrotoksinController::class, 'destroy'])->name('admin.batas-cemaran-mikrotoksin.destroy');
                });

            // MANAGE MASTER PENANGANAN
            Route::prefix('/master-penanganan')
                ->group(function () {
                    Route::get('/', [MasterPenangananController::class, 'index'])->name('admin.master-penanganan.index');
                    Route::get('/add/new', [MasterPenangananController::class, 'create'])->name('admin.master-penanganan.add');
                    Route::post('/add/new', [MasterPenangananController::class, 'store'])->name('admin.master-penanganan.store');
                    Route::get('/detail/{id}', [MasterPenangananController::class, 'detail'])->name('admin.master-penanganan.detail');
                    Route::put('/edit/{id}', [MasterPenangananController::class, 'update'])->name('admin.master-penanganan.update');
                    Route::get('/edit/{id}', [MasterPenangananController::class, 'edit'])->name('admin.master-penanganan.edit');
                    Route::get('/delete/{id}', [MasterPenangananController::class, 'deleteConfirm'])->name('admin.master-penanganan.delete');
                    Route::delete('/delete/{id}', [MasterPenangananController::class, 'destroy'])->name('admin.master-penanganan.destroy');
                });

            // MANAGE KOTA
            Route::prefix('/master-kota')
                ->group(function () {
                    Route::get('/', [\App\Http\Controllers\MasterKotaController::class, 'index'])->name('admin.master-kota.index');
                    Route::get('/add/new', [\App\Http\Controllers\MasterKotaController::class, 'create'])->name('admin.master-kota.add');
                    Route::post('/add/new', [\App\Http\Controllers\MasterKotaController::class, 'store'])->name('admin.master-kota.store');
                    Route::get('/detail/{id}', [\App\Http\Controllers\MasterKotaController::class, 'detail'])->name('admin.master-kota.detail');
                    Route::put('/edit/{id}', [\App\Http\Controllers\MasterKotaController::class, 'update'])->name('admin.master-kota.update');
                    Route::get('/edit/{id}', [\App\Http\Controllers\MasterKotaController::class, 'edit'])->name('admin.master-kota.edit');
                    Route::get('/delete/{id}', [\App\Http\Controllers\MasterKotaController::class, 'deleteConfirm'])->name('admin.master-kota.delete');
                    Route::delete('/delete/{id}', [\App\Http\Controllers\MasterKotaController::class, 'destroy'])->name('admin.master-kota.destroy');
                });

            // Workflow routes (admin only)
            Route::prefix('workflows')->group(function () {
                Route::get('/', [WorkflowController::class, 'index'])->name('admin.workflow.index');
                Route::get('/add', [WorkflowController::class, 'create'])->name('admin.workflow.add');
                Route::post('/', [WorkflowController::class, 'store'])->name('admin.workflow.store');
                Route::get('/detail/{id}', [WorkflowController::class, 'detail'])->name('admin.workflow.detail');
                Route::get('/edit/{id}', [WorkflowController::class, 'edit'])->name('admin.workflow.edit');
                Route::post('/update/{id}', [WorkflowController::class, 'update'])->name('admin.workflow.update');
                Route::get('/delete/{id}', [WorkflowController::class, 'deleteConfirm'])->name('admin.workflow.delete');
                Route::post('/destroy/{id}', [WorkflowController::class, 'destroy'])->name('admin.workflow.destroy');
                // Workflow History
                Route::get('/history/{id}', [WorkflowController::class, 'history'])->name('admin.workflow.history');
                // WorkflowAction CRUD
                Route::get('/action', [WorkflowActionController::class, 'index'])->name('admin.workflow-action.index');
                Route::get('/action/add/{workflow_id}', [WorkflowActionController::class, 'create'])->name('admin.workflow-action.add');
                Route::post('/action/store', [WorkflowActionController::class, 'store'])->name('admin.workflow-action.store');
                Route::get('/action/edit/{id}', [WorkflowActionController::class, 'edit'])->name('admin.workflow-action.edit');
                Route::put('/action/update/{id}', [WorkflowActionController::class, 'update'])->name('admin.workflow-action.update');
                Route::get('/action/delete/{id}', [WorkflowActionController::class, 'deleteConfirm'])->name('admin.workflow-action.delete');
                Route::delete('/action/delete/{id}', [WorkflowActionController::class, 'destroy'])->name('admin.workflow-action.destroy');

                // WorkflowThread CRUD
                Route::get('/thread', [WorkflowThreadController::class, 'index'])->name('admin.workflow-thread.index');
                Route::get('/thread/add/{workflow_id}', [WorkflowThreadController::class, 'create'])->name('admin.workflow-thread.add');
                Route::post('/thread/store', [WorkflowThreadController::class, 'store'])->name('admin.workflow-thread.store');
                Route::get('/thread/edit/{id}', [WorkflowThreadController::class, 'edit'])->name('admin.workflow-thread.edit');
                Route::put('/thread/update/{id}', [WorkflowThreadController::class, 'update'])->name('admin.workflow-thread.update');
                Route::get('/thread/delete/{id}', [WorkflowThreadController::class, 'deleteConfirm'])->name('admin.workflow-thread.delete');
                Route::delete('/thread/delete/{id}', [WorkflowThreadController::class, 'destroy'])->name('admin.workflow-thread.destroy');

            // MANAGE BATAS CEMARAN PESTISIDA
            Route::prefix('/batas-cemaran-pestisida')
                ->group(function () {
                    Route::get('/', [\App\Http\Controllers\BatasCemaranPestisidaController::class, 'index'])->name('admin.batas-cemaran-pestisida.index');
                    Route::get('/add/new', [\App\Http\Controllers\BatasCemaranPestisidaController::class, 'create'])->name('admin.batas-cemaran-pestisida.add');
                    Route::post('/add/new', [\App\Http\Controllers\BatasCemaranPestisidaController::class, 'store'])->name('admin.batas-cemaran-pestisida.store');
                    Route::get('/detail/{id}', [\App\Http\Controllers\BatasCemaranPestisidaController::class, 'detail'])->name('admin.batas-cemaran-pestisida.detail');
                    Route::put('/edit/{id}', [\App\Http\Controllers\BatasCemaranPestisidaController::class, 'update'])->name('admin.batas-cemaran-pestisida.update');
                    Route::get('/edit/{id}', [\App\Http\Controllers\BatasCemaranPestisidaController::class, 'edit'])->name('admin.batas-cemaran-pestisida.edit');
                    Route::get('/delete/{id}', [\App\Http\Controllers\BatasCemaranPestisidaController::class, 'deleteConfirm'])->name('admin.batas-cemaran-pestisida.delete');
                    Route::delete('/delete/{id}', [\App\Http\Controllers\BatasCemaranPestisidaController::class, 'destroy'])->name('admin.batas-cemaran-pestisida.destroy');
                });
            });


        });
});
