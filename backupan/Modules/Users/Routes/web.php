<?php

use Illuminate\Support\Facades\Route;
use Modules\Users\Http\Controllers\UsersController;

Route::prefix('admin/users')->group(function () {
    Route::get('/', [UsersController::class, 'index'])->name('users.index');
    Route::get('/create', [UsersController::class, 'create'])->name('users.create');
    Route::post('/', [UsersController::class, 'store'])->name('users.store');
    Route::get('/{id}', [UsersController::class, 'show'])->name('users.show');
    Route::get('/{id}/edit', [UsersController::class, 'edit'])->name('users.edit');
    Route::put('/{id}', [UsersController::class, 'update'])->name('users.update');
    Route::delete('/{id}', [UsersController::class, 'destroy'])->name('users.destroy');
});
