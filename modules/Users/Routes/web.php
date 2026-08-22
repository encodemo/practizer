<?php

use Illuminate\Support\Facades\Route;
use Modules\Users\Http\Controllers\UsersController;
use Modules\Users\Http\Controllers\UserGroupController;
use Modules\Users\Http\Controllers\RoleController;
use Modules\Users\Http\Controllers\PermissionController;
use Modules\Users\Http\Controllers\ActivityLogController;

Route::prefix('admin/users')->name('users.')->group(function () {
    
    // 1. All Users Management (Direct Clean RESTful Routes)
    Route::get('/', [UsersController::class, 'index'])->name('index');
    Route::get('/create', [UsersController::class, 'create'])->name('create');
    Route::post('/', [UsersController::class, 'store'])->name('store');
    Route::get('/{id}', [UsersController::class, 'show'])->name('show')->whereNumber('id');
    Route::get('/{id}/edit', [UsersController::class, 'edit'])->name('edit')->whereNumber('id');
    Route::put('/{id}', [UsersController::class, 'update'])->name('update')->whereNumber('id');
    Route::delete('/{id}', [UsersController::class, 'destroy'])->name('destroy')->whereNumber('id');

    // Legacy / Alias routes untuk backward-compatibility jika browser membuka /admin/users/manage
    Route::get('/manage', [UsersController::class, 'index']);
    Route::get('/manage/create', [UsersController::class, 'create']);
    Route::get('/manage/{id}', [UsersController::class, 'show'])->whereNumber('id');
    Route::get('/manage/{id}/edit', [UsersController::class, 'edit'])->whereNumber('id');

    // 2. User Groups
    Route::resource('groups', UserGroupController::class);

    // 3. Roles
    Route::resource('roles', RoleController::class);

    // 4. Permissions
    Route::resource('permissions', PermissionController::class);

    // 5. Activity Logs
    Route::get('/logs', [ActivityLogController::class, 'index'])->name('logs.index');
    Route::get('/logs/{id}', [ActivityLogController::class, 'show'])->name('logs.show')->whereNumber('id');

});
