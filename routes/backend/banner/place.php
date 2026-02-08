<?php

Route::group([
    'namespace' => 'Place',
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'place',
        'as' => 'place.',
    ], function () {
    });

    /*
     * Resource
     */
    Route::resource('place', 'PlaceController')->only(['index', 'create', 'edit']);
});
