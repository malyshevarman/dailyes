<?php

Route::group([
    'namespace' => 'Event',
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'event',
        'as' => 'event.',
    ], function () {
        Route::get('search/{query}', 'EventController@search')->name('search');
        Route::get('status/{query}', 'EventController@status')->name('status');
        require __DIR__ . '/event/category.php';
    });

    /*
     * Resource
     */
    Route::resource('event', 'EventController')->only(['store', 'show', 'update', 'destroy']);
});
