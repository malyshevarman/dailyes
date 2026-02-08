<?php

Route::group([
    'namespace' => 'City',
], function () {
    /*
     * Additional
     */
    Route::group([
        'as' => 'city.',
    ], function () {
        Route::get('', 'CityController@show')->name('show');
        require __DIR__ . '/city/search.php';
        require __DIR__ . '/city/event.php';
        require __DIR__ . '/city/company.php';
    });

    /*
     * Resource
     */
});
