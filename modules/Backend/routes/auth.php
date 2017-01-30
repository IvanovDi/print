<?php

Route::post('login', [
    'as' => 'backend.login',
    'uses' => 'Auth\AdminLoginController@login',
]);
Route::get('login', [
    'as' => 'backend.login_form',
    'uses' => 'Auth\AdminLoginController@showLoginForm',
]);
Route::post('password/email', [
    'as' => 'backend.send_reset_link',
    'uses' => 'Auth\AdminForgotPasswordController@sendResetLinkEmail',
]);
Route::post('password/reset', [
    'as' => 'backend.reset',
    'uses' => 'Auth\AdminResetPasswordController@reset',
]);
Route::get('password/reset/{token}', [
    'as' => 'backend.show_reset_form',
    'uses' => 'Auth\AdminResetPasswordController@showResetForm',
]);
Route::get('password/reset', [
    'as' => 'backend.show_link_form',
    'uses' => 'Auth\AdminForgotPasswordController@showLinkRequestForm',
]);
Route::post('logout', [
    'as' => 'backend.logout',
    'uses' => 'Auth\AdminLoginController@logout',
]);
