<?php

use Illuminate\Support\Facades\Route;
use Modules\Media\Http\Controllers\MediaController;

Route::prefix('admin/media')->group(function () {
    Route::get('/', [MediaController::class, 'index'])->name('media.index');
    Route::get('/create', [MediaController::class, 'create'])->name('media.create');
    Route::post('/', [MediaController::class, 'store'])->name('media.store');
    Route::get('/{id}', [MediaController::class, 'show'])->name('media.show');
    Route::get('/{id}/edit', [MediaController::class, 'edit'])->name('media.edit');
    Route::put('/{id}', [MediaController::class, 'update'])->name('media.update');
    Route::delete('/{id}', [MediaController::class, 'destroy'])->name('media.destroy');
});
