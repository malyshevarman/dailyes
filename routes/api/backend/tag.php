<?php

Route::group([
    'namespace' => 'Tag',
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'tags',
        'as' => 'tags.',
        'middleware' => ['role:admin|moderator']
    ], function () {
        Route::post('filter', 'TagController@filter')->name('filter');
        Route::get('all', 'TagController@all')->name('all');
    });

    /*
     * Resource
     */
    Route::resource('tags', 'TagController')->only(['store', 'show', 'update', 'destroy'])->middleware('role:admin');
});
