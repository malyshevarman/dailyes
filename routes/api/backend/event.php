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
        'middleware' => ['role:admin|moderator']
    ], function () {
        Route::post('filter', 'EventController@filter')->name('filter');
        Route::get('count', 'EventController@count')->name('count');
        Route::get('search/{query}', 'EventController@search')->name('search');
        require __DIR__ . '/event/category.php';
        require __DIR__ . '/event/label.php';
        Route::group([
            'prefix' => '{event}',
        ], function () {
            require __DIR__ . '/event/address.php';
            require __DIR__ . '/event/gallery.php';
        });
    });

    /*
     * Resource
     */
    Route::resource('event', 'EventController')->only(['store', 'show', 'update', 'destroy'])->middleware('role:admin|moderator');
});
