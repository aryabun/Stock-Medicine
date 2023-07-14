<?php

use Illuminate\Http\Request;
use  App\Domains\Backend\Http\Controllers\LocationApiController;

Route::group([
    'prefix' => 'location',
    'as' => 'location.'
], function () {
    Route::get('/province', [LocationApiController::class, 'province']);
    Route::get('/location',[LocationApiController::class, 'index']);
    Route::get('/district',[LocationApiController::class, 'district']);
    Route::get('/commune',[LocationApiController::class, 'commune']);
    Route::get('/village',[LocationApiController::class, 'village']);
    Route::get('/operational_district',[LocationApiController::class, 'operationalDistrict']);

});

