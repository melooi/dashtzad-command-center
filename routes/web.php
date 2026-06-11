<?php

use App\Http\Controllers\Admin\PanelUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ChangelogController;
use App\Http\Controllers\CommandCenterController;
use App\Http\Controllers\ConnectionsMsgwayController;
use App\Http\Controllers\ConnectionTestController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

// ── Public auth routes (no panel.auth middleware) ─────────────────────────────
Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/login',    [LoginController::class, 'show'])->name('login');
    Route::post('/phone',   [LoginController::class, 'sendOtp'])->name('phone');
    Route::post('/verify',  [LoginController::class, 'verifyOtp'])->name('verify');
    Route::post('/profile', [LoginController::class, 'saveProfile'])->name('profile');
    Route::post('/logout',  [LoginController::class, 'logout'])->name('logout');
});

// ── Protected panel routes ────────────────────────────────────────────────────
Route::middleware(['panel.auth'])->group(function () {

    Route::get('/',          [CommandCenterController::class, 'index']);
    Route::get('/changelog', [ChangelogController::class, 'index']);
    Route::get('/products/quick-create', fn() => view('products.quick-create'));

    Route::post('/connections/test', [ConnectionTestController::class, 'test']);

    // MSGway connection management
    Route::prefix('connections/msgway')->group(function () {
        Route::get('status',     [ConnectionsMsgwayController::class, 'status']);
        Route::post('save',      [ConnectionsMsgwayController::class, 'save']);
        Route::post('test-sms',  [ConnectionsMsgwayController::class, 'testSms']);
        Route::post('disconnect',[ConnectionsMsgwayController::class, 'disconnect']);
    });

    // Settings
    Route::post('/settings/toggle-auth', [SettingsController::class, 'togglePanelAuth']);

    // Admin — panel user management
    Route::prefix('admin/users')->name('admin.users.')->group(function () {
        Route::post('{id}/approve',     [PanelUserController::class, 'approve'])->name('approve');
        Route::post('{id}/reject',      [PanelUserController::class, 'reject'])->name('reject');
        Route::post('{id}/block',       [PanelUserController::class, 'block'])->name('block');
        Route::post('{id}/unblock',     [PanelUserController::class, 'unblock'])->name('unblock');
        Route::post('{id}/role',        [PanelUserController::class, 'updateRole'])->name('role');
    });
});
