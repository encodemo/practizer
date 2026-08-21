<?php

use Illuminate\Support\Facades\Route;
use Modules\Comments\Http\Controllers\CommentsController;

Route::prefix('admin/comments')->group(function () {
    Route::get('/', [CommentsController::class, 'index'])->name('comments.index');
    Route::get('/{id}', [CommentsController::class, 'show'])->name('comments.show');
    Route::put('/{id}', [CommentsController::class, 'update'])->name('comments.update');
    Route::delete('/{id}', [CommentsController::class, 'destroy'])->name('comments.destroy');
});
