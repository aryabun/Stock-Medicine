<?php

use Illuminate\Http\Request;

use  App\Domains\Backend\Http\Controllers\PatientController;

Route::group([
    'prefix' => 'petient'
], function () {
    // Route::get('/index',[PatientController::class],'index')->name('patient.index');
    Route::get('/index',[PatientController::class, 'index']);
    Route::post('/store',[PatientController::class,'store']);
    Route::put('/update/{id}',[PatientController::class,'update']);
    Route::delete('/delete/{id}',[PatientController::class,'destroy']);
   
});
