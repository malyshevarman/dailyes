<?php

Route::group([
    'namespace' => 'City',
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'city',
        'as' => 'city.',
        'middleware' => ['role:admin|moderator']
    ], function () {
        Route::post('filter', 'CityController@filter')->name('filter');
        Route::get('all', 'CityController@all')->name('all');
    });

    /*
     * Resource
     */
    Route::resource('city', 'CityController')->only(['store', 'show', 'update', 'destroy'])->middleware('role:admin');
});
