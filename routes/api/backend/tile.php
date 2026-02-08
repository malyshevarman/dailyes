<?php

Route::group([
    'namespace' => 'Tile',
    'middleware' => ['role:admin']
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'tile',
        'as' => 'tile.',
    ], function () {
        Route::post('filter', 'TileController@filter')->name('filter');
    });

    /*
     * Resource
     */
    Route::resource('tile', 'TileController')->only(['store', 'show', 'update', 'destroy']);
});
