<?php

use Illuminate\Support\Facades\Route;
use Modules\Pages\Http\Controllers\PagesController;

Route::prefix('admin/pages')->group(function () {
    Route::get('/', [PagesController::class, 'index'])->name('pages.index');
    Route::get('/create', [PagesController::class, 'create'])->name('pages.create');
    Route::post('/', [PagesController::class, 'store'])->name('pages.store');
    Route::get('/{id}', [PagesController::class, 'show'])->name('pages.show');
    Route::get('/{id}/edit', [PagesController::class, 'edit'])->name('pages.edit');
    Route::put('/{id}', [PagesController::class, 'update'])->name('pages.update');
    Route::delete('/{id}', [PagesController::class, 'destroy'])->name('pages.destroy');
});
