<?php

use App\Domains\Internal\Http\Controllers\Api\AuthInternalApiController;

Route::group([
    'as' => 'auth.',
    'prefix' => 'auth'
], function () {
    Route::post('/login', [AuthInternalApiController::class, 'login']);
    Route::post('/request-refresh-access-token', [AuthInternalApiController::class, 'getRefreshToken']);
});

