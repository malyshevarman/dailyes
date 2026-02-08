<?php

Route::group([
    'namespace' => 'City',
    'middleware' => ['role:admin']
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'city',
        'as' => 'city.',
    ], function () {

    });

    /*
     * Resource
     */
    Route::resource('city', 'CityController')->only(['index', 'create', 'edit']);
});
