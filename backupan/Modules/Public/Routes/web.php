<?php

use Illuminate\Support\Facades\Route;
use Modules\Public\Http\Controllers\PublicController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('publics', PublicController::class)->names('public');
});
