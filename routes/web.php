<?php

use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSettingController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\SampleController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\MasterProvinsiController;
use App\Http\Controllers\MasterKelompokPanganController;
use App\Http\Controllers\MasterJenisPanganSegarController;
use App\Http\Controllers\MasterBahanPanganSegarController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home.checkAuth');

Route::get('/home', [HomeController::class, 'index'])->name('home.index');

// Landing Page Routes
Route::prefix('landing')->group(function () {
    Route::get('/contact', [LandingController::class, 'contact'])->name('landing.contact');
    Route::get('/layanan/cek-data', [LandingController::class, 'cekDataKeamananPangan'])->name('landing.layanan.cek_data');
    Route::get('/layanan/lapor-keamanan', [LandingController::class, 'laporKeamananPangan'])->name('landing.layanan.lapor_keamanan');
    Route::get('/layanan/registrasi-izin', [LandingController::class, 'registrasiIzinProdukPangan'])->name('landing.layanan.registrasi_izin');
    Route::get('/layanan/permintaan-informasi', [LandingController::class, 'permintaanInformasi'])->name('landing.layanan.permintaan_informasi');
    Route::get('/panduan/alur-prosedur', [LandingController::class, 'alurProsedur'])->name('landing.panduan.alur_prosedur');
    Route::get('/panduan/standar-keamanan', [LandingController::class, 'standarKeamananMutuPangan'])->name('landing.panduan.standar_keamanan');
    Route::get('/panduan/batas-cemaran', [LandingController::class, 'batasCemaranResidu'])->name('landing.panduan.batas_cemaran');
});


