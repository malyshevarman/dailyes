<?php

Route::group([
    'namespace' => 'Label',
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'label',
        'as' => 'label.',
    ], function () {
        Route::post('filter', 'LabelController@filter')->name('filter');
        Route::get('all', 'LabelController@all')->name('all');
    });

    /*
     * Resource
     */
    Route::resource('label', 'LabelController')->only(['store', 'show', 'update', 'destroy']);
});
