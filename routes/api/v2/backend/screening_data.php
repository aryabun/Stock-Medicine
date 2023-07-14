<?php
 
 use Illuminate\Http\Request;
 use  App\Domains\Backend\Http\Controllers\ScreeningDataApiController;

 Route::group([
    'prefix' => 'screening/data'
 ],function (){
   
    Route::get('/index',[ScreeningDataApiController::class,'index']);
    Route::post('/store',[ScreeningDataApiController::class,'store']);
    Route::put('/update/{id}',[ScreeningDataApiController::class,'update']);
    Route::delete('/delete/{id}',[ScreeningDataApiController::class,'destroy']);

 });
