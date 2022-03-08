<?php

use Illuminate\Support\Facades\Route;
use nikitakilpa\SystemJob\Controllers\JobController;

Route::prefix('system-job')->group(function () {
    Route::get('/hello', [JobController::class, 'hello']);

    Route::post('/getIds', [JobController::class, 'getIds']);

    Route::post('/getJobs', [JobController::class, 'getModelsByFilter']);

    Route::post('/create', [JobController::class, 'createJob']);

    Route::post('/push', [JobController::class, 'pushJobs']);
});
