<?php

use Illuminate\Support\Facades\Route;
use Modules\Data\Http\Controllers\DataController;

Route::prefix('admin/data')->group(function () {
    Route::get('/', [DataController::class, 'index'])->name('data.index');
    Route::get('/create', [DataController::class, 'create'])->name('data.create');
    Route::post('/', [DataController::class, 'store'])->name('data.store');
    Route::get('/{id}', [DataController::class, 'show'])->name('data.show');
    Route::get('/{id}/edit', [DataController::class, 'edit'])->name('data.edit');
    Route::put('/{id}', [DataController::class, 'update'])->name('data.update');
    Route::delete('/{id}', [DataController::class, 'destroy'])->name('data.destroy');
    
    // UI routes untuk import/export
    Route::get('/import', [DataController::class, 'showImportForm'])->name('data.import.show');
    Route::get('/export', [DataController::class, 'showExportOptions'])->name('data.export.show');
});
