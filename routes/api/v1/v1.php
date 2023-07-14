<?php

use Illuminate\Http\Request;

Route::group([
    'prefix' => 'v1'
], function () {
    // Route::group(['as' => 'v1'], function () {
    // });
    require __DIR__ . '/internalAdmin/internal.php';
    require __DIR__ . '/externalAdmin/external.php';
    require __DIR__ . '/permission/permission.php';
});