Route::middleware('auth')->group(function () {

    //PROFILE SETTING
    Route::get('/profile', [UserProfileController::class, 'index'])->name('user.profile.index');
    Route::put('/profile', [UserProfileController::class, 'updateOrCreate'])->name('user.profile.update');
    Route::get('/profile/kota-by-provinsi/{provinsiId}', [UserProfileController::class, 'getKotaByProvinsi'])->name('user.profile.kota_by_provinsi');


    // SAMPLE PAGES FOR THIS BOILER PLATE THING....
    // NO FUNCTIONALITY JUST FOR SOME DASHBOARD / CRUD PAGES REFERENCE
    // Route::middleware('verified')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //SAMPLE UI
    Route::prefix('/sample')
        ->middleware('role:ROLE_USER')
        ->group(function () {
            Route::get('cards',         [SampleController::class, 'cards'])->name('sample.cards');
            Route::get('table',         [SampleController::class, 'tablePage'])->name('sample.table');
            Route::get('form1',         [SampleController::class, 'formPage1'])->name('sample.form1');
            Route::get('form2',         [SampleController::class, 'formPage2'])->name('sample.form2');
            Route::get('textdivider',   [SampleController::class, 'textDivider'])->name('sample.textdivider');
            Route::get('blank',         [SampleController::class, 'blank'])->name('sample.blank');
        });


    //This One is for Demo Middleware Routing, so that only who has role can access it
    Route::get('/admin-page',           [AdminController::class, 'index'])->name('admin-page')->middleware('role:ROLE_ADMIN');
    Route::get('/operator-page',        [OperatorController::class, 'index'])->name('operator-page')->middleware('role:ROLE_OPERATOR');
    Route::get('/supervisor-page',      [SupervisorController::class, 'index'])->name('supervisor-page')->middleware('role:ROLE_SUPERVISOR');
    Route::get('/user-page',            [UserController::class, 'userOnlyPage'])->name('user-page')->middleware('role:ROLE_USER');

    // Only users with the 'ROLE_ADMIN' can access this route group
    Route::prefix('/admin')
        ->middleware('role:ROLE_ADMIN')
        ->group(function () {

            // MANAGE USERS ON SYSTEM
            Route::get('/user',                     [UserController::class, 'index'])->name('admin.user.index');
            Route::get('/user/add/new',             [UserController::class, 'create'])->name('admin.user.add');
            Route::post('/user/add/new',            [UserController::class, 'store'])->name('admin.user.store');

            Route::get('/user/detail/{id}',         [UserController::class, 'detail'])->name('admin.user.detail');
            Route::put('/user/edit/{id}',           [UserController::class, 'update'])->name('admin.user.update');
            Route::get('/user/edit/{id}',           [UserController::class, 'edit'])->name('admin.user.edit');
            Route::get('/user/delete/{id}',         [UserController::class, 'deleteConfirm'])->name('admin.user.delete');
            Route::delete('/user/delete/{id}',      [UserController::class, 'destroy'])->name('admin.user.destroy');

            // MANAGE PROVINSI
            Route::prefix('/master-provinsi')
                ->group(function () {
                    Route::get('/',                     [MasterProvinsiController::class, 'index'])->name('admin.master-provinsi.index');
                    Route::get('/add/new',              [MasterProvinsiController::class, 'create'])->name('admin.master-provinsi.add');
                    Route::post('/add/new',             [MasterProvinsiController::class, 'store'])->name('admin.master-provinsi.store');

                    Route::get('/detail/{id}',          [MasterProvinsiController::class, 'detail'])->name('admin.master-provinsi.detail');
                    Route::put('/edit/{id}',            [MasterProvinsiController::class, 'update'])->name('admin.master-provinsi.update');
                    Route::get('/edit/{id}',            [MasterProvinsiController::class, 'edit'])->name('admin.master-provinsi.edit');
                    Route::get('/delete/{id}',          [MasterProvinsiController::class, 'deleteConfirm'])->name('admin.master-provinsi.delete');
                    Route::delete('/delete/{id}',       [MasterProvinsiController::class, 'destroy'])->name('admin.master-provinsi.destroy');
                });
// MANAGE LAPORAN PENGADUAN
Route::prefix('/laporan-pengaduan')
    ->group(function () {
        Route::get('/',                     [\App\Http\Controllers\LaporanPengaduanController::class, 'index'])->name('admin.laporan-pengaduan.index');
        Route::get('/add/new',              [\App\Http\Controllers\LaporanPengaduanController::class, 'create'])->name('admin.laporan-pengaduan.add');
        Route::post('/add/new',             [\App\Http\Controllers\LaporanPengaduanController::class, 'store'])->name('admin.laporan-pengaduan.store');

        Route::get('/detail/{id}',          [\App\Http\Controllers\LaporanPengaduanController::class, 'detail'])->name('admin.laporan-pengaduan.detail');
        Route::put('/edit/{id}',            [\App\Http\Controllers\LaporanPengaduanController::class, 'update'])->name('admin.laporan-pengaduan.update');
        Route::get('/edit/{id}',            [\App\Http\Controllers\LaporanPengaduanController::class, 'edit'])->name('admin.laporan-pengaduan.edit');
        Route::get('/delete/{id}',          [\App\Http\Controllers\LaporanPengaduanController::class, 'deleteConfirm'])->name('admin.laporan-pengaduan.delete');
        Route::delete('/delete/{id}',       [\App\Http\Controllers\LaporanPengaduanController::class, 'destroy'])->name('admin.laporan-pengaduan.destroy');
    });
            // MANAGE CEMARAN MIKROBA
            Route::prefix('/master-cemaran-mikroba')
                ->group(function () {
                    Route::get('/',                     [\App\Http\Controllers\MasterCemaranMikrobaController::class, 'index'])->name('admin.master-cemaran-mikroba.index');
                    Route::get('/add/new',              [\App\Http\Controllers\MasterCemaranMikrobaController::class, 'create'])->name('admin.master-cemaran-mikroba.add');
                    Route::post('/add/new',             [\App\Http\Controllers\MasterCemaranMikrobaController::class, 'store'])->name('admin.master-cemaran-mikroba.store');

                    Route::get('/detail/{id}',          [\App\Http\Controllers\MasterCemaranMikrobaController::class, 'detail'])->name('admin.master-cemaran-mikroba.detail');
                    Route::put('/edit/{id}',            [\App\Http\Controllers\MasterCemaranMikrobaController::class, 'update'])->name('admin.master-cemaran-mikroba.update');
                    Route::get('/edit/{id}',            [\App\Http\Controllers\MasterCemaranMikrobaController::class, 'edit'])->name('admin.master-cemaran-mikroba.edit');
                    Route::get('/delete/{id}',          [\App\Http\Controllers\MasterCemaranMikrobaController::class, 'deleteConfirm'])->name('admin.master-cemaran-mikroba.delete');
                    Route::delete('/delete/{id}',       [\App\Http\Controllers\MasterCemaranMikrobaController::class, 'destroy'])->name('admin.master-cemaran-mikroba.destroy');
                });

            // MANAGE CEMARAN PESTISIDA
            Route::prefix('/master-cemaran-pestisida')
                ->group(function () {
                    Route::get('/',                     [\App\Http\Controllers\MasterCemaranPestisidaController::class, 'index'])->name('admin.master-cemaran-pestisida.index');
                    Route::get('/add/new',              [\App\Http\Controllers\MasterCemaranPestisidaController::class, 'create'])->name('admin.master-cemaran-pestisida.add');
                    Route::post('/add/new',             [\App\Http\Controllers\MasterCemaranPestisidaController::class, 'store'])->name('admin.master-cemaran-pestisida.store');
                    Route::get('/detail/{id}',          [\App\Http\Controllers\MasterCemaranPestisidaController::class, 'detail'])->name('admin.master-cemaran-pestisida.detail');
                    Route::put('/edit/{id}',            [\App\Http\Controllers\MasterCemaranPestisidaController::class, 'update'])->name('admin.master-cemaran-pestisida.update');
                    Route::get('/edit/{id}',            [\App\Http\Controllers\MasterCemaranPestisidaController::class, 'edit'])->name('admin.master-cemaran-pestisida.edit');
                    Route::get('/delete/{id}',          [\App\Http\Controllers\MasterCemaranPestisidaController::class, 'deleteConfirm'])->name('admin.master-cemaran-pestisida.delete');
                    Route::delete('/delete/{id}',       [\App\Http\Controllers\MasterCemaranPestisidaController::class, 'destroy'])->name('admin.master-cemaran-pestisida.destroy');
                });

            // MANAGE KELOMPOK PANGAN
            Route::prefix('/master-kelompok-pangan')
                ->group(function () {
                    Route::get('/',                     [MasterKelompokPanganController::class, 'index'])->name('admin.master-kelompok-pangan.index');
                    Route::get('/add/new',              [MasterKelompokPanganController::class, 'create'])->name('admin.master-kelompok-pangan.add');
                    Route::post('/add/new',             [MasterKelompokPanganController::class, 'store'])->name('admin.master-kelompok-pangan.store');

                    Route::get('/detail/{id}',          [MasterKelompokPanganController::class, 'detail'])->name('admin.master-kelompok-pangan.detail');
                    Route::put('/edit/{id}',            [MasterKelompokPanganController::class, 'update'])->name('admin.master-kelompok-pangan.update');
                    Route::get('/edit/{id}',            [MasterKelompokPanganController::class, 'edit'])->name('admin.master-kelompok-pangan.edit');
                    Route::get('/delete/{id}',          [MasterKelompokPanganController::class, 'deleteConfirm'])->name('admin.master-kelompok-pangan.delete');
                    Route::delete('/delete/{id}',       [MasterKelompokPanganController::class, 'destroy'])->name('admin.master-kelompok-pangan.destroy');
                });

            // MANAGE JENIS PANGAN SEGAR
            Route::prefix('/master-jenis-pangan-segar')
                ->group(function () {
                    Route::get('/',                     [MasterJenisPanganSegarController::class, 'index'])->name('admin.master-jenis-pangan-segar.index');
                    Route::get('/add/new',              [MasterJenisPanganSegarController::class, 'create'])->name('admin.master-jenis-pangan-segar.add');
                    Route::post('/add/new',             [MasterJenisPanganSegarController::class, 'store'])->name('admin.master-jenis-pangan-segar.store');

                    Route::get('/detail/{id}',          [MasterJenisPanganSegarController::class, 'detail'])->name('admin.master-jenis-pangan-segar.detail');
                    Route::put('/edit/{id}',            [MasterJenisPanganSegarController::class, 'update'])->name('admin.master-jenis-pangan-segar.update');
                    Route::get('/edit/{id}',            [MasterJenisPanganSegarController::class, 'edit'])->name('admin.master-jenis-pangan-segar.edit');
                    Route::get('/delete/{id}',          [MasterJenisPanganSegarController::class, 'deleteConfirm'])->name('admin.master-jenis-pangan-segar.delete');
                    Route::delete('/delete/{id}',       [MasterJenisPanganSegarController::class, 'destroy'])->name('admin.master-jenis-pangan-segar.destroy');
                });

            // MANAGE BAHAN PANGAN SEGAR
            Route::prefix('/master-bahan-pangan-segar')
                ->group(function () {
                    Route::get('/',                     [MasterBahanPanganSegarController::class, 'index'])->name('admin.master-bahan-pangan-segar.index');
                    Route::get('/add/new',              [MasterBahanPanganSegarController::class, 'create'])->name('admin.master-bahan-pangan-segar.add');
                    Route::post('/add/new',             [MasterBahanPanganSegarController::class, 'store'])->name('admin.master-bahan-pangan-segar.store');

                    Route::get('/detail/{id}',          [MasterBahanPanganSegarController::class, 'detail'])->name('admin.master-bahan-pangan-segar.detail');
                    Route::put('/edit/{id}',            [MasterBahanPanganSegarController::class, 'update'])->name('admin.master-bahan-pangan-segar.update');
                    Route::get('/edit/{id}',            [MasterBahanPanganSegarController::class, 'edit'])->name('admin.master-bahan-pangan-segar.edit');
                    Route::get('/delete/{id}',          [MasterBahanPanganSegarController::class, 'deleteConfirm'])->name('admin.master-bahan-pangan-segar.delete');
                    Route::delete('/delete/{id}',       [MasterBahanPanganSegarController::class, 'destroy'])->name('admin.master-bahan-pangan-segar.destroy');
                });


            // MANAGE CEMARAN LOGAM BERAT
            Route::prefix('/master-cemaran-logam-berat')
                ->group(function () {
                    Route::get('/',                     [\App\Http\Controllers\MasterCemaranLogamBeratController::class, 'index'])->name('admin.master-cemaran-logam-berat.index');
                    Route::get('/add/new',              [\App\Http\Controllers\MasterCemaranLogamBeratController::class, 'create'])->name('admin.master-cemaran-logam-berat.add');
                    Route::post('/add/new',             [\App\Http\Controllers\MasterCemaranLogamBeratController::class, 'store'])->name('admin.master-cemaran-logam-berat.store');

                    Route::get('/detail/{id}',          [\App\Http\Controllers\MasterCemaranLogamBeratController::class, 'detail'])->name('admin.master-cemaran-logam-berat.detail');
                    Route::put('/edit/{id}',            [\App\Http\Controllers\MasterCemaranLogamBeratController::class, 'update'])->name('admin.master-cemaran-logam-berat.update');
                    Route::get('/edit/{id}',            [\App\Http\Controllers\MasterCemaranLogamBeratController::class, 'edit'])->name('admin.master-cemaran-logam-berat.edit');
                    Route::get('/delete/{id}',          [\App\Http\Controllers\MasterCemaranLogamBeratController::class, 'deleteConfirm'])->name('admin.master-cemaran-logam-berat.delete');
                    Route::delete('/delete/{id}',       [\App\Http\Controllers\MasterCemaranLogamBeratController::class, 'destroy'])->name('admin.master-cemaran-logam-berat.destroy');
                });

            // MANAGE CEMARAN MIKROTOKSIN
            Route::prefix('/master-cemaran-mikrotoksin')
                ->group(function () {
                    Route::get('/',                     [\App\Http\Controllers\MasterCemaranMikrotoksinController::class, 'index'])->name('admin.master-cemaran-mikrotoksin.index');
                    Route::get('/add/new',              [\App\Http\Controllers\MasterCemaranMikrotoksinController::class, 'create'])->name('admin.master-cemaran-mikrotoksin.add');
                    Route::post('/add/new',             [\App\Http\Controllers\MasterCemaranMikrotoksinController::class, 'store'])->name('admin.master-cemaran-mikrotoksin.store');

                    Route::get('/detail/{id}',          [\App\Http\Controllers\MasterCemaranMikrotoksinController::class, 'detail'])->name('admin.master-cemaran-mikrotoksin.detail');
                    Route::put('/edit/{id}',            [\App\Http\Controllers\MasterCemaranMikrotoksinController::class, 'update'])->name('admin.master-cemaran-mikrotoksin.update');
                    Route::get('/edit/{id}',            [\App\Http\Controllers\MasterCemaranMikrotoksinController::class, 'edit'])->name('admin.master-cemaran-mikrotoksin.edit');
                    Route::get('/delete/{id}',          [\App\Http\Controllers\MasterCemaranMikrotoksinController::class, 'deleteConfirm'])->name('admin.master-cemaran-mikrotoksin.delete');
                    Route::delete('/delete/{id}',       [\App\Http\Controllers\MasterCemaranMikrotoksinController::class, 'destroy'])->name('admin.master-cemaran-mikrotoksin.destroy');
                });

            // MANAGE KOTA
            Route::prefix('/master-kota')
                ->group(function () {
                    Route::get('/',                     [\App\Http\Controllers\MasterKotaController::class, 'index'])->name('admin.master-kota.index');
                    Route::get('/add/new',              [\App\Http\Controllers\MasterKotaController::class, 'create'])->name('admin.master-kota.add');
                    Route::post('/add/new',             [\App\Http\Controllers\MasterKotaController::class, 'store'])->name('admin.master-kota.store');

                    Route::get('/detail/{id}',          [\App\Http\Controllers\MasterKotaController::class, 'detail'])->name('admin.master-kota.detail');
                    Route::put('/edit/{id}',            [\App\Http\Controllers\MasterKotaController::class, 'update'])->name('admin.master-kota.update');
                    Route::get('/edit/{id}',            [\App\Http\Controllers\MasterKotaController::class, 'edit'])->name('admin.master-kota.edit');
                    Route::get('/delete/{id}',          [\App\Http\Controllers\MasterKotaController::class, 'deleteConfirm'])->name('admin.master-kota.delete');
                    Route::delete('/delete/{id}',       [\App\Http\Controllers\MasterKotaController::class, 'destroy'])->name('admin.master-kota.destroy');
                });

            // Workflow routes (admin only)
            Route::prefix('workflows')->group(function () {
                Route::get('/', [\App\Http\Controllers\WorkflowController::class, 'index'])->name('admin.workflow.index');
                Route::get('/add', [\App\Http\Controllers\WorkflowController::class, 'create'])->name('admin.workflow.add');
                Route::post('/', [\App\Http\Controllers\WorkflowController::class, 'store'])->name('admin.workflow.store');
                Route::get('/detail/{id}', [\App\Http\Controllers\WorkflowController::class, 'detail'])->name('admin.workflow.detail');
                Route::get('/edit/{id}', [\App\Http\Controllers\WorkflowController::class, 'edit'])->name('admin.workflow.edit');
                Route::post('/update/{id}', [\App\Http\Controllers\WorkflowController::class, 'update'])->name('admin.workflow.update');
                Route::get('/delete/{id}', [\App\Http\Controllers\WorkflowController::class, 'deleteConfirm'])->name('admin.workflow.delete');
                Route::post('/destroy/{id}', [\App\Http\Controllers\WorkflowController::class, 'destroy'])->name('admin.workflow.destroy');
            // Workflow History
            Route::get('/history/{id}', [\App\Http\Controllers\WorkflowController::class, 'history'])->name('admin.workflow.history');
                // WorkflowAction CRUD
                Route::get('/action', [\App\Http\Controllers\WorkflowActionController::class, 'index'])->name('admin.workflow-action.index');
                Route::get('/action/add/{workflow_id}', [\App\Http\Controllers\WorkflowActionController::class, 'create'])->name('admin.workflow-action.add');
                Route::post('/action/store', [\App\Http\Controllers\WorkflowActionController::class, 'store'])->name('admin.workflow-action.store');
                Route::get('/action/edit/{id}', [\App\Http\Controllers\WorkflowActionController::class, 'edit'])->name('admin.workflow-action.edit');
                Route::put('/action/update/{id}', [\App\Http\Controllers\WorkflowActionController::class, 'update'])->name('admin.workflow-action.update');
                Route::get('/action/delete/{id}', [\App\Http\Controllers\WorkflowActionController::class, 'deleteConfirm'])->name('admin.workflow-action.delete');
                Route::delete('/action/delete/{id}', [\App\Http\Controllers\WorkflowActionController::class, 'destroy'])->name('admin.workflow-action.destroy');

                // WorkflowThread CRUD
                Route::get('/thread', [\App\Http\Controllers\WorkflowThreadController::class, 'index'])->name('admin.workflow-thread.index');
                Route::get('/thread/add/{workflow_id}', [\App\Http\Controllers\WorkflowThreadController::class, 'create'])->name('admin.workflow-thread.add');
                Route::post('/thread/store', [\App\Http\Controllers\WorkflowThreadController::class, 'store'])->name('admin.workflow-thread.store');
                Route::get('/thread/edit/{id}', [\App\Http\Controllers\WorkflowThreadController::class, 'edit'])->name('admin.workflow-thread.edit');
                Route::put('/thread/update/{id}', [\App\Http\Controllers\WorkflowThreadController::class, 'update'])->name('admin.workflow-thread.update');
                Route::get('/thread/delete/{id}', [\App\Http\Controllers\WorkflowThreadController::class, 'deleteConfirm'])->name('admin.workflow-thread.delete');
                Route::delete('/thread/delete/{id}', [\App\Http\Controllers\WorkflowThreadController::class, 'destroy'])->name('admin.workflow-thread.destroy');
            });
        });



    Route::prefix('/user-setting')
        ->middleware('role:ROLE_ADMIN,ROLE_OPERATOR,ROLE_SUPERVISOR,ROLE_USER')
        ->group(function () {
            // Only users with the 'ROLE_USER' or 'ROLE_OPERATOR' role can access this route
            Route::get('/', [UserSettingController::class, 'index'])->name('user.setting.index');
            Route::post('/', [UserSettingController::class, 'deactivateAccount'])->name('user.setting.deactivate');

            //change password section
            Route::get('/change-password', [UserSettingController::class, 'changePasswordPage'])->name('user.setting.changePassword');
            Route::post('/change-password', [UserSettingController::class, 'changePasswordDo'])->name('user.setting.changePassword.do');
        });


    Route::prefix('/demo')
        ->middleware('role:ROLE_USER')
        ->group(function () {
            // Only users which has the 'ROLE_USER'can access this route
            Route::get('/', [DemoController::class, 'index'])->name('demo');
            Route::get('/print', [DemoController::class, 'print'])->name('demo.print');
        });
});


Route::get('/register/kota-by-provinsi/{provinsiId}', [UserProfileController::class, 'getKotaByProvinsi'])->name('register.kota_by_provinsi');

require __DIR__ . '/auth.php';

if (config('saas.SAAS_ACTIVATED')) {
    require __DIR__ . '/saas.php';
}
