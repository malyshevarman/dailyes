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

    });

    /*
     * Resource
     */
    Route::resource('tile', 'TileController')->only(['index', 'create', 'edit']);
});
