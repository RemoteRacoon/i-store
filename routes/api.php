<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('orders')->group(function () {

    Route::post('rent/{order}', 'OrderController@rent');
    Route::post('reject/{order}', 'OrderController@reject');

    Route::get('/', 'OrderController@index');
    Route::get('{order}', 'OrderController@show');
    Route::post('{product}', 'OrderController@store');
    Route::put('{order}', 'OrderController@update');
    Route::delete('{order}', 'OrderController@destroy');

});


