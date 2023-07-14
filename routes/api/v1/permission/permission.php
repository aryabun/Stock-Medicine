<?php

use Illuminate\Http\Request;
use App\Domains\Internal\Http\Controllers\Api\HealthFacilityApiController;
use App\Domains\Auth\Http\Controllers\Backend\Permission\PermissionController;

Route::group([
    'prefix' => 'permission'
], function () {
    Route::get('/index',[PermissionController::class, 'index'])->name('permission.index');
    Route::post('/store',[PermissionController::class,'store'])->name('permission.store');
    Route::put('/update/{id}',[PermissionController::class,'update'])->name('permission.update');
    Route::delete('/delete/{id}',[PermissionController::class,'destroy'])->name('permission.destroy');

});