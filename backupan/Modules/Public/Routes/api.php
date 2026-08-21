<?php

use Illuminate\Support\Facades\Route;
use Modules\Public\Http\Controllers\PublicController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('publics', PublicController::class)->names('public');
});
