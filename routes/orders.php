<?php

Route::post('confirm/{id}', 'OrderController@confirm')->middleware('admin');
Route::post('rent/{id}', 'OrderController@rent');
Route::post('reject/{id}', 'OrderController@reject');

Route::get('/', 'OrderController@index');

Route::put('{id}', 'OrderController@update');
Route::post('{id}', 'OrderController@store');
Route::delete('{id}', 'OrderController@destroy');


