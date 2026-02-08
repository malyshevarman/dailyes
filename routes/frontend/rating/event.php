<?php

Route::group([
    'namespace' => 'Event',
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'stocks',
        'as' => 'event.',
    ], function () {
        Route::get('{tag?}', 'EventController@show')->name('show');
    });

    /*
     * Resource
     */
});
