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

    });

    /*
     * Resource
     */
    Route::resource('slide', 'SlideController')->only(['index', 'create', 'edit']);
});
