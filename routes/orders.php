<?php

Route::post('confirm/{order}', 'OrderController@confirm')->middleware('admin');
Route::post('rent/{order}', 'OrderController@rent');
Route::post('reject/{order}', 'OrderController@reject');

Route::get('/', 'OrderController@index');
Route::get('{order}', 'OrderController@show');
Route::post('{product}', 'OrderController@store');
Route::put('{order}', 'OrderController@update');
Route::delete('{order}', 'OrderController@destroy');

