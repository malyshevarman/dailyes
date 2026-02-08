<?php

Route::group([
    'namespace' => 'Search',
], function () {
    /*
     * Additional
     */
    Route::group([
        'as' => 'search.',
    ], function () {
        Route::get('search', 'SearchController@index')->name('index');
    });

    /*
     * Resource
     */
});
