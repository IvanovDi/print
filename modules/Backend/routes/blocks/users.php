<?php

Route::get('/', [
    'as' => 'backend.user.index',
    'uses' => 'UserController@index',
]);

Route::get('/{id}', [
    'as' => 'backend.user.show',
    'uses' => 'UserController@show',
]);

Route::post('/login_as/{id}', [
    'as' => 'backend.user.loginAsUser',
    'uses' => 'UserController@loginAsUser',
]);