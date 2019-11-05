<?php

Route::get('/', 'UserController@index');
Route::get('{user}', 'UserController@show');
