<?php
Route::resource('products', 'ProductController', [
    'except' => [
        'show'
    ]
]);

Route::get('products/master-templates', [
    'as' => 'master.templates',
    'uses' => 'ProductController@templates',
]);

Route::post('products/{product_id}/price', [
    'as' => 'product.price.store',
    'uses' => 'ProductController@addPrice',
]);

Route::put('products/{product_id}/price/{price_id}', [
    'as' => 'product.price.update',
    'uses' => 'ProductController@updatePrices',
]);

Route::delete('products/{product_id}/price/{price_id}', [
    'as' => 'product.price.delete',
    'uses' => 'ProductController@deletePrice',
]);

Route::post('products/{id}/attach-addons', [
    'as' => 'product.addon.attachAddons',
    'uses' => 'ProductController@attachAddons',
]);

Route::post('products/{id}/detach-addons', [
    'as' => 'product.addon.detachAddons',
    'uses' => 'ProductController@detachAddons',
]);