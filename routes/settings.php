<?php

use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserSettingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| User Settings Routes
|--------------------------------------------------------------------------
|
| Routes for user account settings and preferences
|
*/

Route::middleware('auth')->group(function () {
    Route::prefix('/user-setting')
        ->middleware('role:ROLE_ADMIN,ROLE_OPERATOR,ROLE_SUPERVISOR,ROLE_USER,ROLE_USER_BUSINESS')
        ->group(function () {
            // User settings main page
            Route::get('/', [UserSettingController::class, 'index'])->name('user.setting.index');
            Route::post('/', [UserSettingController::class, 'deactivateAccount'])->name('user.setting.deactivate');

            // Change password section
            Route::get('/change-password', [UserSettingController::class, 'changePasswordPage'])->name('user.setting.changePassword');
            Route::post('/change-password', [UserSettingController::class, 'changePasswordDo'])->name('user.setting.changePassword.do');
        });

    // MANAGE NOTIFICATIONS
    Route::prefix('/notification')
        ->middleware('role:ROLE_ADMIN,ROLE_OPERATOR,ROLE_SUPERVISOR,ROLE_USER,ROLE_USER_BUSINESS')
        ->group(function () {
            Route::get('/', [NotificationController::class, 'index'])->name('notification.index');
            Route::get('/detail/{id}', [NotificationController::class, 'show'])->name('notification.show');
            Route::post('/mark-as-read/{id}', [NotificationController::class, 'markAsRead'])->name('notification.markAsRead');
            Route::post('/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notification.markAllAsRead');
            Route::delete('/delete/{id}', [NotificationController::class, 'destroy'])->name('notification.destroy');
            Route::delete('/delete-read', [NotificationController::class, 'deleteRead'])->name('notification.deleteRead');
            Route::get('/api', [NotificationController::class, 'getNotificationsApi'])->name('notification.api');
            Route::get('/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notification.unreadCount');
            Route::post('/create-system', [NotificationController::class, 'createSystemNotification'])->name('notification.createSystem');
        });

    // MANAGE MESSAGES
    Route::prefix('/message')
        ->group(function () {
            Route::get('/', [MessageController::class, 'index'])->name('message.index');
            Route::get('/detail/{id}', [MessageController::class, 'show'])->name('message.show');
            Route::post('/send/{threadId}', [MessageController::class, 'sendMessage'])->name('message.send');
            Route::post('/create-thread', [MessageController::class, 'createThread'])->name('message.createThread');
            Route::delete('/delete/{id}', [MessageController::class, 'destroy'])->name('message.destroy');
            Route::post('/mark-thread-read/{id}', [MessageController::class, 'markThreadAsRead'])->name('message.markThreadAsRead');
            Route::get('/api', [MessageController::class, 'getThreadsApi'])->name('message.api');
            Route::get('/unread-count', [MessageController::class, 'getUnreadCount'])->name('message.unreadCount');
            Route::get('/conversation/{userId}', [MessageController::class, 'getConversation'])->name('message.conversation');
            Route::get('/search-users', [MessageController::class, 'searchUsers'])->name('message.searchUsers');
        });
});
