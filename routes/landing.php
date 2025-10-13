<?php

use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Landing Page Routes
|--------------------------------------------------------------------------
|
| Routes for the public-facing landing pages
|
*/

Route::prefix('landing')->group(function () {
    Route::get('/contact', [LandingController::class, 'contact'])->name('landing.contact');
    Route::get('/layanan/cek-data', [LandingController::class, 'cekDataKeamananPangan'])->name('landing.layanan.cek_data');
    Route::post('/layanan/cek-data', [LandingController::class, 'cekDataKeamananPangan'])->name('landing.layanan.cek_data.search');
    Route::get('/layanan/lapor-keamanan', [LandingController::class, 'laporKeamananPangan'])->name('landing.layanan.lapor_keamanan');
    Route::get('/layanan/registrasi-izin', [LandingController::class, 'registrasiIzinProdukPangan'])->name('landing.layanan.registrasi_izin');
    Route::get('/layanan/permintaan-informasi', [LandingController::class, 'permintaanInformasi'])->name('landing.layanan.permintaan_informasi');
    Route::get('/layanan/pembinaan', [LandingController::class, 'pembinaan'])->name('landing.layanan.pembinaan');
    Route::get('/layanan/berita', [LandingController::class, 'berita'])->name('landing.layanan.berita');
    Route::get('/article/detail/{id}', [LandingController::class, 'articleDetail'])->name('landing.article.detail');
    Route::get('/panduan/alur-prosedur', [LandingController::class, 'alurProsedur'])->name('landing.panduan.alur_prosedur');
    Route::get('/panduan/standar-keamanan', [LandingController::class, 'standarKeamananMutuPangan'])->name('landing.panduan.standar_keamanan');
    Route::get('/panduan/batas-cemaran', [LandingController::class, 'batasCemaranResidu'])->name('landing.panduan.batas_cemaran');
    Route::get('/panduan/pembinaan-konsultasi', [LandingController::class, 'pembinaanKonsultasi'])->name('landing.panduan.pembinaan_konsultasi');
    Route::get('/panduan/batas-cemaran/detail/{id}', [LandingController::class, 'batasCemaranResiduDetail'])->name('landing.panduan.batas_cemaran_detail');
});

// QR Code route (moved outside landing prefix to be publicly accessible)
Route::get('/qr/{qr_code}', [LandingController::class, 'showQRDetail'])->name('qr.detail');
