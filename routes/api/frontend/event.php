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
        'middleware' => 'auth'
    ], function () {
        Route::post('/feature', 'EventController@feature')->name('feature');
        Route::group([
            'prefix' => '{event}',
        ], function () {
            Route::post('/rating', 'EventController@rating')->name('rating');
            Route::post('/recommendation', 'EventController@recommendation')->name('recommendation');
        });
    });

    /*
     * Resource
     */
});
