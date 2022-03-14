<?php

use Illuminate\Support\Facades\Route;
use nikitakilpa\SystemJob\Controllers\Controller;

Route::prefix('system-job')->group(function () {
    Route::get('/hello', [Controller::class, 'hello']);

    Route::post('/getIds', [Controller::class, 'getIds']);

    Route::post('/getJobs', [Controller::class, 'getModelsByFilter']);

    Route::post('/create', [Controller::class, 'create']);

    Route::post('/pushCommand', [Controller::class, 'pushJobs']);
});
