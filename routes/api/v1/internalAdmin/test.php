<?php

use Illuminate\Http\Request;
use App\Domains\Internal\Http\Controllers\Api\TestController;

Route::group([
    'prefix' => 'test'
], function () {
    Route::post('/store', [TestController::class, 'store']);
    Route::get('/show/{id}',[TestController::class, 'show']);
    Route::put('/update/{id}',[TestController::class,'update']);
    Route::get('/index', [TestController::class,'index']);
    Route::delete('/destroy/{id}', [TestController::class,'destroy']);
    Route::get('/province',[TestController::class,'listProvince']);
    Route::get('/district',[TestController::class,'listDistrict']);


});
