<?php

//use App\Domains\Ministry\Http\Controllers\LineMinistriesController;

Route::group(['as' => 'request', 'prefix' => 'requests'], function () {
    Route::get('/', function () {
        return 'I am authenticated';
    });
});

