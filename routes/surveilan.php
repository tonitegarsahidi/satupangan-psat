<?php

use App\Http\Controllers\SurveilanController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:ROLE_SUPERVISOR,ROLE_OPERATOR,ROLE_KANTOR,ROLE_PIMPINAN'])->group(function () {
    Route::prefix('notifikasi-surveilan')->group(function () {
        Route::get('/', [SurveilanController::class, 'index'])->name('surveilan.index');
        Route::get('/create-notification', [SurveilanController::class, 'createNotification'])->name('surveilan.create-notification');
        Route::get('/create-notification/{business_id}', [SurveilanController::class, 'createNotificationForBusiness'])->name('surveilan.create-notification-for-business');
        Route::post('/send-notification', [SurveilanController::class, 'sendNotification'])->name('surveilan.send-notification');
    });
});
