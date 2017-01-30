<?php
Route::resource('category', 'CategoryController', [
    'except' => [
        'show',
    ]
]);

Route::put('category/{id}/active', [
    'as' => 'category.active',
    'uses' => 'CategoryController@activate',
]);

Route::put('category/{id}/inactive', [
    'as' => 'category.inactive',
    'uses' => 'CategoryController@inactivate',
]);

Route::post('category/{id}/attach-products', [
    'as' => 'category.attachProducts',
    'uses' => 'CategoryController@attachProducts',
]);

Route::post('category/{id}/detach-products', [
    'as' => 'category.detachProducts',
    'uses' => 'CategoryController@detachProducts',
]);