<?php

use Illuminate\Http\Request;
use App\Domains\Internal\Http\Controllers\Api\AuthInternalApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::group([ 'as' => 'api.'], function () {
    include __DIR__.'/api/v1/v1.php';
    include __DIR__.'/api/v2/stock.php';
    require __DIR__.'/api/v2/v2.php';
});
