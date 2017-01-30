<?php

Route::group([
    'middleware' => 'web',
    'prefix' => 'admin',
    'namespace' => 'Modules\Backend\Http\Controllers'
], function () {
    Route::group([
        'middleware' => 'auth:admin',
    ], function () {
        Route::get('/', [
            'as' => 'admin.main',
            'uses' => 'BackendController@index',
        ]);
        Route::group([
            'prefix' => 'users'
        ], function () {
            require 'blocks/users.php';
        });

        require 'blocks/products.php';
        require 'blocks/category.php';
        require 'blocks/addons.php';

    });
    require 'auth.php';

});
