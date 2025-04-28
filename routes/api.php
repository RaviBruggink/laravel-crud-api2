<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MissionController;

Route::middleware(['api', 'api_key'])->group(function () {
    Route::apiResource('missions', MissionController::class);
});

