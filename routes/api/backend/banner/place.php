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
        Route::post('filter', 'PlaceController@filter')->name('filter');
        Route::get('all', 'PlaceController@all')->name('all');
    });

    /*
     * Resource
     */
    Route::resource('place', 'PlaceController')->only(['store', 'show', 'update', 'destroy']);
});
