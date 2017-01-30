<?php
Route::resource('addons', 'AddonController', [
    'except' => [
        'show'
    ]
]);

Route::post('addons/{addon_id}/options', [
    'as' => 'addons.options.store',
    'uses' => 'AddonController@addOptions',
]);

Route::put('addons/{addon_id}/options/{option_id}', [
    'as' => 'addons.options.update',
    'uses' => 'AddonController@updateOptions',
]);

Route::delete('addons/{addon_id}/options/{option_id}', [
    'as' => 'addons.options.delete',
    'uses' => 'AddonController@deleteOptions',
]);