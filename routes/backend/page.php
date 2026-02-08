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

    });

    /*
     * Resource
     */
    Route::resource('page', 'PageController')->only(['index', 'create', 'edit']);
});
