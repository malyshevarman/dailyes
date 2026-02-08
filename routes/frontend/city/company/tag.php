<?php

Route::group([
    'namespace' => 'Tag',
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'tag',
        'as' => 'tag.',
    ], function () {
        Route::get('{tag?}', 'TagController@show')->name('show');
    });

    /*
     * Resource
     */
});
