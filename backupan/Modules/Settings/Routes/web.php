<?php

use Illuminate\Support\Facades\Route;
use Modules\Settings\Http\Controllers\SettingsController;

Route::prefix('admin/settings')->group(function () {
    Route::get('/', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/', [SettingsController::class, 'store'])->name('settings.store');
    Route::put('/{id}', [SettingsController::class, 'update'])->name('settings.update');
});
