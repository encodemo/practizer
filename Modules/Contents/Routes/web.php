<?php

use Illuminate\Support\Facades\Route;
use Modules\Contents\Http\Controllers\ContentsController;

Route::prefix('admin/contents')->group(function () {
    Route::get('/', [ContentsController::class, 'index'])->name('contents.index');
    Route::get('/create', [ContentsController::class, 'create'])->name('contents.create');
    Route::post('/', [ContentsController::class, 'store'])->name('contents.store');
    Route::get('/{id}', [ContentsController::class, 'show'])->name('contents.show');
    Route::get('/{id}/edit', [ContentsController::class, 'edit'])->name('contents.edit');
    Route::put('/{id}', [ContentsController::class, 'update'])->name('contents.update');
    Route::delete('/{id}', [ContentsController::class, 'destroy'])->name('contents.destroy');
});
