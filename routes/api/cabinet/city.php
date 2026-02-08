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
    ], function () {
        Route::get('all', 'CityController@all')->name('all');
    });

    /*
     * Resource
     */
});
