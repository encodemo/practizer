<?php

use Illuminate\Support\Facades\Route;
use Modules\Settings\Http\Controllers\SettingsController;

Route::prefix('admin/settings')->name('settings.')->group(function () {
    
    // 1. Root & General Settings
    Route::get('/', [SettingsController::class, 'general'])->name('index');
    Route::get('/general', [SettingsController::class, 'general'])->name('general');
    Route::post('/general', [SettingsController::class, 'updateGeneral'])->name('general.update');

    // 2. Security & Access
    Route::get('/security', [SettingsController::class, 'security'])->name('security');
    Route::post('/security', [SettingsController::class, 'updateSecurity'])->name('security.update');

    // 3. Mail & SMTP
    Route::get('/mail', [SettingsController::class, 'mail'])->name('mail');
    Route::post('/mail', [SettingsController::class, 'updateMail'])->name('mail.update');
    Route::post('/mail/test', [SettingsController::class, 'sendTestMail'])->name('mail.test');

    // 4. Backup & Maintenance
    Route::get('/backup', [SettingsController::class, 'backup'])->name('backup');
    Route::post('/backup/create', [SettingsController::class, 'createBackup'])->name('backup.create');
    Route::get('/backup/download/{filename}', [SettingsController::class, 'downloadBackup'])->name('backup.download');
    Route::delete('/backup/delete/{filename}', [SettingsController::class, 'deleteBackup'])->name('backup.destroy');
    Route::post('/backup/optimize', [SettingsController::class, 'optimize'])->name('backup.optimize');

    // 5. System Logs & Diagnostics
    Route::get('/logs', [SettingsController::class, 'logs'])->name('logs');
    Route::get('/logs/download', [SettingsController::class, 'downloadLogs'])->name('logs.download');
    Route::post('/logs/clear', [SettingsController::class, 'clearLogs'])->name('logs.clear');

});

