<?php

use Illuminate\Http\Request;
use  App\Domains\Backend\Http\Controllers\LifeStyleApiController;

Route::group([
    'prefix' => 'life_style'
], function () {
   
    Route::get('/index', [LifeStyleApiController::class, 'index']);
    Route::post('/store', [LifeStyleApiController::class, 'store']); 
    Route::put('/update/{id}',[LifeStyleApiController::class,'update']);
    Route::delete('/delete/{id}',[LifeStyleApiController::class,'destroy']);

});
