<?php

Route::group([
    'namespace' => 'Page',
    'middleware' => ['role:admin']
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'page',
        'as' => 'page.',
    ], function () {
        Route::post('filter', 'PageController@filter')->name('filter');
    });

    /*
     * Resource
     */
    Route::resource('page', 'PageController')->only(['store', 'show', 'update', 'destroy']);
});
