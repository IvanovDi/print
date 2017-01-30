<?php

Route::get('/', [
    'as' => 'frontend.user_management.index',
    'uses' => 'UserManagementController@index',
]);

Route::post('/send_invitation', [
    'as' => 'frontend.user_management.sendInvitation',
    'uses' => 'UserManagementController@sendInvitation',
]);

Route::delete('/delete/{id}', [
    'as' => 'frontend.user_management.deactivateUser',
    'uses' => 'UserManagementController@deactivateUser',
]);

Route::post('/restore/{id}', [
    'as' => 'frontend.user_management.activateUser',
    'uses' => 'UserManagementController@activateUser',
]);

Route::post('/resend/invitation/{id}', [
    'as' => 'frontend.user_management.resendInvitation',
    'uses' => 'UserManagementController@resendInvitation',
]);