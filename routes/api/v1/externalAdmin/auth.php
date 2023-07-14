<?php

use \App\Domains\External\Http\Controllers\Api\AuthExternalApiController;

Route::group([
    'as' => 'auth.',
    'prefix' => 'auth'
], function () {
    Route::post('/login', [AuthExternalApiController::class, 'login']);
    Route::post('/request-refresh-access-token', [AuthExternalApiController::class, 'getRefreshToken']);
    Route::post('/register', [AuthExternalApiController::class, 'register']);
});

