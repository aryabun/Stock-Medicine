<?php

use Illuminate\Http\Request;
use  App\Domains\Backend\Http\Controllers\PrecriptionApiController;

Route::group([
    'prefix' => 'prescription'
], function () {
    // Route::get('/index',[PatientController::class],'index')->name('patient.index');
    Route::get('/index',[PrecriptionApiController::class, 'index']);
    Route::post('/store',[PrecriptionApiController::class,'store']);
     Route::put('/update/{id}',[PrecriptionApiController::class,'update']);
    Route::delete('/delete/{id}',[PrecriptionApiController::class,'destroy']);
   
});
