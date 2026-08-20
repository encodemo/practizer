<?php

use Illuminate\Support\Facades\Route;
use Modules\Contents\Http\Controllers\ContentsController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('contents', ContentsController::class)->names('contents');
});
