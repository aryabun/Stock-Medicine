<?php

use Illuminate\Http\Request;
use  App\Domains\Backend\Http\Controllers\HealthFacilityApiController;

Route::group([
    'prefix' => 'health_facility'
], function () {

    // Route::post('/',[HealthFacilityApiController::class, 'healthFacility']);
    Route::get('/',[HealthFacilityApiController::class, 'index']);
    Route::post('/store', [HealthFacilityApiController::class, 'store']);
    Route::put('/update/{id}', [HealthFacilityApiController::class, 'update']);
    Route::delete('/delete/{id}', [HealthFacilityApiController::class, 'destroy']);

    // Route::get('/province', [HealthFacilityApiController::class, 'province']);
    // Route::post('/district',[HealthFacilityApiController::class, 'district']);
    // Route::post('/commune',[HealthFacilityApiController::class, 'commune']);
    // Route::get('/village',[HealthFacilityApiController::class, 'village']);
    Route::get('/operational_district',[HealthFacilityApiController::class, 'operationalDistrict']);

});

