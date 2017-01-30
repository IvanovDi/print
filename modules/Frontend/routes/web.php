<?php

Route::group([
    'middleware' => 'web',
    'namespace' => 'Modules\Frontend\Http\Controllers'
], function () {
    Route::group([
        'middleware' => ['auth:user', 'email.confirm'],
    ], function () {
        Route::get('/', [
            'as' => 'frontend.main',
            'uses' => 'FrontendController@index',
        ]);

        Route::get('/profile', [
            'as' => 'frontend.profile.edit',
            'uses' => 'ProfileController@edit',
        ]);

        Route::post('/profile/update', [
            'as' => 'frontend.profile.update',
            'uses' => 'ProfileController@update'
        ]);

        Route::get('/profile/notification/mark-all', [
            'as' => 'frontend.profile.markAsReadAllNotifications',
            'uses' => 'ProfileController@markAsReadAllNotifications',
        ]);

        Route::get('/profile/notifications', [
            'as' => 'frontend.profile.showNotifications',
            'uses' => 'ProfileController@showNotifications',
        ]);

        Route::get('/account', [
            'as' => 'frontend.account.accountEdit',
            'uses' => 'AccountController@edit'
        ]);

        Route::post('/account/change_email', [
            'as' => 'frontend.account.changeEmail',
            'uses' => 'AccountController@changeEmail',
        ]);

        Route::get('/change/email', [
            'as' => 'frontend.account.showEmailChangeForm',
            'uses' => 'AccountController@showEmailChangeForm',
        ]);

        Route::post('/confirm/password', [
            'as' => 'frontend.account.confirmPassword',
            'uses' => 'AccountController@confirmPassword',
        ]);

        Route::post('/change/password', [
            'as' => 'frontend.account.sendEmailChangePassword',
            'uses' => 'AccountController@sendEmailChangePassword',
        ]);

        Route::get('account/change_password', [
            'as' => 'frontend.account.confirmChangePassword',
            'uses' => 'AccountController@confirmChangePassword'
        ]);

        Route::get('account/cancel_change_email', [
            'as' => 'frontend.account.cancelChangeEmail',
            'uses' => 'AccountController@cancelChangeEmail',
        ]);

        Route::get('account/cancel_change_password', [
            'as' => 'frontend.account.cancelChangePassword',
            'uses' => 'AccountController@cancelChangePassword',
        ]);


        Route::get('account/resend/email', [
            'as' => 'frontend.account.resendEmailConfirm',
            'uses' => 'AccountController@resendEmailConfirm',
        ]);
        Route::group([
            'middleware' => 'is_company',
            'prefix' => 'user_management',
        ], function () {
            require 'blocks/user_management.php';
        });



    });

    require 'auth.php';

    Route::get('category/{categories}', [
        'uses' => 'FrontendController@showCategory'
    ])->where('categories', '.*');

    Route::get('product/{product}', [
        'uses' => 'FrontendController@showProducts'
    ]);
});
