<?php

Route::group([
    'namespace' => 'Tag',
    'middleware' => ['role:admin']
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'tags',
        'as' => 'tags.',
    ], function () {

    });

    /*
     * Resource
     */
    Route::resource('tags', 'TagController')->only(['index', 'create', 'edit']);
});
