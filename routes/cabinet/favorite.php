<?php

Route::group([
    'namespace' => 'Favorite',
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'favorite',
        'as' => 'favorite.',
    ], function () {

    });

    /*
     * Resource
     */
    Route::resource('favorite', 'FavoriteController')->only(['index']);
});
