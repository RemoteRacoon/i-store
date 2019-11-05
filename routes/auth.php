<?php


Route::post('login', 'AuthController@login')->name('login');
Route::post('logout', 'AuthController@logout')->middleware('auth:api')->name('logout');
Route::post('register', 'AuthController@register')->name('register');
