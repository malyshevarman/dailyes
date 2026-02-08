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
        Route::group([
            'prefix' => '{event}',
        ], function () {
            Route::get('stat', 'EventController@stat')->name('stat');
        });
    });

    /*
     * Resource
     */
    Route::resource('event', 'EventController')->only(['index', 'create', 'edit']);
});
