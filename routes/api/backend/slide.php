<?php

Route::group([
    'namespace' => 'Slide',
    'middleware' => ['role:admin']
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'slide',
        'as' => 'slide.',
    ], function () {
        Route::post('filter', 'SlideController@filter')->name('filter');
    });

    /*
     * Resource
     */
    Route::resource('slide', 'SlideController')->only(['store', 'show', 'update', 'destroy']);
});
