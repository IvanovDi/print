<?php

Route::post('login', [
    'as' => 'frontend.login',
    'uses' => 'Auth\UserLoginController@login',
]);
Route::get('login', [
    'as' => 'frontend.login_form',
    'uses' => 'Auth\UserLoginController@showLoginForm',
]);
Route::get('register', [
    'as' => 'frontend.register',
    'uses' => 'Auth\UserRegisterController@showRegistrationForm',
]);
Route::post('register', [
    'as' => 'frontend.register',
    'uses' => 'Auth\UserRegisterController@register',
]);
Route::post('password/email', [
    'as' => 'frontend.send_reset_link',
    'uses' => 'Auth\UserForgotPasswordController@sendResetLinkEmail',
]);
Route::post('password/reset', [
    'as' => 'frontend.reset',
    'uses' => 'Auth\UserResetPasswordController@reset',
]);
Route::get('password/reset/{token}', [
    'as' => 'frontend.show_reset_form',
    'uses' => 'Auth\UserResetPasswordController@showResetForm',
]);
Route::get('password/reset', [
    'as' => 'frontend.show_link_form',
    'uses' => 'Auth\UserForgotPasswordController@showLinkRequestForm',
]);
Route::post('logout', [
    'as' => 'frontend.logout',
    'uses' => 'Auth\UserLoginController@logout',
]);
Route::get('email/confirm', [
    'as' => 'frontend.email_confirm',
    'uses' => 'Auth\UserRegisterController@confirmEmail',
]);
//invitation
Route::get('/accept/invitation', [
    'as' => 'frontend.accept_invitation.acceptInvitation',
    'uses' => 'Auth\AcceptInvitationController@acceptInvitation',
]);

Route::post('/accept/invitation/password', [
    'as' => 'frontend.accept_invitation.enterPasswordForInvitationUser',
    'uses' => 'Auth\AcceptInvitationController@enterPasswordForInvitationUser',
]);

Route::post('decline/invitation', [
    'as' => 'frontend.decline_invitation.declineInvitation',
    'uses' => 'Auth\AcceptInvitationController@declineInvitation',
]);
