<?php

use Illuminate\Http\Request;

Route::group([
    'prefix' => 'v2'
], function () {
    // Route::group(['as' => 'v1'], function () {
    // });

    require __DIR__ . '/backend/health_facility.php';
    require __DIR__ . '/backend/patient.php';
    require __DIR__ . '/backend/screening_data.php';
    require __DIR__ . '/backend/location.php';
    require __DIR__ . '/backend/precription.php';
    require __DIR__ . '/backend/life_style.php';
});
